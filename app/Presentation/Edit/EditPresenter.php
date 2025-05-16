<?php
namespace App\Presentation\Edit;

use Nette;
use Nette\Application\UI\Form;

final class EditPresenter extends Nette\Application\UI\Presenter
{
	public function __construct(
		private Nette\Database\Explorer $database,
	) {}

  public function startup(): void
  {
	  parent::startup();

	  if (!$this->getUser()->isLoggedIn()) {
		  $this->redirect('Sign:in');
	  }
  }

  protected function createComponentPostForm(): Form
  {
    $form = new Form;

    $form->addText('title', 'Title:')
      ->setRequired('Please enter a title.');

    $form->addTextArea('content', 'Content:')
      ->setRequired('Please enter some content.');

    $form->addSubmit('send', 'Save and publish');

    $form->onSuccess[] = $this->postFormSucceeded(...);

    $renderer = $form->getRenderer();
    $renderer->wrappers['controls']['container'] = 'dl';
    $renderer->wrappers['pair']['container'] = null;
    $renderer->wrappers['label']['container'] = 'dt';
    $renderer->wrappers['control']['container'] = 'dd';

    return $form;
  }

  private function postFormSucceeded(array $data): void
  {
    $id = $this->getParameter('id');

    if ($id) {
		  $post = $this->database
			  ->table('posts')
			  ->get($id);
		  $post->update($data);
	  } else {
		  $post = $this->database
			  ->table('posts')
			  ->insert($data);
    }

    $this->flashMessage('Post published successfully.', 'success');
    $this->redirect('Post:show', $post->id);
  }

  public function renderEdit(int $id): void
  {
    $post = $this->database
      ->table('posts')
  		->get($id);

  	if (!$post) {
  		$this->error('Post not found');
  	}

  	$this->getComponent('postForm')
  		->setDefaults($post->toArray());
  }
}

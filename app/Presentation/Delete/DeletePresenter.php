<?php

namespace App\Presentation\Delete;

use Nette;
use Nette\Application\UI\Form;

final class DeletePresenter extends Nette\Application\UI\Presenter
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

  protected function createComponentDeleteForm(): Form
  {
    $form = new Form;

    $form->addText('title', 'Title:')->setDisabled();

    $form->addTextArea('content', 'Content:')->setDisabled();

    $form->addSubmit('send', 'Yes, destroy this post now')->setHtmlAttribute('class', 'btn-danger');

    $form->onSuccess[] = $this->deleteFormSucceeded(...);

    $renderer = $form->getRenderer();
    $renderer->wrappers['controls']['container'] = 'dl';
    $renderer->wrappers['pair']['container'] = null;
    $renderer->wrappers['label']['container'] = 'dt';
    $renderer->wrappers['control']['container'] = 'dd';

    return $form;
  }

  private function deleteFormSucceeded(array $data): void
  {
    $id = $this->getParameter('id');

    if ($id) {
		  $post = $this->database
			  ->table('posts')
			  ->get($id);

      $post->delete();

      $this->flashMessage('Post deleted.', 'success');
      $this->redirect('Home:');
    }
  }

  public function renderDelete(int $id): void
  {
    $post = $this->database
      ->table('posts')
  		->get($id);

  	if (!$post) {
  		$this->error('Post not found');
  	}

  	$this->getComponent('deleteForm')
  		->setDefaults($post->toArray());
  }
}

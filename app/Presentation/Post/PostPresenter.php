<?php
namespace App\Presentation\Post;

use Nette;
use Nette\Application\UI\Form;

final class PostPresenter extends Nette\Application\UI\Presenter
{
	public function __construct(
		private Nette\Database\Explorer $database,
	) {
	}

	public function renderShow(int $id): void
	{
		$post = $this->database
			->table('posts')
      ->get($id);

    if (!$post) {
      $this->error('Post not found');
    }

    $this->template->post = $post;
    $this->template->comments = $post->related('comments')
      ->order('created_at');
	}

  protected function createComponentCommentForm(): Form
  {
    $form = new Form;

    $form->addText('name', 'Your name:')
      ->setRequired('Please enter your name.');

    $form->addEmail('email', 'Email:');

    $form->addTextArea('content', 'Comment:')
      ->setRequired('Please enter a comment.');

    $form->addSubmit('send', 'Add Comment');

    $form->onSuccess[] = $this->commentFormSucceeded(...);

    return $form;
  }

  private function commentFormSucceeded(\stdClass $data): void
  {
    $this->database->table('comments')->insert([
      'post_id' => $this->getParameter('id'),
      'name' => $data->name,
      'content' => $data->content,
      'email' => $data->email
    ]);

    $this->flashMessage('Comment added successfully.', 'success');
    $this->redirect('this');
  }
}


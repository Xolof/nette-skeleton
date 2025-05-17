<?php

namespace App\Presentation\Sign;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

final class SignPresenter extends Presenter
{
    protected function createComponentSignInForm(): Form
    {
        $form = new Form;

        $form->addText('username', 'Username:')
            ->setRequired('Please enter your username.');

        $form->addPassword('password', 'Password:')
            ->setRequired('Please enter your password.');

        $form->addSubmit('send', 'Sign in');

        $form->onSuccess[] = $this->signInFormSucceeded(...);

        $renderer = new Nette\Forms\Rendering\DefaultFormRenderer();
        $form->setRenderer($renderer);
        $renderer->wrappers['controls']['container'] = 'dl';
        $renderer->wrappers['pair']['container'] = null;
        $renderer->wrappers['label']['container'] = 'dt';
        $renderer->wrappers['control']['container'] = 'dd';

        return $form;
    }

  private function signInFormSucceeded(Form $form, \stdClass $data): void
  {
	    try {
          $this->getUser()->login($data->username, $data->password);
          $this->flashMessage('You have been signed in.', 'success');
          $this->redirect('Home:');
  	  } catch (Nette\Security\AuthenticationException $e) {
	  	    $form->addError('Incorrect username or password.');
	    }
  }

    public function actionOut(): void
    {
        $this->getUser()->logout();
        $this->flashMessage('You have been signed out.', 'success');
        $this->redirect('Home:');
    }
}

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

        return $form;
    }

  private function signInFormSucceeded(Form $form, \stdClass $data): void
  {
	    try {
          $this->getUser()->login($data->username, $data->password);
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

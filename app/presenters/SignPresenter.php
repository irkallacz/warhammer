<?php
use Nette\Application\UI,
	Nette\Security as NS;

class SignPresenter extends BasePresenter{
	/** @persistent */
	public $backlink = '';

	/**
	 * Sign in form component factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm(){
		$form = new UI\Form;
		$form->addText('mail', 'E-mail:',50)
			->setRequired('Vyplňte prosím e-mail')
			->setDefaultValue('@');

		$form->addPassword('password', 'Heslo:',50)
			->setRequired('Vyplňte prosím heslo.');

		$form->addSubmit('send', 'Přihlásit');

		$form->onSuccess[] = callback($this, 'signInFormSubmitted');
		return $form;
	}

  public function signInFormSubmitted($form){
    try {
      $values = $form->getValues();
      $this->getUser()->login($values->mail, $values->password);
      $this->getUser()->setExpiration(0, TRUE);
      $this->restoreRequest($this->backlink);
      $this->redirect('Wargear:');

    } catch (NS\AuthenticationException $e) {
    	$form->addError($e->getMessage());
		}
	}

	public function actionOut(){
    $this->getUser()->logout();
		$this->flashMessage('Právě jste se odhlásil.');
		$this->redirect('in');
	}

}

<?php
/**
 * Created by PhpStorm.
 * User: Kseniia Bashkova
 * Date: 04.01.2019
 * Time: 23:57
 */


namespace App\Presenters;
use Nette\Application\UI\Form;

class SignPresenter extends \Nette\Application\UI\Presenter
{
    protected function createComponentSignInForm()
    {
        $form = new Form;
        $form->addText('username')
//            ->setRequired('Prosím vyplňte své uživatelské jméno.');
            ->setType('email')
            ->setRequired();

        $form->addPassword('password', 'Heslo:')
            ->setRequired();

        $form->addSubmit('send', 'Přihlásit');

        $form->onSuccess[] = [$this, 'signInFormSucceeded'];

        return $form;
    }


    public function signInFormSucceeded(Form $form, \stdClass $values)
    {

        try {
            $this->getUser()->login($values->username, $values->password);
            $this->redirect('Homepage:');

        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError('Nesprávné přihlašovací jméno nebo heslo.');
        }
    }


    public function actionOut()
    {
        $this->getUser()->logout();
        $this->flashMessage('Odhlášení bylo úspěšné.');
        $this->redirect('Homepage:');
    }
}


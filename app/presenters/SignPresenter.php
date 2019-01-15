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
//    Vytvoreni formulare a validace na urovni jednotlivych polozek
    protected function createComponentSignInForm()
    {
        $form = new Form;
        $form->addText('username')
            ->setType('email')
            ->setRequired();

        $form->addPassword('password', 'Heslo:')
            ->setRequired();

        $form->addSubmit('send', 'Přihlásit');

    //Po uspesnem vytvoreni volame finkce signInFormSucceeded
        $form->onSuccess[] = [$this, 'signInFormSucceeded'];

        return $form;
    }


    /**
     * @param Form $form
     * @param \stdClass $values
     * @throws \Nette\Application\AbortException
     */
    public function signInFormSucceeded(Form $form, \stdClass $values)
    {
    //Kontrola username a password. Pokud je vsechno v pohode "redirect -> Homepage", pokud ne "error masage"
        try {
            $this->getUser()->login($values->username, $values->password);
            $this->redirect('Homepage:');

        } catch (\Nette\Security\AuthenticationException $e) {
            $form->addError('The username or password is incorrect.');
        }
    }

    //Log out

    /**
     * @throws \Nette\Application\AbortException
     */
    public function actionOut()
    {
        $this->getUser()->logout();
        $this->flashMessage('Log Out Success.');
        $this->redirect('Homepage:');
    }
}


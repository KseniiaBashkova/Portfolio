<?php

namespace App\Presenters;


use Nette\Application\UI\Form;

class RegistrationPresenter extends \Nette\Application\UI\Presenter
{
    //    pripojeni k databazi

    private $database;

    public function __construct(\Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    //formulář a validace na úrovni jednotlivých políček

    protected function createComponentFormRegistration()
    {

        $form = new \Nette\Application\UI\Form();

        $form->addText('name', 'Name')->setRequired('please');
//            ->addRule($form::);

        $form->addEmail('email', 'Email')->setRequired('Please enter email')
        ->addRule(Form::EMAIL, 'email neplatny');

        $form->addPassword('pwd', 'Password')
            ->setRequired('Please, enter password')
            ->addRule(Form::MIN_LENGTH, 'Your password has to be at least %d long', 5);

//        $form->addPassword('pwd2', 'Password (again)')
//            ->setRequired('Please enter password for verification')
//            ->addRule($form::EQUAL, 'Password verification failed. Passwords do not match', $passwordInput);

        $form->addSubmit('register', 'Register');

        // volá se po úspěšném odeslání formuláře
        $form->onSuccess[] = function() use ($form) {
            $values = $form->getValues();
            $this->database->table('user')->insert([
                'name' => $values->name,
                'email' => $values->email,
                'password_hash' => \Nette\Security\Passwords::hash($values->pwd),
            ]);
        };

        $form->onSuccess[] = function() {
            $this->redirect('Homepage:default');
        };

        return $form;
    }
}


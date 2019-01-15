<?php

namespace App\Presenters;


use Nette\Application\UI\Form;

class RegistrationPresenter extends \Nette\Application\UI\Presenter
{
    //    pripojeni k databazi

    private $database;

    /**
     * RegistrationPresenter constructor.
     * @param \Nette\Database\Context $database
     */
    public function __construct(\Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    //formulář a validace na úrovni jednotlivých položek

    /**
     * @return Form
     */
    protected function createComponentFormRegistration()
    {

        $form = new \Nette\Application\UI\Form();

        $form->addText('name', 'Name')
            ->setRequired('please');

        $form->addEmail('email', 'Email')
            ->setRequired('Please enter email')
            ->addRule(Form::EMAIL, 'email neplatny');

        $form->addPassword('pwd', 'Password')
            ->setRequired('Please, enter password');


        $form->addSubmit('register', 'Register');

        $form->addProtection("zakaz");

        // volá se po úspěšném odeslání formuláře
        $form->onSuccess[] = function() use ($form) {
            $values = $form->getValues();
            $lastId = (int)$this->database->fetch('SELECT MAX("id") FROM "user"')['max'] + 1;

            $this->database->table('user')->insert([
                'id' => $lastId,
                'name' => $values->name,
                'email' => $values->email,
                // Zahashuje heslo
                'password_hash' => \Nette\Security\Passwords::hash($values->pwd),
            ]);
        };

        $form->onSuccess[] = function() {
            $this->redirect('Homepage:default');
        };

        return $form;
    }
}


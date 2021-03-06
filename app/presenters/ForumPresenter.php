<?php


namespace App\Presenters;

use Nette\Application\UI\Form;

class ForumPresenter extends  \Nette\Application\UI\Presenter
{
//    pripojeni k databazi
    private $database;

    /**
     * ForumPresenter constructor.
     * @param \Nette\Database\Context $database
     */
    public function __construct(\Nette\Database\Context $database)
    {
        $this->database = $database;
    }

//    Tato funkce vypisuji username na Forum a zapisuje data do databazy a sortuje je podle "date"

    /**
     * @param $postId
     * @throws \Nette\Application\AbortException
     */
    public function renderDefault($postId)
    {
//      Jestli uzivatel prehlasen vezme s database name a vypise ve Forum
        if ($this->getUser()-> isLoggedIn()){
        $this->template->user = $this->getUser()->getIdentity()->getData()['name'];
    }
//      Pokud neprihlasen - presmeruje uzivatele na stranku Sign
        else{
//            $this->error('Pro vytvoření, nebo editování příspěvku se musíte přihlásit.');

            $this->redirect('Sign:default');

        }
//      Vypise na strance Forum 'content' z tabulky 'posts' a udela sort podle 'id'
        $this->template->content = $this->database->table('posts')
//            Sort v opacnem poradi
            ->order('id DESC')->limit(100);
    }

    // Tato funkce vytvori formular na strance Forum.
    protected function createComponentCommentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $form->addTextArea('content', 'Content')->setRequired();

        $form->addSubmit('send', 'Send');

        // volá se po úspěšném odeslání formuláře


        $form->onSuccess[] = function () use ($form) {
            $values = $form->getValues();
            $lastId = (int)$this->database->fetch('SELECT MAX("id") FROM "posts"')['max'] + 1;

//          Vlkadani prvku do tabulky 'posts' in database
            $this->database->table('posts')->insert([
                'id' => $lastId,
                'autor' => $this->getUser()->getIdentity()->getData()['name'],
                'content' => $values->content,
                'created_at' => date('d.m.Y')
            ]);
        };

        $form->onSuccess[] = function() {
            $this->redirect('Forum:default');
        };

        return $form;
    }

}
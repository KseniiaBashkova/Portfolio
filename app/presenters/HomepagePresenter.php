<?php

namespace App\Presenters;

use App\Helper\ImageStorage;
use Nette;
use Nette\Utils\Image;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /**@var ImageStorage*/
    public $imageStorage;


    public function injectImage(ImageStorage $storage){
        $this->imageStorage = $storage;

    }

//    public

    public function renderDefault()
    {
        $directory = "images/";
        $images = glob($directory . "*.jpg");
        $this->template->posts = $images;
//        $this->template->user = $this->getUser()->getIdentity()->getData()['name'];

//        $this->template->posts = $this->database->table('posts')
//            ->order('created_at DESC')
//            ->limit(5);

    }


}


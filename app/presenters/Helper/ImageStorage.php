<?php

namespace App\Helper;


/**
 * Created by PhpStorm.
 * User: Kseniia Bashkova
 * Date: 02.01.2019
 * Time: 20:04
 */

use Nette\SmartObject;

class ImageStorage
{

    private $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function save($file, $contents)
    {
        file_put_contents($this->dir.'/'.$file,$contents);
    }


}
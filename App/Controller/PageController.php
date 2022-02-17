<?php

namespace App\Controller;

use Core\BaseController;

class PageController extends BaseController
{
    public function home()
    {
        echo $this->view->load('home');
    }

    public function addproduct()
    {
        echo $this->view->load('addproduct');
    }
}
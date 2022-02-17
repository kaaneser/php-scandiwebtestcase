<?php

namespace Core;

class Starter {

    public $router;
    public $db;
    public $view;

    public function __construct()
    {
        $this->router = new Router();
        $this->db = new Database();
        $this->view = new View();
    }

}
<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index()
    {
        $this->render('login', ['message'=>"Hello World!"]);
    }

    public function select_hobbies()
    {
        $this->render('select_hobbies');
    }
}
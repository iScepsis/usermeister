<?php


namespace controllers;


use app\mvc\Controller;

class UsersController extends Controller
{
    /**
     * @return string
     * @throws \Exception
     */
    public function index(){

        return $this->render('index', ['bad' => 3]);
        //echo "It's work!";
    }
}
<?php


namespace controllers;


use app\mvc\Controller;
use models\User;

class UsersController extends Controller
{
    /**
     * @return string
     * @throws \Exception
     */
    public function index(){
        $user = new User();
        return $this->render('index', ['users' => $user->findAll()]);
    }
}
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

    public function save(){
        $user = empty($_POST['id']) ? new User() : new User($_POST['id']);
        $user->load($_POST);
        if ($user->save()) {
            return ['result' => 'true', 'lastInsertId' => $user->db->lastInsertId];
        } else {
            return ['result' => 'false', 'errors' => $user->getDbErrors(true)];
        };
    }
}
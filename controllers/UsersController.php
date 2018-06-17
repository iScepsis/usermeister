<?php


namespace controllers;


use app\mvc\Controller;
use models\City;
use models\User;

class UsersController extends Controller
{
    /**
     * @return string
     * @throws \Exception
     */
    public function index(){
        $user = new User();
        $cities = new City();
        return $this->render('index', [
            'users' => $user->findAll(),
            'cities' => $cities->findAll()
        ]);
    }

    public function save(){
        $user = empty($_POST['id']) ? new User() : new User($_POST['id']);
        $user->load($_POST);
        if ($user->save()) {
            return json_encode([
                'result' => 'true',
                'lastInsertId' => $user->db->lastInsertId
            ]);
        } else {
            return json_encode([
                'result' => 'false',
                'errors' => $user->getErrors()
            ]);
        };
    }
}
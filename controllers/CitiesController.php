<?php


namespace controllers;


use app\mvc\Controller;
use models\City;

class CitiesController extends Controller
{
    /**
     * @return string
     * @throws \Exception
     */
    public function index(){
        $cities = new City();
        return $this->render('index', [
            'cities' => $cities->findAll()
        ]);
    }

    public function save(){
        $user = empty($_POST['id']) ? new City() : new City($_POST['id']);
        $user->load($_POST);
        if ($user->save()) {
            return json_encode([
                'result' => 'true',
                'lastInsertId' => $user->db->lastInsertId
            ]);
        } else {
            return json_encode([
                'result' => 'false',
                'errors' => $user->getDbErrors(true)
            ]);
        }
    }
}
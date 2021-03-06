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
        $city = empty($_POST['id']) ? new City() : new City($_POST['id']);
        $city->load($_POST);
        if ($city->save()) {
            return json_encode([
                'result' => 'true',
                'lastInsertId' => $city->db->lastInsertId
            ]);
        } else {
            return json_encode([
                'result' => 'false',
                'errors' => $city->getErrors(true)
            ]);
        }
    }
}
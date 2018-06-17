<?php


namespace controllers;


use app\mvc\Controller;

class NotFoundController extends Controller
{
    /**
     * @return string
     * @throws \Exception
     */
    public function index(){
        return $this->render('404');
    }
}
<?php


namespace controllers;


use app\mvc\Controller;

class NotFoundController extends Controller
{
    public function index(){
        echo "404!";
    }
}
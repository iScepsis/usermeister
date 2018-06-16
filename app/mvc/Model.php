<?php


namespace app\mvc;


abstract class Model
{
    /**
     * @var array - человеко-понятное описание свойств объекта
     */
    public static $attributes = [];

    /**
     * @var array - массив для складирования ошибок при валидации, сохранении в БД и т.п.
     */
    public $errors = [];

    public function validate():bool{
        return true;
    }

    public function getErrors(){
        return $this->errors;
    }

    public function addValidationError(string $field, $message):void{
        $this->errors['validation'][$field][] = $message;
    }
}
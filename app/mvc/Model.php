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
    public $errors = [
        'db' => [],
        'validation' => [],
    ];

    public function validate():bool{
        return true;
    }

    public function getErrors(){
        return $this->errors;
    }

    public function addValidationError(string $field, $message):void{
        if (empty($this->errors['validation'][$field])) {
            $this->errors['validation'][$field] = [];
        }
        $this->errors['validation'][$field]['invalidMessage'] = $message;
    }
}
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

    /**
     * Правила валидации (индивидуальны для кажной модели)
     * @return bool
     */
    public function validate():bool{
        return true;
    }

    /**
     * Получаем массив с ошибками
     * @return array
     */
    public function getErrors(){
        return $this->errors;
    }

    /**
     * Добавляем ошибку валидации в общий массив ошибок модели
     * @param string $field - название поля в котором обнаружена ошибка
     * @param $message - сообщение которое будет выведено пользователю
     */
    public function addValidationError(string $field, $message):void{
        if (empty($this->errors['validation'][$field])) {
            $this->errors['validation'][$field] = [];
        }
        $this->errors['validation'][$field]['invalidMessage'] = $message;
    }
}
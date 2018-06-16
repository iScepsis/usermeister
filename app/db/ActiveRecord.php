<?php


namespace app\db;


use app\mvc\Model;
use config\Config;

abstract class ActiveRecord extends Model
{
    public static $tableName = '';
    public $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    /**
     * Загружаем данные из массива в объект, где ключ массива равен названию свойства в объекте
     * @param array $data
     */
    public function load(array $data):void{
        foreach ($data as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
    }

    /**
     * Берем все данные из таблицы (в настройках по-умолчанию - максимум 1000 строк)
     * @return array|bool
     */
    public function findAll(){
        return $this->db->query("select * from " . static::$tableName . " limit " . Config::$maxSelectRowLimit);
    }

    public function save(){
        if (empty($this->id)) {
            return $this->_insert();
        } else {
            return $this->_update();
        }
    }

    protected function _insert(){}

    protected function _update(){}

    /**
     * Возвращаем ошибки уровня БД
     * @param bool $asString - возвращаем как строку
     * @return array|string
     */
    public function getDbErrors($asString = false){
        if ($asString) {
            return implode(PHP_EOL, $this->db->getErrors());
        } else {
            return $this->db->getErrors();
        }

    }
}
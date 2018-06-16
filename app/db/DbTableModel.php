<?php
/**
 *
 */

namespace app\db;

use app\mvc\Model;
use config\Config;

abstract class DbTableModel extends Model
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

    /**
     * Добавляем или изменяем запись, в зависимости от ее существования  в БД
     */
    public function save(){
        if (!$this->validate()) return false;
        if (empty($this->id)) {
            $result = $this->_insert();
        } else {
            $result = $this->_update();
        }
        if (!$result) $this->errors['db'][] = $this->db->getErrors();
        return $result;
    }

    /**
     * Вставляем запись в БД
     */
    protected function _insert(){}

    /**
     * Обновляем запись в БД
     */
    protected function _update(){}

    /**
     * Возвращаем ошибки уровня БД
     * @param bool $asString - возвращаем как строку
     * @return array|string
     */
    /*public function getDbErrors($asString = false){
        if ($asString) {
            return implode(PHP_EOL, $this->db->getErrors());
        } else {
            return $this->db->getErrors();
        }

    }*/
}
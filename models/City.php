<?php


namespace models;


use app\db\ActiveRecord;
use config\Config;

class City extends ActiveRecord
{
    public static $tableName = "cities";

    public $id = null;
    public $city = null;

    public static $attributes = [
        'id' => 'Id города',
        'city' => 'Название города',
    ];

    public function __construct(int $id = null){
        parent::__construct();

        if (!is_null($id)) $this->load($this->findOne($id));
    }

    /**
     * Ищем единственную строку из таблицы по id
     * @param int $id
     * @return null
     */
    public function findOne(int $id){
        $data = $this->db->query("select * from " . self::$tableName . " where id = :id", ['id' => $id]);
        if (!empty($data)) {
            return $data[0];
        } else {
            return null;
        }
    }

    /**
     * Добавляем нового пользователя
     * @return bool
     */
    protected function _insert(){
        $query = "insert into " . self::$tableName . " (city) values (:city)";
        return $this->db->execute($query, [
            'city' => $this->city,
        ]);
    }

    /**
     * Обновлением данные пользователя
     * @return bool
     */
    protected function _update(){
        $query = "update " . self::$tableName . " set city = :city where id = :id";
        return $this->db->execute($query, [
            'id' => $this->id,
            'city' => $this->city,
        ]);
    }
}
<?php
/**
 *  Модель для работы с городами
 */

namespace models;

use app\db\DbTableModel;

class City extends DbTableModel
{
    public static $tableName = "cities";

    public $id = null;
    public $city = null;

    public static $attributes = [
        'id' => 'Id города',
        'city' => 'Название города',
    ];

    public function validate():bool{
        if (!preg_match("/^[А-ЯЁ][А-ЯЁa-яё\s-]{2,30}$/", $this->city)) {
            $this->addValidationError('city', 'Название города не корректно. Название должно начинаться с большой
             буквы и может содержать  только русские символы, знаки дефиса и пробелы');
            return false;
        }
        return true;
    }

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
     * @override
     */
    protected function _insert(){
        $query = "insert into " . self::$tableName . " (city) values (:city)";
        return $this->db->execute($query, [
            'city' => $this->city,
        ]);
    }

    /**
     * @override
     */
    protected function _update(){
        $query = "update " . self::$tableName . " set city = :city where id = :id";
        return $this->db->execute($query, [
            'id' => $this->id,
            'city' => $this->city,
        ]);
    }
}
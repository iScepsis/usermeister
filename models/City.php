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
        if (empty($this->id)) {
            $row = $this->db->query('select id from ' . self::$tableName . ' where city = trim(:city)', [
               'city' => $this->city
            ]);
            if (!empty($row)) {
                $this->addValidationError('city', 'Город с таким названием уже существует');
                return false;
            }
        }
        if (!preg_match("/^[А-ЯЁ][А-ЯЁa-яё\s-]{2,29}$/", $this->city)) {
            $this->addValidationError('city',
                'Название города должно начинаться с заглавной буквы и может содержать только русские символы, знаки дефиса и пробелы');
            return false;
        }
        return true;
    }

    /**
     * City constructor.
     * @param int|null $id
     */
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
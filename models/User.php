<?php


namespace models;


use app\db\ActiveRecord;

class User extends ActiveRecord
{
    public $id;
    public $name;
    public $age;
    public $city_id;

    public static $attributes = [
        'id' => 'Id пользователя',
        'name' => 'Имя пользователя',
        'age' => 'Возраст',
        'city_id' => 'Город',
    ];

    public static $tableName = 'users';

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

    public function findAll(){
        $query = "select
                    u.id
                  , u.name
                  , u.age
                  , u.city_id
                  , c.city
                from " . self::$tableName . " u
                left join " . City::$tableName . " c on u.city_id = c.id";
        return $this->db->query($query);
    }


}
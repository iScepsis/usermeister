<?php


namespace models;


use app\db\ActiveRecord;
use config\Config;

class User extends ActiveRecord
{
    public $id = null;
    public $name = null;
    public $age = null;
    public $city_id = null;

    public static $attributes = [
        'id' => 'Id',
        'name' => 'Имя',
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
     * @return array|null
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
     * Ищем все значения справочника (не превышая лимит $maxSelectRowLimit заданный в конфигурации )
     * @return array|bool
     */
    public function findAll(){
        $query = "select
                    u.id
                  , u.name
                  , u.age
                  , u.city_id
                  , c.city
                from " . self::$tableName . " u
                left join " . City::$tableName . " c on u.city_id = c.id
                order by u.id limit " . Config::$maxSelectRowLimit ;
        return $this->db->query($query);
    }


    /**
     * Добавляем нового пользователя
     * @return bool
     */
    protected function _insert(){
        $query = "insert into " . self::$tableName . " (name, age, city_id) values (:name, :age, :city_id)";
        return $this->db->execute($query, [
            'name' => $this->name,
            'age' => $this->age,
            'city_id' => $this->city_id,
        ]);
    }

    /**
     * Обновлением данные пользователя
     * @return bool
     */
    protected function _update(){
        $query = "update " . self::$tableName . " set
                    name = :name
                   , age = :age
                   , city_id = :city_id
                  where id = :id";
        return $this->db->execute($query, [
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->age,
            'city_id' => $this->city_id,
        ]);
    }


}
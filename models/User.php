<?php
/**
 * Модель для работы с пользователями
 */

namespace models;


use app\db\DbTableModel;
use config\Config;

class User extends DbTableModel
{
    public static $tableName = 'users';

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

    public function validate():bool{
        if (!preg_match("/^[А-ЯЁ][А-ЯЁa-яё\s-]{2,30}$/", $this->name)) {
            $this->addValidationError(
                'name',
                'Имя должно начинаться с большой буквы и может содержать только русские символы, знаки дефиса и пробелы'
            );
            return false;
        }
        if (!preg_match("/^\d{1,3}$/", $this->age) || $this->age < 0 || $this->age > 120) {
            $this->addValidationError('age', 'Возраст должен быть числом от 1 до 120');
            return false;
        }
        return true;
    }

    /**
     * User constructor.
     * @param int|null $id
     * @override
     */
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
     * @override
     *
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
     * @override
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
     * @override
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
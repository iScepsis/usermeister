<?php


namespace app\db;


use app\mvc\Model;

abstract class ActiveRecord extends Model
{
    public static $tableName = '';
    public $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function load(array $data){
        foreach ($data as $key => $val) {
            if (property_exists($this, $key)) {
                $this->$key = $val;
            }
        }
    }

    public function findAll(){
        return $this->db->query("select * from " . self::$tableName);
    }
}
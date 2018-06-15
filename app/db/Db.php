<?php


namespace app\db;

use config\Config;
use PDO;
use PDOException;

class Db {
    private $db;
    protected static $_instance;

    public $lastInsertId = null;
    protected $errors = [];

    private function __construct() {
        $this->db = new PDO(
            "mysql:host=" . Config::$db['host'] .
            ";dbname=" . Config::$db['dbname'],
            Config::$db['user'],
            Config::$db['pass']
        );
    }

    private function __clone(){
    }
    /**
     * Статическая функция, которая возвращает
     * экземпляр класса или создает новый при
     * необходимости
     * @return Db
     */
    public static function getInstance():self {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     * @param $sql - тело запроса
     * @param null $params - массив с параметрами
     * @return array|bool
     */
    public function query($sql, $params=null){
        try {
            $stmt = $this->db->prepare($sql);
            if (!empty($params)) {
                foreach ($params as $key => $val) {
                    $stmt->bindValue($key, $val);
                }
            }
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            $this->errors[] = $e->getMessage() . ":" . $e->getLine();
            return false;
        }
    }
    /**
     * Запрос на insert с возвращением последнего вставленного id
     * @param $sql - тело запроса
     * @param null $params - массив с параметрами
     * @return bool
     */
    public function execute($sql, $params=null):bool{
        try {

            $stmt = $this->db->prepare($sql);
           // $stmt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (!empty($params)) {
                foreach ($params as $key => $val) {
                    if (empty($val)) $val = null;
                    $stmt->bindValue($key, $val);
                }
            }
            $stmt->execute();
            if ($this->db->lastInsertId()) $this->lastInsertId = $this->db->lastInsertId();
            return true;
        } catch (PDOException $e) {
            $this->errors[] = $e->getMessage() . ":" . $e->getLine();
            return false;
        }
    }

    public function __destruct()
    {
        $this->db = null;
    }

    /**
     * Возвращаем массив с ошибками
     * @return array
     */
    public function getErrors(){
        return $this->errors;
    }
}
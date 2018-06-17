<?php

class UserTest extends \Codeception\Test\Unit
{


    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        require_once __DIR__.'/../../app/autoload.php';
    }

    protected function _after()
    {
    }

    /**
     * Проверяем загрузку полей в объект
     * */
    public function testUserLoad(){
        $user = new \models\User();
        $user->load([
            'id' => 7,
            'name' => 'Иван',
            'age' => 30,
            'city_id' => 13
        ]);
        $this->assertEquals(7, $user->id);
        $this->assertEquals('Иван', $user->name);
        $this->assertEquals(30, $user->age);
        $this->assertEquals(13, $user->city_id);
    }

    /**
     * Проверяем валидацию обязательных полей
     */
    public function testUserValidation()
    {
        $user = new \models\User();
        //Проверяем валидацию
        $user->name = 'not_valid_name';
        $user->age = 12;
        $this->assertFalse($user->validate());
        $user->name = 'Петр';
        $user->age = -3;
        $this->assertFalse($user->validate());
        $user->name = 'Петр';
        $user->age = 44;
        $this->assertTrue($user->validate());

    }

    /**
     * Проверяем вставку пользователей
     */
    public function testUserInsert(){
        $user = new \models\User();
        $user->name = 'Петр';
        $user->age = 44;
        $this->assertTrue($user->save());
        $this->assertNotEmpty($user->db->lastInsertId);
        \app\helpers\TestHelper::$insertedId = $user->db->lastInsertId;
    }

    /**
     * Проверяем, что при передаче конструктору id пользователя, его данные подтянутся в модель
     */
    public function testUserConstructor(){
        $user = new \models\User(\app\helpers\TestHelper::$insertedId);
        $this->assertEquals(\app\helpers\TestHelper::$insertedId, $user->id);
        $this->assertEquals('Петр', $user->name);
        $this->assertEquals(44, $user->age);
    }

    /**
     * Проверяем обновление пользователя
     */
    public function testUserUpdate(){
        $user = new \models\User();
        $user->load([
            'id' => \app\helpers\TestHelper::$insertedId,
            'name' => 'Джозендапус',
            'age' => 7,
        ]);
        $this->assertTrue($user->save());
        $user = null;
        $user = new \models\User(\app\helpers\TestHelper::$insertedId);
        $this->assertEquals('Джозендапус', $user->name);
        $this->assertEquals(7, $user->age);
        $delete = $user->db->execute('delete from ' . $user::$tableName . ' where id = :id', [
            'id' => \app\helpers\TestHelper::$insertedId
        ]);
        $this->assertTrue($delete);
    }




}
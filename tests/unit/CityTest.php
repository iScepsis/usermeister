<?php

class CityTest extends \Codeception\Test\Unit
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

    // tests
    public function testSomeFeature()
    {

    }

    /**
     * Проверяем загрузку полей в объект
     * */
    public function testCityLoad(){
        $city = new \models\City();
        $city->load([
            'id' => 7,
            'city' => 'Москва',
        ]);
        $this->assertEquals(7, $city->id);
        $this->assertEquals('Москва', $city->city);
    }

    /**
     * Проверяем валидацию обязательных полей
     */
    public function testCityValidation()
    {
        $city = new \models\City();
        //Проверяем валидацию
        $city->city = 'not_valid_city';
        $this->assertFalse($city->validate());
        $city->city = 'Архангельск';
        $this->assertTrue($city->validate());

    }

    /**
     * Проверяем вставку города
     */
    public function testCityInsert(){
        $city = new \models\City();
        $city->city = 'Екатеринбург';
        $this->assertTrue($city->save());
        $this->assertNotEmpty($city->db->lastInsertId);
        \app\helpers\TestHelper::$insertedId = $city->db->lastInsertId;
    }

    /**
     * Проверяем, что при передаче конструктору id города, его данные подтянутся в модель
     */
    public function testCityConstructor(){
        $city = new \models\City(\app\helpers\TestHelper::$insertedId);
        $this->assertEquals(\app\helpers\TestHelper::$insertedId, $city->id);
        $this->assertEquals('Екатеринбург', $city->city);
    }

    /**
     * Проверяем обновление пользователя
     */
    public function testCityUpdate(){
        $city = new \models\City();
        $city->load([
            'id' => \app\helpers\TestHelper::$insertedId,
            'city' => 'Томск',
        ]);
        $this->assertTrue($city->save());
        $city = null;
        $city = new \models\City(\app\helpers\TestHelper::$insertedId);
        $this->assertEquals('Томск', $city->city);
        $delete = $city->db->execute('delete from ' . $city::$tableName . ' where id = :id', [
            'id' => \app\helpers\TestHelper::$insertedId
        ]);
        $this->assertTrue($delete);
    }
}
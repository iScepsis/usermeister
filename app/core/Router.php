<?php
/**
 * Роутер проекта - данный класс парсит url запрашиваемой страницы и по полученному результату создает запрашиваемый
 * контроллер и запускает у него запрошенный экшн.
 */

namespace app\core;


use app\mvc\Controller;
use config\Config;
use controllers\NotFoundController;

class Router
{
    /**
     * @var string контроллер который вызывается по умолчанию если не передавалось имя конкретного контроллера
     */
    public static $defaultController = '';
    /**
     * @var string экшен который будет вызван по умолчанию если не передавалось имя конкретного экшена
     */
    public static $defaultAction = '';
    /**
     * @var array url распарсенный на части
     */
    public static $url = [];
    /**
     * @var string имя текущего контроллера
     */
    public static $controller = '';
    /**
     * @var string имя текущего экшена
     */
    public static $action = '';

    /**
     * Разбираем url и запускаем вызываемый контроллер и экшен
     */
    public static function run(){
        self::_parseUri();
        $controller = self::_getController();
        $action = self::_getAction($controller);
        $controller->beforeAction();
        echo $controller->$action();
        $controller->afterAction();
    }

    /**
     * Ворзвращаем имя экшена в верблюжьей нотации, а также проверяем - есть ли такой экшен в контроллере
     * @param Controller $controller
     * @return string
     */
    protected static function _getAction(Controller &$controller):string{
        $action = lcfirst(self::toCamelCase(self::$action));

        if (method_exists($controller, $action)) {
            return $action;
        } else {
            $controller = new NotFoundController();
            return 'index';
        }
    }

    /**
     * Возвращаем объект контроллера если тот существует, если нет - возвращаем контроллер страницы 404 статуса
     * @return Controller
     */
    protected static function _getController():Controller {
        $controllerName = "controllers\\" . self::toCamelCase((self::$controller)) . "Controller";
        if (self::checkControllerExists(self::$controller) && class_exists($controllerName)) {
            return new $controllerName;
        } else {
            self::$action = 'index';
            self::$controller = 'not-found';
            return new NotFoundController();
        }
    }

    /**
     * Приводим строку к верблюжьей нотации
     * @param string $name
     * @return string
     */
    public static function toCamelCase(string $name):string {
        $name = str_replace(["_"], "-", $name);
        $nameParts = explode("-", $name);
        foreach ($nameParts as $key => $part) {
            $nameParts[$key] = ucfirst($part);
        }
        return implode("", $nameParts);
    }

    /**
     * Парсим URI на части, выделяем controller, action и аргументры, которые принимаем как в виде prettyUrl (/key/val),
     * так и в обычном (?key=val&key2=val2...)
     */
    protected static function _parseUri():void{
        //Парсим pretty Url
        $url = [];
        $url['hostName'] = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
        $requestPath = explode('?', $_SERVER['REQUEST_URI']);
        $url['base'] = trim(dirname($_SERVER['SCRIPT_NAME']), '\/');
        $url['call'] = substr(urldecode($requestPath[0]), strlen($url['base']) + 1);
        $url['parts'] = explode('/', strtolower($url['call']));

        //Присваиваем контроллер и экшен
        self::$controller = empty($url['parts'][2]) ? self::$defaultController : $url['parts'][2];
        self::$action = empty($url['parts'][3]) ? self::$defaultAction : $url['parts'][3];

        if (count($url['parts']) > 4) {
            for ($i = 4; $i < count($url['parts']); $i+=2) {
                $key = $url['parts'][$i];
                $val = $url['parts'][$i+1] ?? "";
                $url['query_vars'][$key] = $val;
            }
        }

        //Если переданы параметры через "?" - парсим их как аргументы
        if (!empty($requestPath[1])) {
            $url['query'] = urldecode($requestPath[1]);
            $vars = explode('&', $url['query']);
            foreach ($vars as $var) {
                $param = explode('=', $var);
                $url['query_vars'][$param[0]] = $param[1];
            }
        }
        self::$url = $url;
    }

    /**
     * Проверяем существует ли файл контроллера в директории controllers
     * @param string $controllerName
     * @return bool
     */
    protected static function checkControllerExists(string $controllerName){
        $controllerPath = Config::$rootDir . "/controllers/" . self::toCamelCase(($controllerName)) . "Controller.php";
        return file_exists($controllerPath);
    }

}
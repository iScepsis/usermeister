<?php


namespace app\mvc;


use app\core\Router;
use config\Config;

abstract class Controller
{
    public $name;
    public $layout = 'main';

    /**
     * Операции которые необходимо выполнить перед запуском экшена
     */
    public function beforeAction(){

    }

    /**
     * Операции которые необходимо выполнить после запуска экшена
     */
    public function afterAction(){

    }

    /**
     * Рендерим страницу. Путь до отображения строится из директории для вьюх настроенной в конфиге (Config::$viewsDir)
     * + имя контроллера (если рендер вызван из контроллера) + аргумент $viewPath
     *
     * @param string $viewPath - название отображения
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function render(string $viewPath, array $params = []):string {
        $view = new View();
        $view->controllerName = Router::$controller;
        $view->params = array_merge($view->params, $params);
        $view->params['content'] = $view->render($viewPath, $params);
        return $view->render($this->getLayoutFile(), [], true);
    }

    /**
     * Получаем абсолютный путь до макета страницы
     * @return string
     */
    public function getLayoutFile():string {
        return Config::$layoutsDir . DIRECTORY_SEPARATOR . $this->layout . '.php';
    }

}
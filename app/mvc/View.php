<?php

namespace app\mvc;


use config\Config;

class View
{
    /**
     * @var string Имя контроллера из которого вызван объект
     */
    public $controllerName = '';
    /**
     * @var array параметры которые будут переданы отображению и преобразованы в переменные
     */
    public $params = [];
    /**
     * @var string заголовок страницы
     */
    public $title = '';

    /**
     * Рендерим php файл и возвращаем его содержимое как строку
     *
     * @param string $viewPath - путь до файла (абсолютный для макета, относительный для обычных отображений)
     * @param array $params - параметры которые должны быть переданы во вьюху
     * @param bool $isLayout - флаг говорящий о том, что рендерим - макет или обычную вьюху
     * @return string
     * @throws \Exception
     */
    public function render(string $viewPath, array $params = [], bool $isLayout = false):string {
        $this->params = array_merge($this->params, $params);
        extract($this->params);

        if ($isLayout) {
            $path = $viewPath;
        } else {
            $path = Config::$viewsDir . DIRECTORY_SEPARATOR;
            if (!empty($this->controllerName)) $path .= $this->controllerName . DIRECTORY_SEPARATOR;
            $path .= $viewPath . '.php';
        }
        try {
            if (file_exists($path)) {
                ob_start();
                include($path);
                $result = ob_get_contents();
                ob_end_clean();
                return $result;
            } else {
                throw new \Exception("View {$path} not found");
            }
        } catch (\Exception $e) {
            //TODO: Запилить обработчик ошибок
            die("View not found: " . $e->getMessage() . ' Line: ' . $e->getLine());
        }

    }
}
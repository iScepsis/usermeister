<?php
/**
 * Файл реализующий автозагрузку классов по namespace
 */

spl_autoload_register(
    function ($className) {
        include_once str_replace("\\", "/", $className) . ".php";
    }
);
<?php

use app\core\Router;
use config\Config;

    /** @var string $content */
?>

<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= Router::$url['hostName'] . '/' . basename(Config::$rootDir) ?>/" />
    <title><?= $this->title ?></title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="assets/js/main.js"></script>
</head>
<body>
    <div id="wrap">
        <aside id="aside">
            <h1 id="logo-text">Usermeister</h1>
            <div id="logo">
                <img src="assets/img/logo.jpg" alt="usermeister" class="center">
            </div>
            <ul class="menu">
                <li>
                    <a href="index.php/users/index">- Пользователи -</a>
                </li>
                <li>
                    <a href="index.php/cities/index">- Города -</a>
                </li>
            </ul>
        </aside>
        <div id="container">
            <?= $content ?>
        </div>
    </div>

</body>
</html>

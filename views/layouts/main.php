<?php

use config\Config;

    /** @var string $content */
?>

<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="/<?= basename(Config::$rootDir) ?>/" />
    <title><?= $this->title ?></title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="assets/js/main.js"></script>
</head>
<body>
    <header>
        <aside>
            <!-- left aside -->
        </aside>
        <div>
            <!-- logo -->
        </div>
        <aside>
            <!-- right aside -->
        </aside>
    </header>
    <div class="container">
        <?= $content ?>
    </div>

</body>
</html>

<?php
use models\City;

$this->title = "Города";

/**
 * @var $cities array
 */
?>

<h1 class="text-center">Список городов</h1>

<br>

<div class="city-wrap">
    <table class="city-table">
        <thead>
        <th style="width:20%"><?= City::$attributes['id']; ?></th>
        <th style="width:80%"><?= City::$attributes['city']; ?></th>
        </thead>
        <tbody>
        <?php foreach ($cities as $city):?>
            <tr class="city-row">
                <td class="city-id"><?= $city['id'] ?></td>
                <td class="city-city i-input"><?= $city['city'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <br>

    <div class="text-center">
        <button class="button add-city">
            + Добавить город
        </button>
    </div>
</div>

<script src="assets/js/cities.js" type="text/javascript"></script>
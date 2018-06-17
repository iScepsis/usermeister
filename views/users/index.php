<?php
use models\User;

$this->title = "Пользователи";

/**
 * @var $users array
 * @var $cities array
 */
?>

<h1 class="text-center">Список пользователей</h1>

<br>

<div class="user-wrap">
    <table class="users-table">
        <thead>
            <th style="width:12%"><?= User::$attributes['id']; ?></th>
            <th style="width:38%"><?= User::$attributes['name']; ?></th>
            <th style="width:12%"><?= User::$attributes['age']; ?></th>
            <th style="width:38%"><?= User::$attributes['city_id']; ?></th>
        </thead>
        <tbody>
        <?php foreach ($users as $user):?>
            <tr class="user-row">
                <td class="user-id"><?= $user['id'] ?></td>
                <td class="user-name i-input"><?= $user['name'] ?></td>
                <td class="user-age i-input"><?= $user['age'] ?></td>
                <td class="user-city i-city-select" data-city_id="<?= $user['city_id'] ?>">
                    <?= $user['city'] ?? 'Город не выбран' ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <br>

    <div class="text-center">
        <button class="button add-user">
            + Добавить пользователя
        </button>
    </div>
</div>

<script type="text/javascript">var cities=<?=json_encode($cities)?></script>
<script src="assets/js/users.js" type="text/javascript"></script>
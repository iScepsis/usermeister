<?php
use models\User;

$this->title = "Пользователи";

/**
 * @var $users array
 */
?>
<div class="user-wrap">
    <table class="users-table" border="1">
        <thead>
            <th><?= User::$attributes['id']; ?> </th>
            <th><?= User::$attributes['name']; ?> </th>
            <th><?= User::$attributes['age']; ?> </th>
            <th><?= User::$attributes['city_id']; ?> </th>
        </thead>
        <tbody>
        <?php foreach ($users as $user):?>
            <tr class="user-row">
                <td class="user-id">  <?= $user['id'] ?></td>
                <td class="user-name i-input"><?= $user['name'] ?></td>
                <td class="user-age i-input"><?= $user['age'] ?></td>
                <td class="user-city i-city-select" data-city_id="<?= $user['city_id'] ?>">
                    <?= $user['city'] ?? '<span class="muted">Город не выбран</span>' ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div>
        <button class="add-user">
            Добавить пользователя
        </button>
    </div>
</div>



<script src="assets/js/users.js" type="text/javascript"></script>
<?php
use models\User;

$this->title = "Пользователи";

/**
 * @var $users array
 */
?>

<table class="users">
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
                <td class="user-name"><?= $user['name'] ?></td>
                <td class="user-age"><?= $user['age'] ?></td>
                <td class="user-city" data-city_id="<?= $user['city_id'] ?>">
                    <?= $user['city'] ?? '<span class="muted">Город не выбран</span>' ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div>
    <button class="">
        Добавить пользователя
    </button>
</div>


<script></script>
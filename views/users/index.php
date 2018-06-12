<?php
use models\User;

$this->title = "Пользователи";

/**
 * @var $users array
 */
?>

<table>
    <thead>
        <th><?= User::$attributes['id']; ?> </th>
        <th><?= User::$attributes['name']; ?> </th>
        <th><?= User::$attributes['age']; ?> </th>
        <th><?= User::$attributes['city_id']; ?> </th>
    </thead>
    <tbody>
        <?php foreach ($users as $user):?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['age'] ?></td>
                <td><?= $user['city'] ?? '<span class="muted">Город не выбран</span>' ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


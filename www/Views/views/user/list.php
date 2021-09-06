<table>
    <thead>
        <th>ID</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Status</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td><?= $user['firstname'] ?></td>
                <td><?= $user['lastname'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['status'] ?></td>
                <td>
                    <a href="/user/<?= $user['id'] ?>">Edit</a>
                    <a href="/user/delete/<?= $user['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
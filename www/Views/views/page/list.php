<table>
    <thead>
        <th>ID</th>
        <th>URL</th>
        <th>Title</th>
        <th>Content</th>
        <th>Actions</th>
    </thead>
    <tbody>
        <?php foreach ($pages as $page) : ?>
            <tr>
                <td><?= $page['id'] ?></td>
                <td><?= $page['url'] ?></td>
                <td><?= $page['title'] ?></td>
                <td><?= $page['content'] ?></td>
                <td>
                    <a href="/page/<?= $page['url'] ?>">View</a>
                    <a href="/page/edit/<?= $page['id'] ?>">Edit</a>
                    <a href="/page/delete/<?= $page['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<a href="/pages/create">Ajouter une page</a>
<?php if (isset($error)) {
    echo $error;
} else ?>

<h1><?= $title ?></h1>

<p><?= $content ?></p>
<p><?= $updatedAt ?></p>
<p><?php print_r($author) ?></p>

<?php foreach ($comments as $comment) {
    echo $comment['title'];
    echo $comment['content'];
    echo $comment['author'];
}

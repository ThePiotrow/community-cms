<?php

if ($error) {
    echo $error;
} else

?>
Êtes-vous sûr de vouloir supprimer la page <?= $title ?> (<a href="/page/<?= $url ?>">/pages/<?= $url ?></a>) ?

<?php

App\Core\FormBuilder::render($form);

<?php

if ($error) {
    echo $error;
} else

?>
Êtes-vous sûr de vouloir supprimer le compte de <?= $fullname ?> ?

<?php

App\Core\FormBuilder::render($form);

?>
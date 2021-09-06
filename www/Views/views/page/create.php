<?php if (isset($error)) {
    echo $error;
} else
    App\Core\FormBuilder::render($form);
?>
<br><a href="/pages">Retour</a>
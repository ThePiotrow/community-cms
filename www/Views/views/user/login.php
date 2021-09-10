<?php
if ($error) {
    echo $error;
}
App\Core\FormBuilder::render($form);

?>

<a href="/forgot">Mot de passe oublié ?</a>
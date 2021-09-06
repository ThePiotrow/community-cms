<?php if ($error) {
    echo $error;
    die();
}
App\Core\FormBuilder::render($form);

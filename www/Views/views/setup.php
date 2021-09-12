<h1>Installation</h1>

<?php

if ($error) {
    echo $error;
} else
    App\Core\FormBuilder::render($form);

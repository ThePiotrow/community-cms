<?php

use App\Core\Helpers;

if ($errors)
    foreach ($errors as $error)
        echo $error . "<br>";
else
    App\Core\FormBuilder::render($form);

<?php

if ($errors)
    foreach ($errors as $error) {
        echo $error . "<br>";
    }

App\Core\FormBuilder::render($form);

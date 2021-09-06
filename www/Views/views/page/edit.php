<?php if ($error) {
    echo $error;
}
App\Core\FormBuilder::render($form);

echo $allowedTags;

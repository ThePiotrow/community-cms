<?php

namespace App;

use App\Core\Router;
use App\Core\ConstantManager;
use App\Controller\Auth;

require "Autoload.php";
Autoload::register();

new ConstantManager();

$slug = mb_strtolower($_SERVER["REQUEST_URI"]);

$route = new Router($slug);

$c = $route->getController();
$a = $route->getAction();
$p = $route->getParam();

if (file_exists("./Controllers/" . $c . ".php")) {

    include "./Controllers/" . $c . ".php";
    $c = "App\\Controller\\" . $c;

    if (class_exists($c)) {

        $cObject = new $c();
        if (method_exists($cObject, $a)) {

            empty($p) ? $cObject->$a() : $cObject->$a($p);
        } else {
            die("Error la methode n'existe pas !!!");
        }
    } else {
        die("Error la classe n'existe pas!!!");
    }
} else {
    die("Error le fichier controller n'existe pas !!!");
}

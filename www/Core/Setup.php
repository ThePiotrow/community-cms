<?php

namespace App\Core;

class Setup
{

    public static function init()
    {
        $error = false;

        Auth::endAuth(false);

        if (!empty($_POST)) {

            Helpers::convertToGoodData($_POST);

            $content = "";
            $contentProd = "";

            foreach ($_POST as $key => $value) {
                if (explode('_', $key)[0] == "DB")
                    $contentProd .= $key . "=" . $value . PHP_EOL;
                else
                    $content .= $key . "=" . $value . PHP_EOL;
            }

            $content .= "ENV=prod";

            if (file_put_contents('.env', $content) && file_put_contents('.env.prod', $contentProd)) {

                new ConstantManager();
                $db = new Database();

                if ($db->seed()) {
                    Helpers::redirect('/register');
                } else {
                    $error = "Une erreur est survenue lors de la création des tables de la BDD";
                    unlink('.env');
                    unlink('.env.prod');
                }
            } else {
                $error = "Une erreur est survenue lors de la création des fichiers d'environnement";
            }
        }

        $form = self::setupForm();
        $view = "Views/views/setup.php";

        include "Views/templates/setup.tpl.php";
    }

    public static function check()
    {
        if (file_exists('.env') && file_exists('.env.prod')) {
            return 1;
        } else {
            return 0;
        }
    }

    public static function setupForm()
    {
        return [
            "config" => [
                "method" => "POST",
                "action" => "",
                "id" => "setup-form",
                "submit" => "Installer",
                "csrf" => false
            ],
            "inputs" => [
                "HOST_ADDRESS" => [
                    "type" => "hidden",
                    "required" => true,
                    "value" => $_SERVER['SERVER_NAME']
                ],
                "WEBSITE_NAME" => [
                    "type" => "text",
                    "label" => "Nom du site",
                    "required" => true,
                    "value" => "Rattrapage"
                ],
                "DB_HOST" => [
                    "type" => "text",
                    "label" => "Serveur BDD",
                    "required" => true,
                    "value" => "localhost"
                ],
                "DB_PORT" => [
                    "type" => "number",
                    "label" => "Port du serveur BDD",
                    "required" => true,
                    "value" => "3306"
                ],
                "DB_NAME" => [
                    "type" => "text",
                    "label" => "Nom de la BDD",
                    "required" => true,
                    "value" => "community_db"
                ],
                "DB_DRIVER" => [
                    "type" => "text",
                    "label" => "Moteur BDD",
                    "required" => true,
                    "value" => "mysql"
                ],
                "DB_USER" => [
                    "type" => "text",
                    "label" => "Nom d'utilisateur BDD",
                    "required" => true,
                    "value" => "root"
                ],
                "DB_PASSWORD" => [
                    "type" => "password",
                    "label" => "Mot de passe BDD",
                    "required" => true,
                    "value" => "CCszUse9H32Q"
                ],
                "SMTP_HOST" => [
                    "type" => "text",
                    "label" => "SMTP : Hôte",
                    "required" => true,
                    "value" => "ssl0.ovh.net"
                ],
                "SMTP_PORT" => [
                    "type" => "number",
                    "label" => "SMTP : Port",
                    "required" => true,
                    "value" => "587"
                ],
                "SMTP_USER" => [
                    "type" => "text",
                    "label" => "SMTP : Adresse mail",
                    "required" => true,
                    "value" => "admin@la11eme.fr"
                ],
                "SMTP_PASS" => [
                    "type" => "password",
                    "label" => "SMTP : Mot de passe",
                    "required" => true,
                    "value" => "poiuytreza"
                ]
            ]
        ];
    }
}

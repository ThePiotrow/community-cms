<?php

namespace App\Core;

class View
{


    private $template; // front ou back
    private $view; // home, 404, user, users, ....
    private $data = [];


    public function __construct($view, $template = "front")
    {
        $this->setTemplate($template);
        $this->setView($view);
    }

    public function setTemplate($template)
    {
        if (file_exists("Views/templates/" . $template . ".tpl.php")) {
            $this->template = "Views/templates/" . $template . ".tpl.php";
        } else {
            die("Le template n'existe pas");
        }
    }

    public function setView($view)
    {
        if (file_exists("Views/views/" . $view . ".php")) {
            $this->view = "Views/views/" . $view . ".php";
        } else {
            die("La vue n'existe pas");
        }
    }

    //$view->assign("pseudo", $pseudo);
    public function assign($key, $value)
    {
        $this->data[$key] = $value;
    }


    public function __destruct()
    {
        extract($this->data);

        if ($this->template)
            include $this->template;
        else
            include $this->view;
    }
}

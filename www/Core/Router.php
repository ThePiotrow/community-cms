<?php

namespace App\Core;

class Router
{

    private $slug;
    private $param;
    private $action;
    private $controller;
    private $routePath = "routes.yml";
    private $listOfRoutes = [];
    private $listOfSlugs = [];

    public function __construct($slug)
    {
        $this->slug = $slug;
        $this->loadYaml();
        $this->match();

        if (empty($this->listOfRoutes[$this->slug]) && !isset($this->param)) $this->exception404();

        $this->setController($this->listOfRoutes[$this->slug]["controller"]);
        $this->setAction($this->listOfRoutes[$this->slug]["action"]);
    }

    public function loadYaml()
    {
        $this->listOfRoutes = yaml_parse_file($this->routePath);
        foreach ($this->listOfRoutes as $slug => $route) {
            if (empty($route["controller"]) || empty($route["action"]))
                die("Parse YAML ERROR");
            $this->listOfSlugs[$route["controller"]][$route["action"]] = $slug;
        }
    }

    public function match()
    {
        foreach ($this->listOfRoutes as $path => $data) {
            if ($path == $this->slug) return $path;

            if (isset($data['param'])) {
                $replacePath = str_ireplace(":" . $data['param'], "([^/]+)", $path);
                preg_match('~^' . $replacePath . '$~', $this->slug, $match);
                array_shift($match);
                if (count($match)) {
                    $this->setParam($match[0]);
                    $this->slug = $path;
                }
            }
        }

        return false;
    }

    public function getSlug($controller = "Main", $action = "default")
    {
        return $this->listOfSlugs[$controller][$action];
    }

    public function setController($controller)
    {
        $this->controller = ucfirst($controller);
    }

    public function setAction($action)
    {
        $this->action = $action . "Action";
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setParam($param)
    {
        $this->param = $param;
    }

    public function getParam()
    {
        return $this->param;
    }

    public function exception404()
    {
        die("Erreur 404");
    }
}

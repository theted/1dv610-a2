<?php

/**
 * Global router
 */

define(ROUTES, [
    'default' => 'login',
    '/?register' => 'register',
    '/' => 'login',
    'index' => 'login',
    'login' => 'login',
    'register' => 'register',
]);

class RouterController
{
    public $url;
    public $loggedIn;

    public function __construct($initialRoute = "/")
    {
        $this->url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '/';
        $this->loggedIn = $this->isLoggedIn();
        // echo " >> routing: $this->url --> " . $this->getCurrentRoute() . "<br />";

        // logout user if logout set
        // TODO -> move!
        if (isset($_POST['LoginView::Logout'])) {
            session_destroy();
            header('Location: /');
            return true;
        }
    }

    public function getCurrentRoute()
    {
        // force all logged-in users to home route
        if ($this->loggedIn == true) {
            return 'home';
        }

        return $this->parseRoute($this->url);
    }

    public function parseRoute($url)
    {
        return ROUTES[array_key_exists($url, ROUTES)
            ? $this->url
            : 'default'
        ];
    }

    public function renderRoute($route)
    {
        $dynamicView = $this->getCurrentRouteView($route);
        return $dynamicController->response();
    }

    public function getCurrentRouteView($route = false)
    {
        $route = $this->getCurrentRoute();
        $route = str_replace('/', '', $route);
        $route = ucfirst($route);

        // dynamic include of controller & view
        $controllerName = $route . 'Controller';
        $viewName = $route . 'View';

        require_once "controller/" . $route . "Controller" . ".php";
        require_once "view/" . $route . "View" . ".php";

        $dynamicController = new $controllerName();
        $dynamicView = new $viewName($dynamicController);

        return $dynamicView;
    }

    public function isLoggedIn()
    {
        return (isset($_SESSION['loggedIn']));
    }

}

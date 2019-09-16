<?php

//INCLUDE THE FILES NEEDED...
require_once 'controller/RouterController.php';
require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$router = new RouterController();
$dateTime = new DateTimeView();
$layout = new LayoutView();

$pageTitle = "Route: " . $router->url . " => " . $router->getCurrentRoute();

// get main page using router
$mainPage = $router->getCurrentRouteView();

// render page using layout view
$isLoggedIn = $router->isLoggedIn();
$layout->render($isLoggedIn, $mainPage, $dateTime, $pageTitle);

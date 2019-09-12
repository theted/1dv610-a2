<?php

//INCLUDE THE FILES NEEDED...
require_once 'controller/LoginController.php';
require_once 'controller/RegisterController.php';
require_once 'view/LoginView.php';
require_once 'view/RegisterView.php';
require_once 'view/DateTimeView.php';
require_once 'view/LayoutView.php';

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

//CREATE OBJECTS OF THE VIEWS
$loginController = new LoginController();
$registerController = new RegisterController();
$loginPage = new LoginView($loginController);
$registerPage = new RegisterView($registerController);
$dateTime = new DateTimeView();
$layout = new LayoutView();

// set which view to show (register or login), depending on query parameters...
// TODO: implement a router instead of this hacky stuff
$mainPage = (isset($_GET['register'])) ? $registerPage : $loginPage;

// render page using layout view
$isLoggedIn = ($loginController->currentUser);
$layout->render($isLoggedIn, $mainPage, $dateTime);

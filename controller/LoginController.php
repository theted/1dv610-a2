<?php

require_once "./model/SessionStoreModel.php";
require_once "./model/LoginModel.php";

class LoginController
{
    private $error;
    private $model;
    public $currentUser;

    // temp
    public $username;

    // TODO: move all logic outta this constructor...
    public function __construct()
    {
        $this->loginModel = new LoginModel();
        $this->error = false;

        // TODO: use session..
        if (isset($_SESSION['username'])) {
            $this->currentUser = $_SESSION['username'];
        }

        // logout
        // TODO: move to model method
        if (isset($_POST['LoginView::Logout'])) {
            session_destroy();
            header('Location: /');
            return true;
        }

        // check if we have POST data
        if (isset($_POST) && isset($_POST['LoginView::Login'])) {

            // login
            $username = $_POST['LoginView::UserName'];
            $password = $_POST['LoginView::Password'];
            // KeepMeLoggedIn ?

            // save current username state (if user needs it back in form...)
            $this->username = $username;

            // validate user input
            $validationResult = $this->loginModel->validate($username, $password);

            if ($validationResult !== true) {
                $this->error = $validationResult;
                return false;
            }

            // update user/state...
            $this->currentUser = $username;

            // perform login
            if ($this->loginModel->login($username, $password)) {
                // (user is logged-in)
                // ? TODO: need to redirect ?
                redirect('/');
            } else {
                $this->error = "Wrong name or password";
            }
        } else {
            // empty POST; should show form
            return true;
        }
    }

    public function getError()
    {
        return $this->error;
    }

}

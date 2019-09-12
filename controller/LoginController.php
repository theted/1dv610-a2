<?php

require_once "./model/SessionStoreModel.php";
require_once "./model/LoginModel.php";

class LoginController
{
    private $error;
    private $model;
    public $currentUser;

    public function __construct()
    {
        $this->model = new LoginModel();
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

        // TODO: fix this; is redundant!
        if (isset($_GET['register'])) {
            return false;
        }

        // check if we have POST data
        if (isset($_POST) && isset($_POST['LoginView::Login'])) {

            // login
            $username = $_POST['LoginView::UserName'];
            $password = $_POST['LoginView::Password'];
            // KeepMeLoggedIn ?

            // TODO: clean up logic

            if (!$username) {
                $this->error = "Username is missing";
                return true;
            }

            if (!$password) {
                $this->error = "Password is missing";
                return true;
            }

            // perform login
            $this->currentUser = $username; // << tamp...
            if ($this->model->login($username, $password)) {
                // (user is logged-in)
                // ? TODO: need to redirect ?
            } else {
                $this->error = "Wrong name or password";
            }
        } else {
            // empty POST; should show form
        }
    }

    public function getError()
    {
        return $this->error;
    }

}

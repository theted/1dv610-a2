<?php

require_once "model/SessionStoreModel.php";
require_once "model/UserModel.php";
require_once "model/RegisterModel.php";
require_once 'model/DatabaseModel.php';

class RegisterController
{
    private $error;
    private $model;

    public function __construct()
    {
        // temp fix
        if (isset($_GET['register']) == false) {
            return false;
        }

        // redirect requests if user is logged in
        if (isset($_SESSION['loggedIn'])) {
            header('Location: /');
        }

        $this->model = new LoginModel();
        $this->userModel = new UserModel();
        $this->registerModel = new RegisterModel();
        $this->db = new DatabaseModel(); //->connection // TODO: init from outside?
        $this->error = false;

        // if POST rata is present
        if (!empty($_POST)) {
            // perform validation & try create user; method also handles validation...
            $this->registerUserIfValidInput();
        } else {
            // show form...
        }
    }

    public function registerUserIfValidInput()
    {
        // TODO: fix; remove need for this redundant check!
        if (isset($_GET['register']) == false) {
            return false;
        }

        // get fields from POST request
        // ? TODO refactor!
        $username = $_POST['RegisterView::UserName'];
        $password = $_POST['RegisterView::Password'];
        $passwordRepeat = $_POST['RegisterView::PasswordRepeat'];

        // validate input
        $validationResult = $this->registerModel->validate($username, $password, $passwordRepeat);

        if ($validationResult == true) {
            // validation pass; we can register the user in db
            // actually do the db register at this point
            $this->registerModel->createUser($username, $password);

            // .. then we can redirect
            header('Location: /');
        } else {
            // validation failed; set error property
            $this->error = $validationResult;
        }
    }

    private function setError($err)
    {
        $this->error = $err;
    }

    public function getError()
    {
        return $this->error;
    }

}

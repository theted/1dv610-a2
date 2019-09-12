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
        // TODO: fix
        if (isset($_GET['register']) == false) {
            return false;
        }

        $this->model = new LoginModel();
        $this->userModel = new UserModel();
        $this->db = new DatabaseModel(); //->connection // TODO: init from outside?
        $this->error = false;

        // if POST rata is present
        if (!empty($_POST)) {
            // perform validation & try create user; method also handles validation...
            $this->registerUserIfValidInput();
        } else {
            // show form...
            $this->error = "[form!]";
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
        if ($this->validate($username, $password, $passwordRepeat)) {
            // validation pass; we can register the user in db
            // actually do the db register at this point
            $this->createUser($username, $password);
        } else {
            // validation failed; error property is set by validate method
            return false;
        }
    }

    public function validate($username, $password, $passwordRepeat)
    {
        if (strlen($username) < 3) {
            $this->setError("Username has too few characters, at least 3 characters.");
            return false;
        }

        if (strlen($password) < 6) {
            $this->error = "Password has too few characters, at least 6 characters.";
            return false;
        }

        if ($password !== $passwordRepeat) {
            $this->error = "Passwords do not match.";
            return false;
        }

        // check if username already exists in db
        $existingUser = $this->userModel->get($username);

        // user exists
        if (count($existingUser) > 0) {
            $this->error = "Username already exists.";
            return false;
        }

        // all is good!
        return true;
    }

    public function createUser($username, $password)
    {
        try {

            // create user in db
            $result = $this->db->connection->prepare('INSERT INTO users (username, password) VALUES (:username,:password)');
            $result->execute(['username' => $username, 'password' => $this->model->hash($password)]);

            // now since the user is registered, we can actually log in
            // TODO: set `Welcome` msg to user
            return $this->model->login($username, $password);
        } catch (\PDOException $e) {
            echo "ERROR! ";
            print_r($e);
            return false;
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

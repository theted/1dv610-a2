<?php

require_once 'model/DatabaseModel.php';
// <== TODO: remove dependency!
require_once 'model/UserModel.php';
require_once 'model/LoginModel.php';

class RegisterModel
{
    public function __construct()
    {
        $this->db = new DatabaseModel();
        $this->userModel = new UserModel();
        $this->loginModel = new LoginModel();
    }

    public function register()
    {
        // TODO: try/catch
        // TODO: validation

        return "register form goes here...";
    }

    public function validate($username, $password, $passwordRepeat)
    {
        if (strlen($username) < 3) {
            return "Username has too few characters, at least 3 characters.";
        }

        if (strlen($password) < 6) {
            return "Password has too few characters, at least 6 characters.";
        }

        if ($password !== $passwordRepeat) {
            return "Passwords do not match.";
        }

        // check if username already exists in db
        $existingUser = $this->userModel->get($username);

        // user exists
        if (count($existingUser) > 0) {
            return "Username already exists.";
        }

        // all is good!
        return true;
    }

    // create user in db
    // TODO: move to user model ?
    public function createUser($username, $password)
    {
        try {
            $result = $this->db->connection->prepare('INSERT INTO users (username, password) VALUES (:username,:password)');
            $result->execute(['username' => $username, 'password' => $this->loginModel->hash($password)]);

            // now since the user is registered, we can actually log in

            // TODO: set `Welcome` msg to user
            return $this->loginModel->login($username, $password);
            // $this->error = "Welcome"; // breaks?
        } catch (\PDOException $e) {
            echo "ERROR! ";
            print_r($e);
            return false;
        }
    }

}

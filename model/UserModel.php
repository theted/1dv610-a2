<?php

/*
 * User definitions & methods
 */

require_once 'DatabaseModel.php';
require_once 'LoginModel.php'; // TODO: maybe refactor out separate Auth methods...

class UserModel
{

    public function __construct()
    {
        // setup access to db
        $this->db = new DatabaseModel();
        $this->loginModel = new loginModel();
    }

    public function create($username, $password)
    {
        try {
            $result = $this->db->connection->prepare('INSERT INTO users (username, password) VALUES (:username,:password)');
            $result->execute(['username' => $username, 'password' => $this->loginModel->hash($password)]);

            // now since the user is registered, we can actually log in
            return $this->loginModel->login($username, $password);
        } catch (\PDOException $e) {
            echo "ERROR! ";
            print_r($e);
            return false;
        }
    }

    public function get($username, $checkOnly = false)
    {
        $query = $this->db->connection->prepare('SELECT * FROM users WHERE username = :username');
        $query->execute(['username' => $username]);
        return ($checkOnly) ? $query->rowCount() : $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validate($user)
    {
        // [TODO]
        echo "have user: " . $user->username;
    }

}

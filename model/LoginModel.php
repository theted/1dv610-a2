<?php

require_once 'DatabaseModel.php';

class LoginModel
{
    public function __construct()
    {
        // setup db connection
        $this->db = new DatabaseModel();
    }

    public function login($username, $password)
    {
        if ($this->authenticate($username, $password)) {
            // TODO: separate into storage class
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $username;

            // TODO: return true; model methods should not have
            // side-effects like a page redirect!
            redirect("/");
        } else {
            // login fail
            echo " login FAIL for user \"$username\"!";
        }
    }

    // TODO: implement actual authentication..!
    public function authenticate($username, $password)
    {
        // try find user(s) matching credentials from db
        $query = $this->db->connection->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
        $query->execute(['username' => $username, 'password' => $this->hash($password)]);
        $numUsers = $query->rowCount();

        // technically, should only be exactly 1 user in table...
        return ($numUsers > 0);
    }

    public function hash(string $password)
    {
        return md5(SALT . $password);
    }
}

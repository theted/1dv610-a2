<?php

require_once 'config.php'; // ?
require_once 'DatabaseModel.php';
require_once 'SessionStoreModel.php';

class LoginModel
{
    public function __construct()
    {
        $this->db = new DatabaseModel();
        $this->Store = new SessionStore();
    }

    public function login($username, $password)
    {
        if ($this->authenticate($username, $password)) {
            $this->Store->set('loggedIn', true);
            $this->Store->set('username', $username);
            $this->Store->set('message', 'Welcome');
            return true;
        } else {
            return "Login failed!";
        }
    }

    /**
     * Authenticate user
     *
     * @param string $username
     * @param string $password
     * @return string Error
     * @return bool Success
     */
    public function authenticate($username, $password)
    {
        // try find user(s) matching credentials from db
        $query = $this->db->connection->prepare('SELECT * FROM users WHERE username = :username AND password = :password');
        $query->execute(['username' => $username, 'password' => $this->hash($password)]);
        $numUsers = $query->rowCount();

        // technically, should only be exactly 1 user in table...
        return ($numUsers > 0);
    }

    // validate input
    // @return string error

    /**
     * Validate input
     *
     * @param string $username
     * @param string $password
     * @return string Error
     * @return bool=true Validation pass
     */
    public function validate($username = false, $password = false)
    {
        if (!$username) {
            return "Username is missing";
        }

        if (!$password) {
            return "Password is missing";
        }

        // ! temp
        if (!$this->authenticate($username, $password)) {
            return "Wrong name or password";
        }

        return true;
    }

    public function hash(string $password)
    {
        return md5(SALT . $password);
    }
}

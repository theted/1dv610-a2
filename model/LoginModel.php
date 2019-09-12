<?php

const SALT = "@don't-use-just-ordinary-md5!";

class LoginModel
{
    public function __construct()
    {
        // TODO: make sure we have a db connection, etc..
    }

    public function login($username, $password)
    {
        if ($this->authenticate($username, $password)) {
            // TODO: separate into storage class
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $username;
            redirect("/");
        } else {
            // login fail
            echo " login FAIL for user \"$user\"!";
        }
    }

    // TODO: implement actual authentication..!
    public function authenticate($username, $password)
    {
        return ($username === "Admin" && $password === "Password");
    }

    public function hash(string $password)
    {
        return md5(SALT . $password);
    }
}

<?php

/*
 * Session storage controller
 */

class SessionStore
{
    public function __construct()
    {
        // initialize session if not previously sarted
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function get($key)
    {
        return $_SESSION[$key];
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function logout()
    {
        session_destroy();
        redirect('/');
    }
}

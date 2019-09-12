<?php

require_once './config.php';

class DatabaseModel
{
    public $connection;

    // database credentials as defined in `config.php`
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbdb = DB_NAME;

    public function __construct($options = false)
    {
        $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbdb", $this->user, $this->pass);
        $this->connection = $pdo; // exposes our entire PDO object... Is risky; should expose single specific methods instead!
    }
}

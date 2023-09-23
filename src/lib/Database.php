<?php
declare(strict_types=1);

class Database
{

    private $connection;

    public function __construct()
    {
        $server = $_ENV['DATABASE_HOST'];
        $database = $_ENV['DATABASE_NAME'];
        $user = $_ENV['DATABASE_USER'];
        $password = $_ENV['DATABASE_PASSWORD'];

        try {
            $this->connection = new PDO("mysql:host=$server;dbname=$database", $user, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
          } catch(PDOException $e) {
            die($e->getMessage());
          }     
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

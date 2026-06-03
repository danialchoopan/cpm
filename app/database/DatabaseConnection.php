<?php


namespace App\database;



abstract class DatabaseConnection
{
    protected $databaseConnection;
    function __construct()
    {
        try {
            $dsn = $_ENV['DSN_PDO'] ?? 'mysql:host=localhost;dbname=cpm;charset=utf8mb4';
            $user = $_ENV['USERNAME_DB'] ?? 'root';
            $pass = $_ENV['PASSWORD_DB'] ?? '';

            $options = [
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            $this->databaseConnection = new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
             throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
}
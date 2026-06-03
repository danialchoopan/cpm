<?php


namespace App\database;



abstract class DatabaseConnection
{
    protected $databaseConnection;
    function __construct()
    {
        try {
            $db_type = $_ENV['DB_CONNECTION'] ?? 'mysql';

            if ($db_type === 'sqlite') {
                $db_path = $_ENV['DB_DATABASE'] ?? dirname(__DIR__, 2) . '/database.sqlite';
                $dsn = "sqlite:$db_path";
                $user = null;
                $pass = null;
            } else {
                $dsn = $_ENV['DSN_PDO'] ?? 'mysql:host=localhost;dbname=cpm;charset=utf8mb4';
                $user = $_ENV['USERNAME_DB'] ?? 'root';
                $pass = $_ENV['PASSWORD_DB'] ?? '';
            }

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
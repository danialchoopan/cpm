<?php


namespace App\database;



abstract class DatabaseConnection
{
    protected $databaseConnection;
    function __construct()
    {
        $this->databaseConnection=new \PDO($_ENV['DSN_PDO'],$_ENV['USERNAME_DB'],$_ENV['PASSWORD_DB']);
//        $databaseConnection->prepare()->execute()
    }
}
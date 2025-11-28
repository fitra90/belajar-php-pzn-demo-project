<?php

namespace Baim\Belajar\PHP\MVC\Config;

class Database
{
    private static array $connection = [
        "database" => [
            "test" => [
                "url" => "mysql:host=localhost:3306; dbname=php_login_management_test",
                "username" => "root",
                "password" => "",
            ],
            "prod" => [
                "url" => "mysql:host=localhost:3306; dbname=php_login_management",
                "username" => "root",
                "password" => "",

            ]
        ]
    ];
    
    private static ?\PDO $pdo = null;

    public static function getConnection(string $env = "test"): \PDO 
    {
        if (self::$pdo == null) {
            //create new PDO
            self::$pdo = new \PDO(
                self::$connection["database"][$env]["url"],
                self::$connection["database"][$env]["username"],
                self::$connection["database"][$env]["password"],
            );
        } 

        return self::$pdo;
    }

    public static function beginTransaction() 
    {
        self::$pdo->beginTransaction();
    }

    public static function commitTransaction() 
    {
        self::$pdo->commit();
    }

    public static function rollBackTransaction() 
    {
        self::$pdo->rollBack();
    }
}
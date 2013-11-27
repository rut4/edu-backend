<?php

class PDOHelper {
    private static $_pdo;

    private function __construct()
    {
    }

    public static function getPdo()
    {
        if (!isset(self::$_pdo)) {
            self::$_pdo = new PDO('mysql:host=localhost;dbname=student', 'root', 'vagrant');
        }
        return self::$_pdo;
    }
}

<?php

namespace App\Core;

use PDO;

final class Connection
{
    private static ?PDO $connection = null;
    private static $config;
    private function __construct() {}
    private function __clone() {}
    public function __wakeup() {}

    /**
     * @return PDO
     */
    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            self::$config = require './config/connection.php';
            self::$connection = new PDO('mysql:host=localhost;dbname=' . self::$config['db_name'] . ';charset=utf8', self::$config['db_user'], self::$config['db_pass']);
        }
        return self::$connection;
    }

    /**
     * @return void
     */
    public function beginTransaction(): void
    {
        $this->getConnection()->beginTransaction();
    }

    /**
     * @return void
     */
    public function commitTransaction(): void
    {
        $this->getConnection()->commit();
    }

    /**
     * @return void
     */
    public function rollbackTransaction(): void
    {
        $this->getConnection()->rollBack();
    }
}

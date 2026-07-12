<?php

namespace Kite\Core;

use PDO;
use PDOException;
use Exception;

class Database
{
    protected static ?PDO $connection = null;

    public static function connect(): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        $connection = Env::get('DB_CONNECTION', 'mysql');
        $host = Env::get('DB_HOST', '127.0.0.1');
        $port = Env::get('DB_PORT', '3306');
        $database = Env::get('DB_DATABASE', 'kitephp');
        $username = Env::get('DB_USERNAME', 'root');
        $password = Env::get('DB_PASSWORD', '');

        $dsn = "{$connection}:host={$host};port={$port};dbname={$database};charset=utf8mb4";

        try {
            self::$connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            abort(500, "Database Connection Error: " . $e->getMessage());
        }

        return self::$connection;
    }

    public static function table(string $table): QueryBuilder
    {
        return new QueryBuilder(self::connect(), $table);
    }
}

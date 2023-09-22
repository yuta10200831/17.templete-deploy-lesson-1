<?php
namespace App\Infrastructure\Dao;

use PDO;
use PDOException;

/**
 * SQL形式のDAOベースクラス
 */
abstract class SqlDao
{
    const DB_NAME = 'blog';
    const DB_USER = 'root';
    const DB_PASSWORD = 'password';
    const DB_HOST = 'mysql';

    protected PDO $pdo;

    public function __construct()
    {
        try {
            $dbDsn = sprintf(
                'mysql:host=%s; dbname=%s;',
                self::DB_HOST,
                self::DB_NAME
            );
            $this->pdo = new PDO($dbDsn, self::DB_USER, self::DB_PASSWORD);
        } catch (PDOException $e) {
            exit('DB接続エラー: ' . $e->getMessage());
        }
    }

    public function __destruct()
    {
        unset($this->pdo);
    }
}

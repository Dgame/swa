<?php

namespace Swa\Database;

/**
 * Class Database
 * @package Swa\Database
 */
final class Database
{
    /**
     * @var
     */
    private static $instance;
    /**
     * @var \PDO
     */
    private $dbh;
    
    const DSN     = 'mysql:dbname=uni;host=127.0.0.1';
    const DB_USER = 'root';
    const DB_PASS = '';

    /**
     * Database constructor.
     */
    private function __construct()
    {
        try {
            $this->dbh = new \PDO(self::DSN, self::DB_USER, self::DB_PASS);
        } catch (\PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    /**
     * @return Database
     */
    public static function instance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param string $query
     * @param array  ...$args
     *
     * @return array
     */
    public function fetch(string $query, ...$args): array
    {
        if (!empty($args)) {
            $query = sprintf($query, ...$args);
        }

        $stmt = $this->dbh->query($query);
        if (is_object($stmt) && $stmt->execute()) {
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        return [];
    }

    /**
     * @param string $query
     * @param array  ...$args
     *
     * @return array
     */
    public function fetchAll(string $query, ...$args): array
    {
        if (!empty($args)) {
            $query = sprintf($query, ...$args);
        }

        $stmt = $this->dbh->query($query);
        if (is_object($stmt) && $stmt->execute()) {
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        return [];
    }

    /**
     * @param string $query
     * @param array  ...$args
     *
     * @return bool
     */
    public function query(string $query, ...$args): bool
    {
        if (!empty($args)) {
            $query = sprintf($query, ...$args);
        }

        return $this->dbh->query($query) !== null;
    }

    /**
     * @return int
     */
    public function getLastInsertedId(): int
    {
        return $this->dbh->lastInsertId();
    }

    /**
     * @return array
     */
    public function getErrorInfo(): array
    {
        return $this->dbh->errorInfo();
    }
}

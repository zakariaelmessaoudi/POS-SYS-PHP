<?php
class Database
{
    private static $instance;
    private $pdo;

    private function __construct()
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $this->pdo = new PDO($dsn, DB_USER, DB_PASS, array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ));
    }

    public static function getInstance()
    {
        if (!self::$instance) self::$instance = new self();
        return self::$instance;
    }

    public function pdo() { return $this->pdo; }
    public function query($sql, $params) { $stmt = $this->pdo->prepare($sql); $stmt->execute($params); return $stmt; }
}

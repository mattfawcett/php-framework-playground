<?php
namespace Framework;

use PDO;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->configureDatabaseConnection();
    }

    protected function configureDatabaseConnection()
    {
        $host = '127.0.0.1';
        $db   = 'my_app';
        $user = 'my_app';
        $pass = 'secret';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $this->conn = new PDO($dsn, $user, $pass, $opt);
    }
}

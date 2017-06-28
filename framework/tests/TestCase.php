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
        $this->resetDatabase();
        $this->resetDatabase();
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

    /**
     * Reset the database to a known state for testing purposes. Ordinarily
     * transactions/fixtures/factories/migrations would be used for this kind of
     * thing. But for the purposes of this demo, just simply import an sql file.
     */
    protected function resetDatabase()
    {
        shell_exec('bin/db-seed');
    }
}

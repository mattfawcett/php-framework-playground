<?php
namespace Framework;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp()
    {
        $this->container = require_once(__DIR__ . '/../../app/bootstrap.php');
        parent::setUp();
    }
}

<?php
namespace App;

use Framework\TestCase as FrameworkTestCase;

/**
 * For simplicity, inherit from the TestCase as the framework for now as both
 * framework and app tests can use the same database.
 */
abstract class TestCase extends FrameworkTestCase
{
}

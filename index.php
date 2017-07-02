<?php
namespace App;

use App\Http\RequestHandler;

$container = require_once(__DIR__ . '/app/bootstrap.php');

$requestHandler = new RequestHandler($container);
$requestHandler->handle($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);

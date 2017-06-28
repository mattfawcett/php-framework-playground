<?php

$container = require_once(__DIR__ . '/app/bootstrap.php');

$userRepository = $container->get(App\UserRepository::class);
$user = $userRepository->find(1);

var_dump($user);

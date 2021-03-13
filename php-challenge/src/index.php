<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/pkg/config.php';

$logger = new \Monolog\Logger('jber');
$logger->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout'));

$c = new \jber\controller\PokemonController($logger);

$c->handle();

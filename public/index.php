<?php

use Bilbo\Http\Request;
use Bilbo\Http\Response;
use Bilbo\Http\Route;

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../Routes/web.php';

$route = new Route(new Request, new Response);

// var_dump($route->resolve());
$route->resolve();

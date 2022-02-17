<?php

use Bilbo\Http\Request;
use Bilbo\Http\Response;
use Bilbo\Http\Route;

require_once __DIR__ . '/../src/Support/helpers.php';

require_once base_path() . 'vendor/autoload.php';

require_once base_path() . 'Routes/web.php';

$route = new Route(new Request, new Response);

// var_dump($route->resolve());
$route->resolve();

// var_dump(base_path());

<?php

use Bilbo\Http\Route;
use App\Controller\HomeController;

// Route::get('/', function () {
//     return 'hello';
// });

Route::get('/', [HomeController::class, 'index']);

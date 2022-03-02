<?php

use Bilbo\Http\Route;
use App\Controller\HomeController;
use App\Controller\ContactController;
use App\Controller\Auth\RegisterController;

// Route::get('/', function () {
//     return 'hello';
// });

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

Route::get('/signup', [RegisterController::class, 'index']);
Route::post('/signup', [RegisterController::class, 'store']);

Route::get('/contact', [ContactController::class, 'index']);
Route::post('/contact', [ContactController::class, 'store']);

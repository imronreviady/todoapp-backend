<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// login route
Route::post('login', 'App\Http\Controllers\API\AuthController@login');
// register route
Route::post('register', 'App\Http\Controllers\API\AuthController@register');

// todo routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('todos', 'App\Http\Controllers\API\TodoController@index');
    Route::post('todos', 'App\Http\Controllers\API\TodoController@store');
    Route::post('todos/{id}', 'App\Http\Controllers\API\TodoController@update');
    Route::delete('todos/{id}', 'App\Http\Controllers\API\TodoController@destroy');
});
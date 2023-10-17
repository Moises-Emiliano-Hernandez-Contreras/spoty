<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\SessionController;
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
//Route::post('/register',"authController@register");
Route::post('/register',"SessionController@register")->name("sessioncontroller.register");
Route::post('/login',"SessionController@login")->name("sessioncontroller.login");

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout',"SessionController@logout")->name("sessioncontroller.logout");    
});


<?php

use App\Http\Controllers\Usercontroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [Usercontroller::class, 'Login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [Usercontroller::class, 'Logout']);
});

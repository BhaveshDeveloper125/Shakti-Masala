<?php

use App\Http\Controllers\Usercontroller;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\AuthCheckMiddleware;
use Illuminate\Support\Facades\Route;


Route::view('/', 'Dashboard')->middleware(AuthCheckMiddleware::class);

Route::post('/login', [Usercontroller::class, 'Login']);

// User Section
Route::view('/registration', 'RegistrationPage');   //Registration Page
Route::view('/login_page', 'LoginPage');   //Registration Page
Route::post('/register', [Usercontroller::class, 'UserRegistration']); //User registration

Route::group(['middleware' => AuthCheckMiddleware::class], function () {
    Route::post('/logout', [Usercontroller::class, 'Logout']); //Logout
    Route::view('/sales', 'Sales');
    Route::view('/production', 'Production');
    Route::view('/inventory', 'Inventory');
    Route::view('/customer_details', 'CustomerDetails');
    Route::view('/product_consting', 'ProductCosting');
    Route::view('/expenses', 'Expenses');
    Route::view('/pl_statement', 'PLStatement');
});

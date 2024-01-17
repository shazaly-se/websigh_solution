<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\LoanController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('layouts.master');
// });

Route::get("/",[DashboardController::class,"index"]);

Route::get("/register",[AuthController::class,"showregister"])->name('register.show');
Route::post('/register', [AuthController::class,"register"])->name('register.post');

Route::get("/login",[AuthController::class,"showlogin"])->name('login');
Route::post('/login', [AuthController::class,"login"])->name('login.post');

Route::group(['middleware' => ['auth']], function() {
    /**
     * Logout Routes
     */
    Route::get('/logout', [AuthController::class,"logout"])->name('logout.out');

    Route::get('/allloan', [LoanController::class,"index"]);


    Route::get('/loan', [LoanController::class,"create"])->name('loan.create');
    Route::post('/loan', [LoanController::class,"store"])->name('loan.post');
    Route::post('/repayment', [LoanController::class,"repayment"])->name('loan.repayment');
});



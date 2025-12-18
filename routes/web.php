<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->middleware(['guest'])->name('auth.')->group(function () {
    Route::get('/register',[AuthController::class,'register'])->name('register');
    Route::post('/register',[AuthController::class,'checkRegister'])->name('checkregister');
});

Route::get('auth/login',[AuthController::class,'login'])->name('login');
Route::post('auth/login',[AuthController::class,'checkLogin'])->name('auth.checklogin');

Route::get('/dashboard',function(){
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::resource('user',UserController::class);
Route::put('updateprofile',[UserController::class,'updateprofile'])->name('user.updateprofile');
Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

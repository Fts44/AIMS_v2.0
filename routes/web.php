<?php

use Illuminate\Support\Facades\Route;

// ==================================================================================
// Classification: Authentication
use App\Http\Controllers\OTPController as OTPController;


use App\Http\Controllers\Authentication\LoginController as LoginController;
use App\Http\Controllers\Authentication\RegistrationController as RegistrationController;
use App\Http\Controllers\Authentication\RecoverController as RecoverController;


Route::post('get_otp', [OTPController::class, 'compose_mail'])->name('SendOTP');

Route::prefix('/')->group(function(){

    // Login
    Route::get('', [LoginController::class, 'index'])->name('Login.Index');
    Route::post('login', [LoginController::class, 'login'])->name('Login.Create');

    // Registration
    Route::get('register', [RegistrationController::class, 'index'])->name('Registration.Index');
    Route::post('register/new', [RegistrationController::class, 'register'])->name('Register.Create');

    // Recover
    Route::get('recover', [RecoverController::class, 'index'])->name('Recover.Index');
    Route::post('recover/new', [RecoverController::class, 'recover'])->name('Recover.Create');
});

// ==================================================================================


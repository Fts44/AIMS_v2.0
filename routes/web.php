<?php

// =============================== Start of Global Controllers ===============================

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OTPController as OTPController;

// =============================== End of Global Controllers =================================



// =============================== Start Authentication ======================================

use App\Http\Controllers\Authentication\LoginController as LoginController;
use App\Http\Controllers\Authentication\RegistrationController as RegistrationController;
use App\Http\Controllers\Authentication\RecoverController as RecoverController;

Route::get('logout', [LoginController::class, 'logout'])->name('Logout');
Route::post('get_otp', [OTPController::class, 'compose_mail'])->name('SendOTP');

Route::group(['prefix' => '/', 'middleware' => 'IsLoggedIn'],function(){
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

// =============================== End Authentication ========================================


// =============================== Start Patient =============================================
    
    Route::get('recover123', [RecoverController::class, 'index'])->name('patient');

// =============================== End Patient ===============================================

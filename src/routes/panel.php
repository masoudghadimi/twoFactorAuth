<?php

use Illuminate\Support\Facades\Route;
use Masoud\Twofactorauth\http\twoFactorAuth\TwoFactorAuthController;


Route::get('/security' , [TwoFactorAuthController::class , 'index'])->name('security');
Route::get('/two-factor-enable' , [TwoFactorAuthController::class , 'enable'])->name('enable.twoFactor');
Route::post('/two-factor-enable' , [TwoFactorAuthController::class , 'checkType']);
Route::get('/verify-phone' , [TwoFactorAuthController::class , 'indexVerifyCode'])->name('verify.code');
Route::post('/verify-phone' , [TwoFactorAuthController::class , 'checkVerifyCode']);
Route::post('/two-factor-disable' , [TwoFactorAuthController::class , 'disable'])->name('disable.twoFactor');

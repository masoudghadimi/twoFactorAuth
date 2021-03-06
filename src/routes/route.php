<?php

use Illuminate\Support\Facades\Route;
use Masoud\Twofactorauth\http\twoFactorAuth\VerifyCodesController;


Route::get('/two-factor-authenticated' , [VerifyCodesController::class , 'show'])->name('send.verify.code');
Route::post('/two-factor-authenticated' , [VerifyCodesController::class , 'check']);

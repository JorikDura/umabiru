<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Auth\Image\RemoveUserImageController;
use App\Http\Controllers\Api\V1\Auth\Image\UploadUserImageController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Auth\ResendCodeVerificationController;
use App\Http\Controllers\Api\V1\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->group(function () {
    Route::post('/login', LoginController::class);
    Route::post('/register', RegisterController::class);
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('email')->group(function () {
            Route::post('/verify', VerifyEmailController::class);
            Route::post('/resend', ResendCodeVerificationController::class);
        });
        Route::group(['middleware' => 'verified', 'prefix' => 'image'], function () {
            Route::post('/upload', UploadUserImageController::class);
            Route::delete('/remove', RemoveUserImageController::class);
        });
    });
});

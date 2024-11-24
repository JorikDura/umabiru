<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\User\Comment\DeleteUserCommentController;
use App\Http\Controllers\Api\V1\User\Comment\IndexCommentController;
use App\Http\Controllers\Api\V1\User\Comment\ShowUserCommentController;
use App\Http\Controllers\Api\V1\User\Comment\StoreUserCommentController;
use App\Http\Controllers\Api\V1\User\IndexUserController;
use App\Http\Controllers\Api\V1\User\ShowSelfController;
use App\Http\Controllers\Api\V1\User\ShowUserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/users')->group(function () {
    Route::get('/', IndexUserController::class);
    Route::get('/self', ShowSelfController::class);
    Route::get('/{userId}', ShowUserController::class);
    Route::prefix('{user}/comments')->group(function () {
        Route::get('/', IndexCommentController::class);
        Route::get('/{commentId}', ShowUserCommentController::class);
        Route::post('/', StoreUserCommentController::class);
        Route::delete('/{comment}', DeleteUserCommentController::class);
    });
});

<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Image\LikeImageController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/images')->group(function () {
    Route::post('{image}/like', LikeImageController::class);
});

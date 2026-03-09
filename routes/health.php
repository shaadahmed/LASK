<?php

use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Middleware\RequiresSecretToken;

Route::prefix('health')->group(function () {
    Route::get('/', [HealthController::class, 'simple'])
        ->name('health.simple');

    Route::middleware(RequiresSecretToken::class)->group(function () {
        Route::get('/json', [HealthController::class, 'json'])
            ->name('health.json');

        Route::get('/results', [HealthController::class, 'results'])
            ->name('health.results');
    });
});

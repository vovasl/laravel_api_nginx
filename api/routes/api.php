<?php

use Illuminate\Support\Facades\Route;
use App\Api\Http\Controllers\NginxController;
use App\Api\Http\Controllers\VirtualHostController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('nginx')->group(function () {
        Route::post('start', [NginxController::class, 'start']);
        Route::post('stop', [NginxController::class, 'stop']);
        Route::post('restart', [NginxController::class, 'restart']);
        Route::post('reload', [NginxController::class, 'reload']);
    });

    Route::prefix('virtual-hosts')->name('vhosts.')->group(function () {
        Route::post('/', [VirtualHostController::class, 'store'])->name('store');
        Route::delete('/{domain}', [VirtualHostController::class, 'destroy'])->name('destroy');
    });
});

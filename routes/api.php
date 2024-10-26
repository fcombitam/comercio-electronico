<?php

use App\Http\Controllers\api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('generate-token', [ApiController::class, 'getToken']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::middleware('ability:admin-logged')->prefix('product')->group(function() {
        Route::get('info', [ApiController::class, 'info']);
    });
});
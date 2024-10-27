<?php

use App\Http\Controllers\api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('generate-token', [ApiController::class, 'getToken']);

Route::middleware(['auth:sanctum', 'ability:admin-logged'])->group(function () {
    Route::get('products', [ApiController::class, 'getProducts']);
    Route::post('/update-product', [ApiController::class, 'updateProduct']);
});
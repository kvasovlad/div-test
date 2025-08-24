<?php

use App\Http\Controllers\RequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/requests', [RequestController::class, 'index']);
Route::post('/requests', [RequestController::class, 'save']);
Route::put('/requests', [RequestController::class, 'update']);

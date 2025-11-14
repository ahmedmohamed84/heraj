<?php

use App\Http\Controllers\Api\AttributeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/categories/{category}/attributes', [AttributeController::class, 'index']);

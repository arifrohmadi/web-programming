<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//import controller ProductController
use App\Http\Controllers\Api\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//products
Route::apiResource('/products', ProductController::class);
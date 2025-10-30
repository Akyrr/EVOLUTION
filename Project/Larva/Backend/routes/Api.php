<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
    // return $request->user();
// })->middleware('auth:sanctum');

use Illuminate\Support\Facades\Route;

// Kode minimal tanpa error
Route::get('/test', function () {
    return response()->json(['message' => 'API working']);
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// Import Controller yang sudah dibuat
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\MemberController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Menggunakan apiResource untuk menangani semua endpoint Books
Route::apiResource('books', BookController::class);

// Menggunakan apiResource untuk menangani semua endpoint Members 
Route::apiResource('members', MemberController::class);
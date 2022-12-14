<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', App\Http\Controllers\Api\RegisterController::class)->name('register');
Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');
Route::apiResource('/dosen', App\Http\Controllers\Api\DosenController::class);
Route::apiResource('/mahasiswa', App\Http\Controllers\Api\MahasiswaController::class);
Route::apiResource('/mata_kuliah', App\Http\Controllers\Api\MataKuliahController::class);
Route::apiResource('/data_mata_kuliah', App\Http\Controllers\Api\DataMataKuliahController::class);


<?php

use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/file/{filename}/{name}', 'App\Http\Controllers\FileController@show');
Route::post('/file/{param}', 'App\Http\Controllers\FileController@update');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::resource('/edukasi',EdukasiController::class);
Route::resource('/user',UserController::class);
Route::resource('/mahasiswa',MahasiswaController::class);
Route::resource('/kaprodi',KaprodiController::class);
Route::resource('/pelaporan',PelaporanController::class);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

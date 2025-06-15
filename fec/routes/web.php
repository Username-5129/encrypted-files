<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EncryptedFilesController;
use App\Http\Controllers\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::resource('file', EncryptedFilesController::class);
Route::get('/files', [EncryptedFilesController::class, 'index'])->name('files.index');
Route::get('/files/{file}/download', [EncryptedFilesController::class, 'download'])->name('files.download');
Route::post('/file/{id}', [EncryptedFilesController::class, 'update']);


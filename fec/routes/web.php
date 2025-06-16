<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\EncryptedFilesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\CommentController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::post('/homepage/settings', [HomeController::class, 'updateSettings'])->name('homepage.settings.update');
});

Route::get('/files/{file}', [EncryptedFilesController::class, 'show'])->name('files.show');

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
Route::post('/files/{file}/check-password', [EncryptedFilesController::class, 'checkPassword'])->name('files.checkPassword');

Route::get('/files/{file}/password', function (File $file) {
    return view('files.password', compact('file'));
})->name('files.password');

Route::middleware(['auth'])->group(function () {
    Route::post('/files/{file}/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/friends', [FriendController::class, 'index'])->name('friends.index');
    Route::post('/friends/add', [FriendController::class, 'add'])->name('friends.add');
    Route::post('/friends/respond/{id}', [FriendController::class, 'respondRequest'])->name('friends.respond');
    Route::delete('/friends/remove/{friendId}', [FriendController::class, 'remove'])->name('friends.remove');

});


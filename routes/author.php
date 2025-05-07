<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Author\AuthorLoginController;
use App\Http\Controllers\Author\AuthorHomeController;
use App\Http\Controllers\Author\AuthorProfileController;
use App\Http\Controllers\Author\AuthorPostController;

// Rute login/logout
Route::get('login', [AuthorLoginController::class, 'index'])->name('author_login');
Route::post('login-submit', [AuthorLoginController::class, 'login_submit'])->name('author_login_submit');
Route::get('logout', [AuthorLoginController::class, 'logout'])->name('author_logout');

// Middleware untuk hanya penulis yang login
Route::middleware(['auth:author'])->group(function () {
    Route::get('home', [AuthorHomeController::class, 'index'])->name('author_home');
    Route::get('edit-profile', [AuthorProfileController::class, 'index'])->name('author_profile');
    Route::post('edit-profile-submit', [AuthorProfileController::class, 'profile_submit'])->name('author_profile_submit');

    Route::get('post/show', [AuthorPostController::class, 'show'])->name('author_post_show');
    Route::get('post/create', [AuthorPostController::class, 'create'])->name('author_post_create');
    Route::post('post/store', [AuthorPostController::class, 'store'])->name('author_post_store');
    Route::get('post/edit/{id}', [AuthorPostController::class, 'edit'])->name('author_post_edit');
    Route::post('post/update/{id}', [AuthorPostController::class, 'update'])->name('author_post_update');
    Route::get('post/delete/{id}', [AuthorPostController::class, 'delete'])->name('author_post_delete');
    Route::get('post/tag/delete/{id}/{id1}', [AuthorPostController::class, 'delete_tag'])->name('author_post_delete_tag');
});

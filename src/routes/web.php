<?php

use App\Http\Controllers\FriendRequestsController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionsController;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function() {
    Route::resource('friends', FriendsController::class)->only(['index', 'destroy']);
    Route::resource('friend-requests', FriendRequestsController::class)->except(['show', 'edit']);
    Route::resource('transactions', TransactionsController::class)->only(['index', 'create', 'store']);

    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::redirect('/', route('transactions.index'));
});

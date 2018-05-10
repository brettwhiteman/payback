<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/', function() {
        return redirect()->route('transactions.index');
    });

    Route::resource('friends', 'FriendsController')->only(['index', 'destroy']);
    Route::resource('friend-requests', 'FriendRequestsController')->except(['show', 'edit']);
    Route::resource('transactions', 'TransactionsController')->only(['index', 'create', 'store']);

    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::put('profile', 'ProfileController@update')->name('profile.update');
});

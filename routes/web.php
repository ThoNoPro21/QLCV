<?php

use App\Http\Controllers\Api\V1\GoogleController;
use App\Http\Controllers\Api\V1\ProjectInvitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

require __DIR__.'/auth.php';
// Google Sign In

Route::get('/redirect', [GoogleController::class, 'redirect'])->middleware('web');
Route::get('/callback', [GoogleController::class, 'loginCallback'])->middleware('web');
Route::get('/accept-invite/{token}', [ProjectInvitationController::class, 'accept'])->middleware('web')->name('accept.invite');
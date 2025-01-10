<?php

use App\Http\Controllers\Api\V1\GoogleController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Get info user
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Google Sign In
Route::get('/redirect', [GoogleController::class, 'redirect']);
Route::get('/callback', [GoogleController::class, 'loginCallback']);

Route::middleware(['auth:sanctum'])->post('/project/create',[ProjectController::class, 'create']); //Create project
Route::middleware(['auth:sanctum'])->patch('/project/edit/{id}',[ProjectController::class, 'edit']); //Update project
Route::middleware(['auth:sanctum'])->delete('/project/delete/{id}',[ProjectController::class, 'delete']); //Delete project
Route::middleware(['auth:sanctum'])->get('/project/index',[ProjectController::class, 'index']); //Get all project



Route::middleware(['auth:sanctum'])->post('/subscription/create',[SubscriptionController::class, 'create']); //Create subscription
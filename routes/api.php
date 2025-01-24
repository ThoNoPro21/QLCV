<?php

use App\Http\Controllers\Api\V1\GoogleController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\StatusTaskController;
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

// Project

Route::middleware(['auth:sanctum'])->post('/project/create',[ProjectController::class, 'create']); //Create project
Route::middleware(['auth:sanctum'])->patch('/project/edit/{id}',[ProjectController::class, 'edit']); //Edit project
Route::middleware(['auth:sanctum'])->delete('/project/delete/{id}',[ProjectController::class, 'delete']); //Delete project
Route::middleware(['auth:sanctum'])->get('/project/index',[ProjectController::class, 'index']); //Get all project

// StatusTask
Route::middleware(['auth:sanctum'])->post('/statusTask/create',[StatusTaskController::class, 'create']); //Create statusTask
Route::middleware(['auth:sanctum'])->patch('/statusTask/edit/{id}',[StatusTaskController::class, 'edit']); //Edit statusTask
Route::middleware(['auth:sanctum'])->delete('/statusTask/delete/{id}',[StatusTaskController::class, 'delete']); //Delete statusTask
Route::middleware(['auth:sanctum'])->get('/statusTask/project/{id}',[StatusTaskController::class, 'index']); //Get StatusTask theo project




//Subscription

Route::middleware(['auth:sanctum'])->post('/subscription/create',[SubscriptionController::class, 'create']); //Create subscription
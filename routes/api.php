<?php

use App\Http\Controllers\Api\V1\GoogleController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\StatusTaskController;
use App\Http\Controllers\Api\V1\SubscriptionController;
use App\Http\Controllers\Api\V1\TaskCardController;
use App\Http\Controllers\Api\V1\TaskCardDetailController;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Get info user
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    $user= $request->user();
    $employee = Employee::where('userId', $user->id)->first();
    return response()->json([
        'user' => $user,
        'employee' => $employee,
    ]);
});

// Google Sign In
Route::get('/redirect', [GoogleController::class, 'redirect']);
Route::get('/callback', [GoogleController::class, 'loginCallback']);

// Project
Route::post('/project/create',[ProjectController::class, 'create']); //Create project

// Route::middleware(['auth:sanctum'])->post('/project/create',[ProjectController::class, 'create']); //Create project
Route::middleware(['auth:sanctum'])->patch('/project/edit/{id}',[ProjectController::class, 'edit']); //Edit project
Route::middleware(['auth:sanctum'])->delete('/project/delete/{id}',[ProjectController::class, 'delete']); //Delete project
Route::middleware(['auth:sanctum'])->get('/project/index',[ProjectController::class, 'index']); //Get all project

// StatusTask
Route::middleware(['auth:sanctum'])->post('/statusTask/create',[StatusTaskController::class, 'create']); //Create statusTask
Route::middleware(['auth:sanctum'])->patch('/statusTask/edit/{id}',[StatusTaskController::class, 'edit']); //Edit statusTask
Route::middleware(['auth:sanctum'])->delete('/statusTask/delete/{id}',[StatusTaskController::class, 'delete']); //Delete statusTask
Route::middleware(['auth:sanctum'])->get('/statusTask/project/{id}',[StatusTaskController::class, 'index']); //Get StatusTask theo project

//TaskCard
Route::middleware(['auth:sanctum'])->post('/taskCard/create',[TaskCardController::class, 'create']); //Create TaskCard
Route::middleware(['auth:sanctum'])->patch('/taskCard/edit/{id}',[TaskCardController::class, 'edit']); //Edit TaskCard
Route::middleware(['auth:sanctum'])->delete('/taskCard/delete/{id}',[TaskCardController::class, 'delete']); //Delete TaskCard

//TaskCardDetail
Route::middleware(['auth:sanctum'])->post('/taskCardDetail/create',[TaskCardDetailController::class, 'create']); //Create TaskCardDetail
Route::middleware(['auth:sanctum'])->patch('/taskCardDetail/edit/{id}',[TaskCardDetailController::class, 'edit']); //Edit TaskCardDetail
Route::middleware(['auth:sanctum'])->delete('/taskCardDetail/delete/{id}',[TaskCardDetailController::class, 'delete']); //Delete TaskCardDetail



//Subscription

Route::middleware(['auth:sanctum'])->post('/subscription/create',[SubscriptionController::class, 'create']); //Create subscription
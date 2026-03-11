<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItineraryController;
use App\Http\Controllers\Api\DestinationController;



Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});




Route::post('/register' , [AuthController::class , 'store'])->name('register');
Route::post('/login' , [AuthController::class , 'login'])->name('login');


Route::middleware('auth:sanctum')->group( function (){
    
    Route::post('/logout' , [AuthController::class , 'destroy'])->name('logout');
    
    Route::post('/users', [UserController::class , 'store'])->name('users.store');
    Route::get('/users', [UserController::class , 'index'])->name('users.show');
    Route::get('/users/{id}', [UserController::class , 'show'])->name('users.getUser');
    Route::patch('/users/{id}', [UserController::class , 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class , 'destroy'])->name('users.delete');
    
    Route::post('/itineraries', [ItineraryController::class , 'store'])->name('itineraries.store');
    Route::get('/itineraries', [ItineraryController::class , 'index'])->name('itineraries.show');
    Route::get('/itineraries/{id}', [ItineraryController::class , 'show'])->name('itineraries.getUser');
    Route::patch('/itineraries/{id}', [ItineraryController::class , 'update'])->name('itineraries.update');
    Route::delete('/itineraries/{id}', [ItineraryController::class , 'destroy'])->name('itineraries.delete');
    
    Route::post('/destinations', [DestinationController::class , 'store'])->name('destinations.store');
    Route::get('/destinations', [DestinationController::class , 'index'])->name('destinations.show');
    Route::get('/destinations/{id}', [DestinationController::class , 'show'])->name('destinations.getUser');
    Route::patch('/destinations/{id}', [DestinationController::class , 'update'])->name('destinations.update');
    Route::delete('/destinations/{id}', [DestinationController::class , 'destroy'])->name('destinations.delete');
    
    });
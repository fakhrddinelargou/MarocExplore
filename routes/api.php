<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ItineraryController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\FavoriteController;

Route::post('/auth/register', [AuthController::class, 'store'])->name('register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/forgot-password', [AuthController::class, 'resetPassword'])->name('users.resetPassword');
Route::post('/auth/reset-password', [AuthController::class, 'updatePassword'])->name('users.generatePassword');


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    Route::get('/itineraries', [ItineraryController::class, 'index'])->name('itineraries.show');
    Route::post('/itineraries', [ItineraryController::class, 'store'])->name('itineraries.store');

    Route::get('/itineraries/search', [ItineraryController::class, 'search'])->name('itineraries.search');
    Route::get('/itineraries/{id}', [ItineraryController::class, 'show'])->name('itineraries.getItinerary');
    Route::get('/category/{category}/itineraries', [ItineraryController::class, 'getItineraryByCategory'])->name('itineraries.getByCategory');

    Route::patch('/itineraries/{id}', [ItineraryController::class, 'update'])->name('itineraries.update');
    Route::delete('/itineraries/{id}', [ItineraryController::class, 'destroy'])->name('itineraries.delete');

    Route::post('/destinations', [DestinationController::class, 'store'])->name('destinations.store');
    Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.show');
    Route::get('/destinations/{id}', [DestinationController::class, 'show'])->name('destinations.getDestination');
    Route::patch('/destinations/{id}', [DestinationController::class, 'update'])->name('destinations.update');
    Route::delete('/destinations/{id}', [DestinationController::class, 'destroy'])->name('destinations.delete');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorite.getAll');
    Route::post('/favorites/{id}', [FavoriteController::class, 'store'])->name('favorite.store');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorite.delete');

});
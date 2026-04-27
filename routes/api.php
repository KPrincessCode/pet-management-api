<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\BookingController;

Route::get('/pets', [PetController::class, 'index']);
Route::post('/pets', [PetController::class, 'store']);
Route::get('/pets/{id}', [PetController::class, 'show']);
Route::put('/pets/{id}', [PetController::class, 'update']);
Route::delete('/pets/{id}', [PetController::class, 'destroy']);


Route::get('/bookings', [BookingController::class, 'index']);
Route::post('/bookings', [BookingController::class, 'store']);
Route::get('/bookings/{id}', [BookingController::class, 'show']);
Route::put('/bookings/{id}', [BookingController::class, 'update']);
Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
Route::put('/bookings/{id}/approve', [BookingController::class, 'approve']);
Route::put('/bookings/{id}/reject', [BookingController::class, 'reject']);
Route::put('/bookings/{id}/check-in', [BookingController::class, 'checkIn']);
Route::put('/bookings/{id}/check-out', [BookingController::class, 'checkOut']);
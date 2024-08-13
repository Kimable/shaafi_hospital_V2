<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AppointmentsController;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Route;


Route::get('/doctors', function () {
    $doctors = Doctor::with('user')->get();
    return response()->json($doctors, 200);
});

Route::middleware('auth:sanctum')->post('book-appointment', [AppointmentsController::class, 'bookAppointment'])->name('book-appointment');
Route::middleware('auth:sanctum')->get('appointments', [AppointmentsController::class, 'appointments'])->name('appointments');


Route::middleware('auth:sanctum')->get('/profile', [UserController::class, 'profile'])->name('profile');
Route::middleware('auth:sanctum')->get('/update-profile', [UserController::class, 'updateProfile'])->name('update-profile');


Route::post('register', [UserController::class, 'registration'])->name('register');
Route::post('login', [UserController::class, 'login'])->name('login');
Route::get('/auth-fail', function () {
    return response()->json(['message' => 'Invalid token'], 401);
})->name('/auth-fail');

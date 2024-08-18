<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\VehicleController;
use App\Models\Landing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/register-nelly', [AuthController::class, 'register']);
Route::post('/login-nelly', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->get('/protected', function () {
    return response()->json(['message' => 'You are authenticated!']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    //landing create
    Route::post('/landing', [LandingController::class, 'store']);
    //get landing
    Route::get('/landing/{id}', [LandingController::class, 'index']);
    Route::delete('/landing/{id}', [LandingController::class, 'destroy']);
    // vehicle create 
    Route::post('/vehicle', [VehicleController::class, 'store']);
    Route::get('/vehicles/{landingId}', [VehicleController::class, 'index']);
    Route::delete('/vehicle/{id}', [VehicleController::class, 'destroy']);
    //cambiar la landing de status
    Route::patch('/landing/status', [LandingController::class, 'status']);
    //restaurar una landing que ha sido borrado suavemente
    Route::get('/landings/trashed/{userId}', [LandingController::class, 'trashed']);
    //obtener la landing de un usuario especifico
    Route::get('/landings/{userId}/{landingId}', [LandingController::class, 'onelanding']);


    //update users info
    Route::post('/users', [AuthController::class, 'update']);
});

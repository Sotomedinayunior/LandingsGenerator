<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::post('/register-nelly', [AuthController::class, 'register']);
Route::post('/login-nelly', [AuthController::class, 'login']);



Route::middleware('auth:sanctum')->get('/protected', function () {
    return response()->json(['message' => 'You are authenticated!']);
});
Route::post('/nelly-logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
route::post('/users-update', [AuthController::class, 'update'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    
    
    //landing create
    Route::post('/landing', [LandingController::class, 'store']);
    //get landing
    Route::get('/landing/{id}', [LandingController::class, 'index']);
    //delete soft landing o barrado suave
    Route::delete('/landing/{id}', [LandingController::class, 'destroy']);
    //borrado permanente
    Route::delete('/landing/deletedFinal/{id}' , [LandingController::class , 'deletefinal']);

  
    //cambiar la landing de status
    Route::patch('/landing/status', [LandingController::class, 'status']);
    // Ruta para restaurar una landing eliminada
    Route::post('/landing/restore/{id}', [LandingController::class, 'restore']);
   //obtener landing borradas por el usuario
    Route::get('/landing/deleted/{userId}', [LandingController::class, 'getDeletedLandings']);
    
    //obtener la landing de un usuario especifico
    Route::get('/landings/{userId}/{landingId}', [LandingController::class, 'onelanding']);
    //borrado suave de un vehicle
    Route::delete('/vehicle/{id}', [VehicleController::class, 'destroy']);
    //crear el vehicle
    Route::post('/vehicle', [VehicleController::class, 'store']);
    //obtener todos los vehiculos y sus relaciones nota:optimizar esto
    Route::get('/vehicles/{landingId}', [VehicleController::class, 'index']);
    //obtener las reservaciones 
    Route::get('/reservations/{landing_id}', [ReservationController::class, 'index']);
    //borrar un vehicles de una landing
    Route::delete('/vehicle/{landing_id}' , [VehicleController::class , 'destroy']);







    //update users info
    // Route::post('/users', [AuthController::class, 'update']);
});

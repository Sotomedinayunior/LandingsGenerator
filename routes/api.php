<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PublicLandingController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');



Route::post('/register-nelly', [AuthController::class, 'register']);
Route::post('/login-nelly', [AuthController::class, 'login']);

Route::get('/publicLanding/{name}', [PublicLandingController::class, 'index']);
Route::get('/publicLanding/{name}/vehicle/{id}', [PublicLandingController::class, 'showVehicle']);
Route::post('/reservations', [ReservationController::class, 'store']);
//obtener las caracteristicas especiales de un vehiculo
Route::get('vehicle/{vehicleId}/special-features-public', [VehicleController::class, 'getSpecialFeatures']);

Route::middleware('auth:sanctum')->get('/protected', function () {
    return response()->json(['message' => 'You are authenticated!']);
});

Route::post('/nelly-logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/users-update/{id}', [AuthController::class, 'update'])->middleware('auth:sanctum');
Route::get('/users/{id}', [AuthController::class, 'show'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    //landing create
    Route::post('/landing', [LandingController::class, 'store']);
    //get landing
    Route::get('/landing/{id}', [LandingController::class, 'index']);
    //actualizar una landing
    Route::post('/landing-update/{userId}/{landingId}', [LandingController::class, 'update']);
    //delete soft landing o barrado suave
    Route::delete('/landing/{id}', [LandingController::class, 'destroy']);
    //borrado permanente
    Route::delete('/landing/deletedFinal/{id}', [LandingController::class, 'deletefinal']);
    // Definir la ruta para agregar los campos place_of_departure y arrival_place
    Route::post('/landings/{id}/addLocation', [LandingController::class, 'addLocation']);
    //cambiar la landing de status
    Route::patch('/landing/status', [LandingController::class, 'status']);
    // Ruta para restaurar una landing eliminada
    Route::post('/landing/restore/{id}', [LandingController::class, 'restore']);
    //obtener landing borradas por el usuario
    Route::get('/landing/deleted/{userId}', [LandingController::class, 'getDeletedLandings']);
   //agregando los metadatos en la landing
    Route::post('/landings/{userId}/{landingId}/meta', [LandingController::class, 'updateMeta']);

    //obtener la landing de un usuario especifico
    Route::get('/landings/{userId}/{landingId}', [LandingController::class, 'onelanding']);

    //crear el vehicle
    Route::post('/vehicle', [VehicleController::class, 'store']);
  

    //obtener todos los vehiculos y sus relaciones nota:optimizar esto
    Route::get('/vehicles/{landingId}', [VehicleController::class, 'index']);
    //obtener un vehiculo espefico
    Route::get('/vehicles/{landingId}/{vehicleId}', [VehicleController::class, 'show']);
    //obtener las reservaciones 
    Route::get('/reservations/{landing_id}', [ReservationController::class, 'index']);
    //obtener las reservaciones de un usuario
    Route::get('/reservations/user/{user_id}', [ReservationController::class, 'indexUser']);
    //actualizar un vehiculo
    Route::put('/vehicles/{landingId}/{vehicleId}', [VehicleController::class, 'update']);
    //agregar feature a un vehiculo
    Route::post('special-feature/{vehicleId}/', [VehicleController::class, 'storeSpecialFeature']);
    //obtener las caracteristicas especiales de un vehiculo
    Route::get('vehicle/{vehicleId}/special-features', [VehicleController::class, 'getSpecialFeatures']);

    //borrar un vehiculo
    Route::delete('/vehicle/{landing_id}/{vehicle_id}', [VehicleController::class, 'destroy']);
});

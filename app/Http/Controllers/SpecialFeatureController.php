<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\SpecialFeature;

class SpecialFeatureController extends Controller
{
    // Método para obtener todas las características especiales
    public function index()
    {
        return  SpecialFeature::all();
    }


    // Método para crear una nueva característica especial
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $specialFeature = SpecialFeature::create($validatedData);

        return response()->json([
            'message' => 'Característica especial creada exitosamente.',
            'data' => $specialFeature
        ], 201);
    }
    public function assignToVehicle(Request $request, $vehicleId)
    {
        try {
            // Validación de los datos de entrada
            $validatedData = $request->validate([
                'special_feature_id' => 'required|exists:special_features,id',
                'name' => 'required|string',
            ]);

            // Encuentra el vehículo por su ID
            $vehicle = Vehicle::findOrFail($vehicleId);

            // Verifica si la característica especial ya está asignada al vehículo
            $specialFeatureExists = $vehicle->specialFeatures()->where('special_feature_id', $validatedData['special_feature_id'])->exists();

            if ($specialFeatureExists) {
                return response()->json([
                    'message' => 'Esta característica especial ya está asignada a este vehículo.'
                ], 400);
            }

            // Asigna la característica especial al vehículo
            $vehicle->specialFeatures()->attach($validatedData['special_feature_id'], [
                'name' => $validatedData['name'],
            ]);

            // Recarga las características especiales del vehículo
            $vehicle->load('specialFeatures');

            return response()->json([
                'message' => 'Característica especial asignada al vehículo exitosamente.',
                'data' => $vehicle->specialFeatures, // Ahora devuelve las características asignadas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al asignar la característica especial.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    // Método para obtener las características especiales de un vehículo específico
    public function getFeaturesByVehicle($vehicleId)
    {
        try {
            // Encuentra el vehículo por su ID
            $vehicle = Vehicle::with('specialFeatures')->findOrFail($vehicleId);

            // Retorna las características relacionadas
            return response()->json([
                'message' => 'Características especiales obtenidas exitosamente.',
                'data' => $vehicle->specialFeatures
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las características especiales del vehículo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }





    // Método para eliminar una característica especial específica
    public function delete($id)
    {
        $specialFeature = SpecialFeature::find($id);

        if (!$specialFeature) {
            return response()->json([
                'message' => 'Característica especial no encontrada.'
            ], 404);
        }

        // Elimina las asignaciones de vehículos antes de eliminar la característica
        $specialFeature->vehicles()->detach();

        // Elimina la característica especial
        $specialFeature->delete();

        return response()->json([
            'message' => 'Característica especial eliminada exitosamente.'
        ], 200);
    }
}

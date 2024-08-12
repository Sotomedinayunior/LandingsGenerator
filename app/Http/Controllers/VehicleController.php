<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Landing;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // Mostrar una lista de todos los vehículos con sus relaciones
    public function index()
    {
        // Obtener todos los vehículos con sus relaciones
        $vehicles = Vehicle::with(['landing', 'reservations'])->get();
        return response()->json($vehicles, 200);
    }

    // Guardar un nuevo vehículo en la base de datos
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'id_landing' => 'required|exists:landings,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'luggage' => 'required|integer',
            'people' => 'required|integer',
            'type_of_car' => 'required|string|max:255',
            'bluetooth' => 'boolean',
            'siriusxm' => 'boolean',
            'manual' => 'boolean',
            'automatic' => 'boolean',
            'cvt' => 'boolean',
        ]);

        // Crear el vehículo
        $vehicle = Vehicle::create($validatedData);

        return response()->json(['message' => 'Vehículo creado exitosamente', 'vehicle' => $vehicle], 201);
    }

    // Mostrar los detalles de un vehículo específico
    public function show($id)
    {
        $vehicle = Vehicle::with(['landing', 'reservations'])->findOrFail($id);
        return response()->json($vehicle, 200);
    }

    // Actualizar un vehículo existente en la base de datos
    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'nullable|string',
            'price' => 'numeric',
            'luggage' => 'integer',
            'people' => 'integer',
            'type_of_car' => 'string|max:255',
            'bluetooth' => 'boolean',
            'siriusxm' => 'boolean',
            'manual' => 'boolean',
            'automatic' => 'boolean',
            'cvt' => 'boolean',
        ]);

        // Obtener el vehículo y actualizar sus datos
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($validatedData);

        return response()->json(['message' => 'Vehículo actualizado exitosamente', 'vehicle' => $vehicle], 200);
    }

    // Eliminar un vehículo y sus reservas relacionadas
    public function destroy($id)
    {
        // Obtener el vehículo
        $vehicle = Vehicle::findOrFail($id);

        // Eliminar las reservas asociadas
        $vehicle->reservations()->delete();

        // Eliminar el vehículo
        $vehicle->delete();

        return response()->json(['message' => 'Vehículo eliminado exitosamente'], 200);
    }
}

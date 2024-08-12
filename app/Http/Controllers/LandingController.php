<?php

namespace App\Http\Controllers;

use App\Models\Landing;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    // Mostrar una lista de todos los landings con sus relaciones
    public function index()
    {
        // Obtener todos los landings con sus relaciones
        $landings = Landing::with(['user', 'vehicles', 'reservations'])->get();
        return response()->json($landings, 200);
    }

    // Guardar un nuevo landing en la base de datos
    public function create(Request $request)
    {
        // 1. Validación de los datos
        $validatedData = $request->validate([
            'id_users_landing' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validación de la imagen
            'color_primary' => 'nullable|string|max:7',
            'color_secondary' => 'nullable|string|max:7',
            'color_tertiary' => 'nullable|string|max:7',
            'published' => 'boolean',
        ]);
    
        // 2. Subida y almacenamiento de la imagen
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            // Crear un nombre único para la imagen
            $logoName = time() . '_' . $logo->getClientOriginalName();
            // Mover la imagen a la carpeta public/logos
            $logo->move(public_path('logos'), $logoName);
            // Guardar la URL de la imagen
            $logoUrl = asset('logos/' . $logoName);
        } else {
            $logoUrl = null; // Si no se sube una imagen, dejamos el valor como nulo
        }
    
        // 3. Guardar los datos en la base de datos
        $landing = new Landing();
        $landing->id_users_landing = $validatedData['id_users_landing'];
        $landing->name = $validatedData['name'];
        $landing->logo = $logoUrl; // Guardamos la URL de la imagen en la base de datos
        $landing->color_primary = $validatedData['color_primary'];
        $landing->color_secondary = $validatedData['color_secondary'];
        $landing->color_tertiary = $validatedData['color_tertiary'];
        $landing->published = $validatedData['published'] ?? false; // Valor por defecto en false si no se proporciona
        $landing->save();
    
        // Retornar una respuesta (podría ser un redireccionamiento o un mensaje JSON)
        return response()->json([
            'message' => 'Landing page created successfully',
            'landing' => $landing,
        ]);
    }
    
    // Mostrar los detalles de un landing específico
    public function show($id)
    {
        $landing = Landing::with(['user', 'vehicles', 'reservations'])->findOrFail($id);
        return response()->json($landing, 200);
    }

    // Actualizar un landing existente en la base de datos
    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'logo' => 'nullable|string|max:255',
            'color_primary' => 'nullable|string|max:7',
            'color_secondary' => 'nullable|string|max:7',
            'color_tertiary' => 'nullable|string|max:7',
            'published' => 'boolean',
            'vehicles' => 'nullable|array',
            'vehicles.*.id' => 'nullable|exists:vehicles,id',
            'vehicles.*.name' => 'required_with:vehicles|string|max:255',
            'vehicles.*.description' => 'nullable|string',
            'vehicles.*.price' => 'required_with:vehicles|numeric',
        ]);

        // Obtener el landing y actualizar sus datos
        $landing = Landing::findOrFail($id);
        $landing->update($validatedData);

        // Si se pasaron vehículos, actualizarlos o crearlos
        if (!empty($validatedData['vehicles'])) {
            foreach ($validatedData['vehicles'] as $vehicleData) {
                if (isset($vehicleData['id'])) {
                    // Actualizar vehículo existente
                    $vehicle = Vehicle::findOrFail($vehicleData['id']);
                    $vehicle->update($vehicleData);
                } else {
                    // Crear nuevo vehículo
                    $landing->vehicles()->create($vehicleData);
                }
            }
        }

        return response()->json(['message' => 'Landing actualizado exitosamente', 'landing' => $landing], 200);
    }

    // Eliminar un landing y sus vehículos relacionados
    public function destroy($id)
    {
        // Obtener el landing
        $landing = Landing::findOrFail($id);

        // Eliminar los vehículos asociados
        $landing->vehicles()->delete();

        // Eliminar el landing
        $landing->delete();

        return response()->json(['message' => 'Landing eliminado exitosamente'], 200);
    }
}

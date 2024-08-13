<?php

namespace App\Http\Controllers;

use App\Models\Landing;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class VehicleController extends Controller
{
    /**
     * Lista todos los vehículos asociados a una landing específica.
     *
     * @param  int  $landingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($landingId)
    {
        // Validar que la landing existe
        $landing = Landing::find($landingId);
        if (!$landing) {
            return response()->json(['message' => 'Landing no encontrada'], 404);
        }

        // Obtener todos los vehículos asociados a la landing
        $vehicles = Vehicle::where('id_landing', $landingId)->get();

        // Devolver una respuesta en formato JSON
        return response()->json([
            'message' => $vehicles->isEmpty() ? 'No se encontraron vehículos para esta landing' : 'Vehículos encontrados',
            'vehicles' => $vehicles
        ]);
    }
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'required|string|max:255',
            'id_landing'=>'required|integer',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'luggage' => 'required|integer',
            'people' => 'required|integer',
            'type_of_car' => 'required|string',
            'bluetooth' => 'boolean',
            'siriusxm' => 'boolean',
            'manual' => 'boolean',
            'automatic' => 'boolean',
            'cvt' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validar imágenes
        ]);

        // Crear el vehículo
        $vehicle = Vehicle::create($request->except('images'));

        // Manejar las imágenes
        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                // Guardar la imagen en el almacenamiento público
                $imagePath = $image->store('vehicle_images', 'public');

                // Guardar la ruta de la imagen en la base de datos
                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'path_images' => $imagePath,
                ]);
            }
        }

        return response()->json(['message' => 'Vehículo creado con éxito.'], 201);
    }
    public function destroy($id)
    {
        // Buscar el vehículo por ID
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        // Obtener todas las imágenes asociadas al vehículo
        $images = VehicleImage::where('vehicle_id', $id)->get();

        // Eliminar las imágenes del almacenamiento y de la base de datos
        foreach ($images as $image) {
            // Eliminar el archivo de la carpeta pública
            if (Storage::exists('public/' . $image->path_images)) {
                Storage::delete('public/' . $image->path_images);
            }

            // Eliminar la entrada de la base de datos (soft delete)
            $image->delete();
        }

        // Eliminar el vehículo de la base de datos (soft delete)
        $vehicle->delete();

        return response()->json(['message' => 'Vehículo y sus imágenes eliminadas con éxito.'], 200);
    }
    
}

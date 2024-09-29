<?php

namespace App\Http\Controllers;

use App\Models\Landing;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


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

        // Obtener todos los vehículos asociados a la landing, incluyendo las imágenes
        $vehicles = Vehicle::where('id_landing', $landingId)
            ->with('images')  // Incluir las imágenes relacionadas
            ->get();

        // Devolver una respuesta en formato JSON
        return response()->json([
            'message' => $vehicles->isEmpty() ? 'No se encontraron vehículos para esta landing' : 'Vehículos encontrados',
            'vehicles' => $vehicles
        ]);
    }

    /**
     * Actualiza un vehículo por su ID, verificando que pertenezca a una landing específica.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'id_landing' => 'required|integer',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'luggage' => 'sometimes|required|integer',
            'people' => 'sometimes|required|integer',
            'type_of_car' => 'sometimes|required|string',
            'bluetooth' => 'boolean',
            'siriusxm' => 'boolean',
            'manual' => 'boolean',
            'automatic' => 'boolean',
            'cvt' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        // Verificar que el vehículo existe
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        // Verificar que el vehículo pertenece a la landing especificada
        if ($vehicle->id_landing !== $request->id_landing) {
            return response()->json(['message' => 'El vehículo no pertenece a la landing especificada'], 403);
        }

        // Actualizar los campos del vehículo
        $vehicle->update($request->except(['images']));

        // Manejar la actualización de las imágenes si hay nuevas
        if ($request->hasFile('images')) {
            // Eliminar imágenes anteriores si es necesario
            $oldImages = $vehicle->images; // Asumimos que tiene una relación con VehicleImage
            foreach ($oldImages as $oldImage) {
                if (Storage::exists('public/' . $oldImage->path_images)) {
                    Storage::delete('public/' . $oldImage->path_images);
                }
                $oldImage->delete();
            }

            // Guardar las nuevas imágenes
            $images = $request->file('images');
            foreach ($images as $image) {
                $imagePath = $image->store('vehicle_images', 'public');
                VehicleImage::create([
                    'vehicle_id' => $vehicle->id,
                    'path_images' => $imagePath,
                ]);
            }
        }

        return response()->json(['message' => 'Vehículo actualizado con éxito.'], 200);
    }

    public function store(Request $request)
    {
        try {
            // Validación manual con Validator
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'id_landing' => 'required|integer',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'luggage' => 'required|integer',
                'people' => 'required|integer',
                'type_of_car' => 'required|string',
                'transmision' => 'required|string',
                'bluetooth' => 'nullable|boolean',
                'gps' => 'nullable|boolean',
                'siriusxm' => 'nullable|boolean',
                'apple_car' => 'nullable|boolean',
                'images' => 'required|array',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            // Si la validación falla, retornamos los errores
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Crear el vehículo sin imágenes
            $vehicle = Vehicle::create($request->except('images'));

            // Variable para almacenar las URLs de las imágenes
            $imageUrls = [];

            // Manejo de imágenes
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $imagePath = $image->store('vehicle_images', 'public');
                        $imageUrl = asset('storage/' . $imagePath); // Generar URL completa
                        // Guardar cada imagen asociada al vehículo
                        $vehicleImage = VehicleImage::create([
                            'vehicle_id' => $vehicle->id,
                            'path_images' => $imagePath,
                        ]);
                        // Agregar la URL de la imagen al array para incluir en la respuesta
                        $imageUrls[] = $imageUrl;
                    }
                }
            }

            // Devolver el vehículo junto con las URLs de las imágenes
            return response()->json([
                'message' => 'Vehículo creado con éxito.',
                'vehicle' => $vehicle,
                'images' => $imageUrls
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error: ' . $e->getMessage()], 500);
        }
    }






    /**
     * Agrega un campo dinámico a un vehículo específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addDynamicField(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'key' => 'required|string', // Clave del campo dinámico
            'value' => 'required', // Valor del campo dinámico (puede ser cualquier tipo)
        ]);

        // Buscar el vehículo por ID
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return response()->json(['message' => 'Vehículo no encontrado'], 404);
        }

        // Obtener los campos dinámicos actuales (si existen) y convertir a array
        $dynamicFields = $vehicle->dynamic_fields ? json_decode($vehicle->dynamic_fields, true) : [];

        // Añadir el nuevo campo dinámico al array
        $dynamicFields[$request->key] = $request->value;

        // Actualizar el campo dynamic_fields en el vehículo
        $vehicle->dynamic_fields = json_encode($dynamicFields);
        $vehicle->save();

        return response()->json([
            'message' => 'Campo dinámico agregado exitosamente.',
            'dynamic_fields' => $dynamicFields
        ], 200);
    }

    public function destroy($landingId)
    {
        try {
            // Buscar el vehículo por el ID de la landing
            $vehicle = Vehicle::where('id_landing', $landingId)->first();

            if (!$vehicle) {
                return response()->json(['message' => 'Vehículo no encontrado'], 404);
            }

            // Obtener todas las imágenes asociadas al vehículo
            $images = VehicleImage::where('vehicle_id', $vehicle->id)->get();

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
        } catch (\Exception $e) {
            // Manejar cualquier excepción que ocurra durante el proceso
            return response()->json(['message' => 'Error al eliminar el vehículo: ' . $e->getMessage()], 500);
        }
    }
}

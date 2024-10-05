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

    public function update(Request $request, $landingId, $vehicleId)
    {
        // Validación de los datos de la solicitud
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'luggage' => 'required|integer',
            'people' => 'required|integer',
            'type_of_car' => 'required|string',
            'transmision' => 'required|string',
            'bluetooth' => 'boolean',
            'siriusxm' => 'boolean',
            'gps' => 'boolean',
            'automatic' => 'boolean',
            'apple_car' => 'boolean',
            'vehicle_images' => 'nullable|array',
            'vehicle_images.*' => 'image|mimes:jpeg,png,jpg|max:2048', // Validación de imágenes
        ]);

        // Buscar el vehículo por su ID
        $vehicle = Vehicle::where('id_landing', $landingId)->findOrFail($vehicleId);

        // Actualizar los datos del vehículo
        $vehicle->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'luggage' => $validatedData['luggage'],
            'people' => $validatedData['people'],
            'type_of_car' => $validatedData['type_of_car'],
            'transmision' => $validatedData['transmision'],
            'bluetooth' => $validatedData['bluetooth'] ?? false,
            'siriusxm' => $validatedData['siriusxm'] ?? false,
            'gps' => $validatedData['gps'] ?? false,
            'automatic' => $validatedData['automatic'] ?? false,
            'apple_car' => $validatedData['apple_car'] ?? false,
        ]);

        // Manejo de las imágenes del vehículo (si se subieron nuevas)
        if ($request->hasFile('vehicle_images')) {
           

            foreach ($request->file('vehicle_images') as $image) {
                $path = $image->store('vehicle_images', 'public');  // Guarda la imagen en el directorio 'storage/app/public/vehicle_images'
                $vehicle->images()->create(['path' => $path]);  // Relacionar la imagen con el vehículo
            }
        }

        // Guardar los cambios en la base de datos
        $vehicle->save();

        // Retornar una respuesta de éxito o redirigir a una página
        return response()->json(['message' => 'Vehículo actualizado exitosamente', 'vehicle' => $vehicle ]); 
    }

    public function storeSpecialFeature(Request $request, $vehicleId)
    {
        // Validar los datos entrantes
        $validatedData = $request->validate([
            'features' => 'required|array', // Asegúrate de que 'features' sea un array
        ]);

        // Buscar el vehículo
        $vehicle = Vehicle::findOrFail($vehicleId);

        // Crear el registro de características especiales
        $specialFeature = $vehicle->specialFeatures()->create([
            'features' => $validatedData['features']
        ]);

        // Devolver la respuesta en formato JSON
        return response()->json([
            'message' => 'Característica especial creada con éxito.',
            'specialFeature' => $specialFeature
        ], 201);
    }

    public function getSpecialFeatures($vehicleId)
    {
        // Buscar el vehículo
        $vehicle = Vehicle::findOrFail($vehicleId);

        // Obtener las características especiales del vehículo
        $specialFeatures = $vehicle->specialFeatures;

        // Devolver las características en formato JSON
        return response()->json([
            'message' => 'Características especiales encontradas.',
            'specialFeatures' => $specialFeatures
        ]);
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
    public function show($landingId, $vehicleId)
    {
        // Validar manualmente la existencia de los IDs en la base de datos
        $vehicle = Vehicle::where('id', $vehicleId)
            ->where('id_landing', $landingId)
            ->with(['images']) // Relación con imágenes u otras relaciones si es necesario
            ->first();

        if (!$vehicle) {
            return response()->json([
                'message' => 'Vehículo no encontrado',
                'status' => 'error'
            ], 404);
        }

        return response()->json([
            'message' => 'Vehículo encontrado',
            'vehicle' => $vehicle,
            'status' => 'success'
        ], 200);
    }





    public function destroy($landingId, $vehicleId)
    {
        try {
            // Buscar el vehículo por el ID del vehículo
            $vehicle = Vehicle::where('id', $vehicleId)->where('id_landing', $landingId)->first();

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

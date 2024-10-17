<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Landing;
use App\Models\Reservation;
use App\Models\Vehicle;

class PublicLandingController extends Controller
{
    /**
     * Método para obtener una landing específica de un usuario, junto con los vehículos relacionados.
     *
     * @param int $IdUser - ID del usuario.
     * @param int $IdLanding - ID de la landing.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($name)
    {
        try {
            // Consultar la landing que corresponde al nombre, no ha sido eliminada (soft delete), y está publicada
            // Incluyendo los vehículos relacionados y sus imágenes
            $landing = Landing::with(['vehicles.images', 'locations']) // Cargar los vehículos y sus imágenes
                ->where('name', $name)      // Filtro por nombre de landing
                ->whereNull('deleted_at')   // Verificar que no esté eliminada suavemente
                ->where('published', true)  // Verificar que esté publicada
                ->first();                  // Obtener el primer resultado

            // Si no se encuentra la landing, retornar una respuesta de error
            if (!$landing) {
                return response()->json([
                    'message' => 'Landing no encontrada, ha sido eliminada o no está publicada.'
                ], 404);
            }

            // Devolver los datos de la landing, los vehículos y las imágenes relacionadas
            return response()->json([
                'message' => 'Landing encontrada.',
                'landing' => $landing,              // Información de la landing
                'vehicles' => $landing->vehicles,   // Vehículos relacionados con la landing y sus imágenes
                'locations' => $landing->locations,
            ], 200);
        } catch (\Throwable $e) {
            // Manejar cualquier error que ocurra durante la consulta
            return response()->json([
                'error' => 'Error al buscar la landing: ' . $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Método para obtener una landing por su nombre, sin importar si está publicada o eliminada.
     *
     * @param string $name - Nombre de la landing.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLandingWithoutFilters($name)
    {
        try {
            // Obtener la landing por su nombre, sin verificar si está eliminada o publicada
            $landing = Landing::with(['vehicles.images', 'locations'])
                ->where('name', $name)
                ->first(); // Obtener el primer resultado sin filtros adicionales

            // Si no se encuentra la landing
            if (!$landing) {
                return response()->json([
                    'message' => 'Landing no encontrada.'
                ], 404);
            }

            // Devolver los datos de la landing, los vehículos y las imágenes relacionadas
            return response()->json([
                'message' => 'Landing encontrada.',
                'landing' => $landing,
                'vehicles' => $landing->vehicles,
                'locations' => $landing->locations,
            ], 200);
        } catch (\Throwable $e) {
            // Manejar cualquier error que ocurra durante la consulta
            return response()->json([
                'error' => 'Error al buscar la landing: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function showVehicle($name, $id)
    {
        try {
            // Obtener el vehículo específico junto con la landing y sus imágenes
            $vehicle = Vehicle::with('images') // Cargar imágenes del vehículo
                ->whereHas('landing', function ($query) use ($name) {
                    $query->where('name', $name)
                        ->whereNull('deleted_at')
                        ->where('published', true);
                })
                ->where('id', $id)
                ->first();

            // Si no se encuentra el vehículo
            if (!$vehicle) {
                return response()->json(['error' => 'Vehículo no encontrado en esta landing.'], 404);
            }

            // Retornar la información del vehículo
            return response()->json([
                'vehicle' => $vehicle,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Error al buscar el vehículo: ' . $e->getMessage()], 500);
        }
    }
}

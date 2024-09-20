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
    public function index($iduser , $name)
    {
        try {
            // Consultar la landing que pertenece al usuario, no ha sido eliminada (soft delete), y está publicada
            // Incluyendo los vehículos relacionados
            $landing = Landing::with(['vehicles' , 'locations']) // Cargar los vehículos relacionados
                ->where('id_users_landing', $iduser)    // Filtro por usuario
                ->where('name',$name)      // Filtro por nombre de landing
                ->whereNull('deleted_at')      // Verificar que no esté eliminada suavemente
                ->where('published', true)     // Verificar que esté publicada

                ->first();                     // Obtener el primer resultado

            // Si no se encuentra la landing, retornar una respuesta de error
            if (!$landing) {
                return response()->json([
                    'message' => 'Landing no encontrada, ha sido eliminada o no está publicada.'
                ], 404);
            }

            // Devolver los datos de la landing y los vehículos relacionados
            return response()->json([
                'message' => 'Landing encontrada.',
                'landing' => $landing,             // Información de la landing
                'vehicles' => $landing->vehicles,   // Vehículos relacionados con la landing
                'locations'=> $landing->locations,
            ], 200);
        } catch (\Throwable $e) {
            // Manejar cualquier error que ocurra durante la consulta
            return response()->json([
                'error' => 'Error al buscar la landing: ' . $e->getMessage(),
            ], 500);
        }
    }
}

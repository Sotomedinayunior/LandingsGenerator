<?php

namespace App\Http\Controllers;

use App\Models\Landing;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingController extends Controller
{
    // Mostrar una lista de todos los landings con sus relaciones
    public function index($userId)
    {
        try {
            // Obtén todas las landings asociadas a ese usuario, excluyendo las eliminadas soft delete
            $landings = Landing::with(['vehicles', 'reservations'])
                ->where('id_users_landing', $userId)
                ->whereNull('deleted_at') // Excluye landings eliminadas
                ->get();

            if ($landings->isEmpty()) {
                return response()->json(['message' => 'No landings found'], 404);
            }

            // Devuelve la respuesta en formato JSON
            return response()->json($landings);
        } catch (\Exception $e) {
            // Devuelve un error 500 en caso de cualquier excepción
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    // Mostrar una landing especifica por su id
    public function onelanding($userId, $landingId)
    {
        try {
            // Obtén la landing específica por su ID y que pertenezca al usuario, incluyendo vehículos y reservas
            $landing = Landing::with(['vehicles', 'reservations'])
                ->where('id', $landingId)
                ->where('id_users_landing', $userId)
                ->first();

            if (!$landing) {
                return response()->json(['message' => 'Landing not found or unauthorized'], 404);
            }

            // Devuelve la respuesta en formato JSON
            return response()->json($landing);
        } catch (\Exception $e) {
            // Devuelve un error 500 en caso de cualquier excepción
            return response()->json(['error' => 'Server Error'], 500);
        }
    }


    // Guardar un nuevo landing en la base de datos
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_users_landing' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'color_primary' => ['nullable', 'string', 'max:7', 'regex:/^#([0-9a-fA-F]{3}){1,2}$/'],
            'color_secondary' => ['nullable', 'string', 'max:7', 'regex:/^#([0-9a-fA-F]{3}){1,2}$/'],
            'published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('logos'), $logoName);
            $logoUrl = asset('logos/' . $logoName);
        } else {
            $logoUrl = null;
        }

        $landing = new Landing();
        $landing->id_users_landing = $validatedData['id_users_landing'];
        $landing->name = $validatedData['name'];
        $landing->logo = $logoUrl;
        $landing->color_primary = $validatedData['color_primary'];
        $landing->color_secondary = $validatedData['color_secondary'];
        $landing->published = $validatedData['published'] ?? false;
        $landing->save();

        return response()->json([
            'message' => 'Landing page created successfully',
            'id' => $landing->id,
            'landing' => $landing,
        ]);
    }


    // Actualizar un landing existente en la base de datos

    public function update(Request $request, $id)
    {
        // Validar los datos entrantes
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'color_primary' => 'nullable|string|max:7',
            'color_secondary' => 'nullable|string|max:7',
            'color_tertiary' => 'nullable|string|max:7',
            'published' => 'boolean',
        ]);

        // Buscar la landing que se va a actualizar
        $landing = Landing::findOrFail($id);

        try {
            // Si se sube un nuevo logo, guardar la imagen y actualizar la URL en la base de datos
            if ($request->hasFile('logo')) {
                // Eliminar el logo antiguo si existe
                if ($landing->logo && Storage::disk('public')->exists($landing->logo)) {
                    // Si la eliminación falla, puedes lanzar una excepción personalizada si es necesario
                    if (!Storage::disk('public')->delete($landing->logo)) {
                        throw new \Exception('No se pudo eliminar el logo anterior');
                    }
                }

                // Guardar el nuevo logo
                $logoPath = $request->file('logo')->store('logos', 'public');
                $validatedData['logo'] = $logoPath;
            }

            // Actualizar los datos de la landing
            $landing->update($validatedData);

            return response()->json([
                'message' => 'Landing actualizada con éxito',
                'landing' => $landing,
            ], 200);
        } catch (\Throwable $e) { // Catch Throwable to catch both Errors and Exceptions
            // Manejo de errores y respuestas HTTP
            return response()->json([
                'message' => 'Error al actualizar la landing',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function status(Request $request)
    {
        try {
            // Obtén los datos del request
            $landingId = $request->input('landing_id');
            $userId = $request->input('user_id');

            // Busca la landing por su ID y verifica que pertenece al usuario
            $landing = Landing::where('id', $landingId)
                ->where('id_users_landing', $userId)
                ->first();

            // Verifica si la landing existe y pertenece al usuario
            if (!$landing) {
                return response()->json(['message' => 'Landing not found or unauthorized'], 404);
            }

            // Cambia el estado de publicación
            $landing->published = !$landing->published; // Alterna entre publicado y no publicado
            $landing->save();

            return response()->json([
                'message' => 'Landing status updated successfully',
                'landing' => $landing,
            ], 200);
        } catch (\Throwable $e) {
            // Manejo de errores y respuestas HTTP
            return response()->json([
                'message' => 'Error updating landing status',
                'error' => $e->getMessage(),
            ], 500);
        }
    }




    //Landing que se eliminaron suavemente
    public function restore($id)
    {
        try {
            // Encuentra la landing eliminada utilizando onlyTrashed()
            $landing = Landing::onlyTrashed()->find($id);

            if (!$landing) {
                return response()->json(['message' => 'Landing no encontrada o ya restaurada'], 404);
            }

            // Restaura la landing
            $landing->restore();

            return response()->json(['message' => 'Landing restaurada con éxito']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al restaurar la landing'], 500);
        }
    }
    public function getDeletedLandings($userId)
    {
        try {
            // Obtener todas las landings eliminadas asociadas a ese usuario, incluyendo vehículos y reservas
            $deletedLandings = Landing::onlyTrashed()
                ->with(['vehicles', 'reservations']) // Relaciones
                ->where('id_users_landing', $userId) // Filtrar por usuario
                ->get();

            if ($deletedLandings->isEmpty()) {
                return response()->json(['message' => 'No se ha borrado ninguna landing'], 404);
            }

            // Devolver la respuesta en formato JSON
            return response()->json($deletedLandings);
        } catch (\Exception $e) {
            // Manejar cualquier excepción y devolver un error 500
            return response()->json(['error' => 'Error en el servidor'], 500);
        }
    }








    // Eliminar un landing y sus vehículos relacionados
    public function destroy($id)
    {
        // Busca la landing por su ID
        $landing = Landing::find($id);

        // Verifica si la landing existe
        if (!$landing) {
            return response()->json(['message' => 'Landing not found'], 404);
        }

        // Elimina (suavemente) la landing
        $landing->delete();

        return response()->json(['message' => 'Landing deleted successfully']);
    }
}

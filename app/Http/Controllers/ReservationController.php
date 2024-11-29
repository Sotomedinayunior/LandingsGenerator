<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Vehicle;
use App\Models\Landing;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index($landing_id)
    {
        // Obtener todas las reservaciones que pertenezcan a la landing específica
        $reservations = Reservation::with(['landing', 'vehicle'])
            ->where('id_landing', $landing_id)
            ->get();

        return response()->json($reservations, 200);
    }

    // Mostrar los detalles de una reservación específica
    public function show($id)
    {
        $reservation = Reservation::with(['landing', 'vehicle'])->findOrFail($id);
        return response()->json($reservation, 200);
    }
    public function indexUser($user_id)
    {

        // Obtener todas las landings asociadas al usuario
        $landings = Landing::where('id_users_landing', $user_id)
            ->with('reservations.vehicle') // Cargar las reservaciones y los vehículos relacionados
            ->get();

        return response()->json($landings, 200);
    }

    // Guardar una nueva reservación en la base de datos
    public function store(Request $request, $id = null)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255', // Opcional
            'last_name' => 'nullable|string|max:255', // Opcional
            'phone' => 'nullable|string|max:255', // Opcional
            'email' => 'nullable|string|email|max:255|unique:reservations,email,' . $id, // Opcional
            'description' => 'nullable|string', // Opcional
            'name_landing' => 'required|string|max:255', // Obligatorio
            'id_vehicle' => 'required|exists:vehicles,id', // Obligatorio
            'url_landing' => 'required|string|max:500', // Obligatorio
            'place_of_departure' => 'nullable|string|max:255', // Opcional
            'arrival_place' => 'nullable|string|max:255', // Opcional
            'url_vehicle' => 'nullable|string|max:500', // Opcional, si no siempre es obligatorio
            'date_of_departure' => 'nullable|date|before_or_equal:date_of_arrival', // Validar coherencia de fechas
            'time_of_departure' => 'nullable|date_format:H:i', // Opcional
            'date_of_arrival' => 'nullable|date|after_or_equal:date_of_departure', // Validar coherencia de fechas
            'time_of_arrival' => 'nullable|date_format:H:i', // Opcional
            'number_person' => 'required|integer|min:1', // Número de personas, asegurarse que sea un entero
            'number_bag' => 'required|integer|min:0', // Número de maletas
            'id_landing' => 'required|exists:landings,id', // Obligatorio
        ]);

        // Generar un ID único basado en el correo electrónico
        $uniqueId = md5($validatedData['email']); // Usamos el email como base

        // Generar la URL del avatar con la API de MultiAvatar
        $avatarUrl = "https://api.multiavatar.com/{$uniqueId}.png";

        // Aquí puedes proceder a crear la reservación
        // Encontrar el Vehicle y Landing asociados
        $vehicle = Vehicle::findOrFail($validatedData['id_vehicle']);
        $landing = Landing::findOrFail($validatedData['id_landing']);

        // Crear la reservación y asociarla con el Vehicle y Landing
        $reservation = new Reservation($validatedData);
        $reservation->vehicle()->associate($vehicle);
        $reservation->landing()->associate($landing);

        // Asignar la URL del avatar a la reservación
        $reservation->avatar_url = $avatarUrl;

        // Guardar la reserva en la base de datos
        $reservation->save();

        return response()->json(['message' => 'Reservación creada exitosamente', 'reservation' => $reservation], 201);
    }




    // Actualizar una reservación existente en la base de datos
    public function update(Request $request, $id)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'phone' => 'string|max:255',
            'email' => 'string|email|max:255|unique:reservations,email,' . $id,
            'description' => 'nullable|string',
            'id_vehicle' => 'exists:vehicles,id',
            'place_of_departure' => 'string|max:255',
            'arrival_place' => 'string|max:255',
            'number_of_persons' => 'integer',
            'date_of_departure' => 'date',
            'time_of_departure' => 'date_format',
            'date_of_arrival' => 'date',
            'time_of_arrival' => 'date_format',

            'id_landing' => 'exists:landings,id',
        ]);

        // Obtener la reservación
        $reservation = Reservation::findOrFail($id);

        // Actualizar las relaciones si se proporcionan nuevos IDs
        if (isset($validatedData['id_vehicle'])) {
            $vehicle = Vehicle::findOrFail($validatedData['id_vehicle']);
            $reservation->vehicle()->associate($vehicle);
        }

        if (isset($validatedData['id_landing'])) {
            $landing = Landing::findOrFail($validatedData['id_landing']);
            $reservation->landing()->associate($landing);
        }

        // Actualizar los datos de la reservación
        $reservation->update($validatedData);

        return response()->json(['message' => 'Reservación actualizada exitosamente', 'reservation' => $reservation], 200);
    }

    // Eliminar una reservación de la base de datos
    public function destroy($id)
    {
        try {
            // Obtener la reservación
            $reservation = Reservation::findOrFail($id);

            // Eliminar la reservación
            $reservation->delete();

            // Responder si la eliminación fue exitosa
            return response()->json(['message' => 'Reservación eliminada exitosamente'], 200);
        } catch (\Exception $e) {
            // Si algo falla, responder con un error
            return response()->json(['message' => 'Error al eliminar la reservación', 'error' => $e->getMessage()], 500);
        }
    }
}

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
        // Validar los datos recibidos, haciendo que algunos campos sean opcionales
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255', // Opcional
            'last_name' => 'nullable|string|max:255', // Opcional
            'phone' => 'nullable|string|max:255', // Opcional
            'email' => 'nullable|string|email|max:255|unique:reservations,email,' . $id, // Opcional
            'description' => 'nullable|string', // Opcional
            'id_vehicle' => 'required|exists:vehicles,id', // Obligatorio
            'place_of_departure' => 'nullable|string|max:255', // Opcional
            'arrival_place' => 'nullable|string|max:255', // Opcional
            'number_of_persons' => 'nullable|integer', // Opcional
            'date_of_departure' => 'nullable|date', // Opcional
            'time_of_departure' => 'nullable|date_format:H:i', // Opcional, especificando el formato
            'date_of_arrival' => 'nullable|date', // Opcional
            'time_of_arrival' => 'nullable|date_format:H:i', // Opcional, especificando el formato
            'id_landing' => 'required|exists:landings,id', // Obligatorio
        ]);

        // Aquí puedes proceder a crear la reservación
        // Encontrar el Vehicle y Landing asociados
        $vehicle = Vehicle::findOrFail($validatedData['id_vehicle']);
        $landing = Landing::findOrFail($validatedData['id_landing']);

        // Crear la reservación y asociarla con el Vehicle y Landing
        $reservation = new Reservation($validatedData);
        $reservation->vehicle()->associate($vehicle);
        $reservation->landing()->associate($landing);
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
        // Obtener la reservación
        $reservation = Reservation::findOrFail($id);

        // Eliminar la reservación
        $reservation->delete();

        return response()->json(['message' => 'Reservación eliminada exitosamente'], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Vehicle;
use App\Models\Landing;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    // Mostrar una lista de todas las reservaciones
    public function index()
    {
        // Obtener todas las reservaciones con las relaciones correspondientes
        $reservations = Reservation::with(['landing', 'vehicle'])->get();
        return response()->json($reservations, 200);
    }

    // Mostrar los detalles de una reservación específica
    public function show($id)
    {
        $reservation = Reservation::with(['landing', 'vehicle'])->findOrFail($id);
        return response()->json($reservation, 200);
    }

    // Guardar una nueva reservación en la base de datos
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:reservations,email',
            'description' => 'nullable|string',
            'id_vehicle' => 'required|exists:vehicles,id',
            'place_of_departure' => 'required|string|max:255',
            'arrival_place' => 'required|string|max:255',
            'number_of_persons' => 'required|integer',
            'date_of_departure' => 'required|date',
            'time_of_departure' => 'required|date_format:H:i',
            'date_of_arrival' => 'required|date',
            'time_of_arrival' => 'required|date_format:H:i',
            'id_landing' => 'required|exists:landings,id',
        ]);

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
            'email' => 'string|email|max:255|unique:reservations,email,' . $id,
            'description' => 'nullable|string',
            'id_vehicle' => 'exists:vehicles,id',
            'place_of_departure' => 'string|max:255',
            'arrival_place' => 'string|max:255',
            'number_of_persons' => 'integer',
            'date_of_departure' => 'date',
            'time_of_departure' => 'date_format:H:i',
            'date_of_arrival' => 'date',
            'time_of_arrival' => 'date_format:H:i',
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

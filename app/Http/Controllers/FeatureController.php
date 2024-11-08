<?php



namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\VehicleFeature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        return Feature::all(); // Retorna todas las características
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $feature = Feature::create($request->all()); // Crea una nueva característica

        return response()->json($feature, 201);
    }

    public function show($id)
    {
        return Feature::findOrFail($id); // Retorna una característica específica
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);
        $feature->update($request->all()); // Actualiza la característica

        return response()->json($feature);
    }
    // Método para actualizar características de un vehículo específico
    public function updateVehicleFeatures(Request $request, $vehicleId)
    {
        // Validar que `features` es un array de características con `feature_id` y `value`
        $request->validate([
            'features' => 'required|array',
            'features.*.feature_id' => 'required|integer|exists:features,id',
            'features.*.value' => 'required|boolean',
        ]);

        // Iterar sobre cada característica y actualizarla o crearla
        foreach ($request->features as $feature) {
            VehicleFeature::updateOrCreate(
                [
                    'vehicle_id' => $vehicleId,
                    'feature_id' => $feature['feature_id'],
                ],
                ['value' => $feature['value']]
            );
        }

        return response()->json(['message' => 'Características del vehículo actualizadas exitosamente.']);
    }

    public function destroy($id)
    {
        Feature::destroy($id); // Elimina la característica

        return response()->noContent();
    }
}

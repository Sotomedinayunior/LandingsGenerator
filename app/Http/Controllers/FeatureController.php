<?php



namespace App\Http\Controllers;

use App\Models\Feature;
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

    public function destroy($id)
    {
        Feature::destroy($id); // Elimina la característica

        return response()->noContent();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialFeature extends Model
{
    protected $fillable = ['vehicle_id', 'features'];

    // Relación inversa con Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Si los features son un campo JSON, puedes usarlos así
    protected $casts = [
        'features' => 'array', // Convierte automáticamente el campo JSON en un array
    ];
}


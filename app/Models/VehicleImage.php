<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_vehicle',   // Ajustado para coincidir con el nombre del campo en el esquema
        'path_images',
    ];

    // Define la relación con el modelo Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'id_vehicle'); // Ajustado para coincidir con el nombre del campo en el esquema
    }
}


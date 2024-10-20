<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleFeature extends Model
{
    protected $fillable = ['vehicle_id', 'feature_id', 'value'];

    // Relación con el vehículo
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Relación con el feature
    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}

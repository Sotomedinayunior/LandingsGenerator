<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['name', 'description'];

    // Relación con los vehículos a través de la tabla intermedia vehicle_features
    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'vehicle_features')
                    ->withPivot('value') // Incluimos el valor del feature por vehículo
                    ->withTimestamps();
    }

    // Relación con las características sobrescritas (special_features)
    public function specialFeatures()
    {
        return $this->hasMany(SpecialFeature::class);
    }
}


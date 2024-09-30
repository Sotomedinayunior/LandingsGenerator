<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'id_landing',
        'price',
        'luggage',
        'people',
        'type_of_car',   
        'transmision',      
        'bluetooth',
        'siriusxm',
        'gps',
        'apple_car',
        'id_image',
        'dynamic_fields'
    ];
    
    protected $casts = [
        'dynamic_fields' => 'array', // Convierte el campo JSON a un array
    ];
    // Definir la relación uno a muchos con SpecialFeature
    public function specialFeatures()
    {
        return $this->hasMany(SpecialFeature::class);
    }

    // Definir la relación inversa uno a muchos con Landing
    public function landing()
    {
        return $this->belongsTo(Landing::class, 'id_landing');
    }

    // Definir la relación uno a muchos con Reservation
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_vehicle');
    }
    public function images()
    {
        return $this->hasMany(VehicleImage::class, 'vehicle_id');
    }
}


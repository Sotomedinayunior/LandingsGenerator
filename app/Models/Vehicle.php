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
        'sedan',       
        'bluetooth',
        'siriusxm',
        'manual',
        'automatic',
        'cvt',
        'id_image',
        'dynamic_fields'
    ];
    
    protected $casts = [
        'dynamic_fields' => 'array', // Convierte el campo JSON a un array
    ];

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
}

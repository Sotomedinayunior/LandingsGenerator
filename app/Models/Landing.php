<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Landing extends Model
{
    use HasFactory, SoftDeletes;

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'id_users_landing',
        'name',
        'logo',
        'color_primary',
        'color_secondary',
        'color_tertiary',
        'published',
    ];

    // Definir la relación inversa uno a uno con User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_users_landing');
    }

    // Definir la relación uno a muchos con Vehicle
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'id_landing');
    }

    // Definir la relación uno a muchos con Reservation
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_landing');
    }
}


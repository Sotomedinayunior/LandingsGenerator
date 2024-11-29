<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected $fillable=[
        'avatar_url',
        'name',
        'last_name',
        'email',
        'description',
        'phone',
        'id_vehicle',
        'place_of_departure',
        'arrival_place',
        'number_of_persons',
        'date_of_departure',
        'time_of_departure',
        'date_of_arrival',
        'name_landing',
        'url_landing',
        'time_of_arrival',
        'id_landing',
        'url_vehicle',   
        'number_person',
        'number_bag' ,
    ];
    

    // Definir la relación inversa uno a muchos con Vehicle
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'id_vehicle');
    }

    // Definir la relación inversa uno a muchos con Landing
    public function landing()
    {
        return $this->belongsTo(Landing::class, 'id_landing');
    }
}

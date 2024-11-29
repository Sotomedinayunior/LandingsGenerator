<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Location extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=[
        'id_landing',
        'place_of_departure',
        'arrival_place',
        'number_of_persons',
        'date_of_departure',
        'time_of_departure',
        'date_of_arrival',
        'time_of_arrival'
    ];

    public function landing()
    {
        return $this->belongsTo(Landing::class , 'id_landing');
    }
}

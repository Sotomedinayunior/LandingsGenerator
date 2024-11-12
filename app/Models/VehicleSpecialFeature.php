<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleSpecialFeature extends Model
{
    protected $fillable = ['vehicle_id', 'special_feature_id', 'name'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function specialFeature()
    {
        return $this->belongsTo(SpecialFeature::class);
    }
}


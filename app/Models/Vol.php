<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vol extends Model
{
      use HasFactory;
    protected static function newFactory()
        {
            return \Database\Factories\VolFactory::new();
        }
     protected $fillable = [
        'depart', 
        'destination', 
        'date_depart', 
        'prix', 
        'heure_depart',
        'places_disponibles'
    ];

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }
}
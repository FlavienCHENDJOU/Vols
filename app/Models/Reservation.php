<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    protected static function newFactory()
    {
        return \Database\Factories\ReservationFactory::new();
    }
   
    protected $fillable = [
        'user_id',
        'nom', 
        'prenom', 
        'email', 
        'telephone',
        'vol_id', 
        'classe', 
        'nombre_places',
        'motif',
        'paiement'

        
    ];

    
    public function user() { return $this->belongsTo(User::class, 'user_id'); }
    public function vol()  { return $this->belongsTo(Vol::class, 'vol_id');}

}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; // Assurez-vous d'avoir un modèle Reservation
use App\Models\Vol; // Le modèle Flight pour associer une réservation à un vol
use DB;

class ReservationController extends Controller
{
    // Méthode pour afficher la page d'accueil
    public function accueil()
    {
        return view('accueil'); 
    }

    // Méthode pour afficher les vols dispognible
    public function vols_disponible()
    {
        $vols = Vol::all();
        return view('vols_disponible', compact('vols'));
    }


    // Méthode pour afficher le formulaire de réservation
    public function reserver($vol_id)
    { 
        $vol = Vol::findOrFail($vol_id);
        return view('reserver', compact('vol'));
    }
    

    // Méthode pour traiter la réservation
    public function formReserver(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|numeric', 
            'vol_id' => 'required|exists:vols,id', 
            'classe' => 'required|string',
            'nombre_places' => 'required|integer|min:1 max:20',
            'paiement' => 'required|string',
            'motif' => 'nullable|string|max:1000',
        ]);

        // Créer une réservation avec les données soumises
        $reservation = new Reservation();
        $reservation->nom = $validated['nom'];
        $reservation->prenom = $validated['prenom'];
        $reservation->email = $validated['email'];
        $reservation->telephone = $validated['telephone'];
        $reservation->vol_id = $validated['vol_id'];
        $reservation->classe =$validated['classe'];
        $reservation->nombre_places =$validated['nombre_places'];
        $reservation->paiement =$validated['paiement'];
        $reservation->save();  
        return redirect()->route('confirmation',['reservation_id' => $reservation->id])->with('success', 'Réservation effectuée avec succès !');
    }

    public function confirmation($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        $vol = Vol::findOrFail($reservation->vol_id);
        return view('confirmation', compact('reservation', 'vol'));
    }

    // Méthode pour afficher la page de reservation sauvegarder
    public function test_reservations()
    {
        $reservations = Reservation::all(); 
        return view('test_reservations', compact('reservations')); 
    }

   
}
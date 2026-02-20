<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; 
use App\Models\Vol; 
use DB;

class ReservationController extends Controller
{
    
    public function accueil()
    {
        return view('accueil'); 
    }

    public function vols_disponible()
    {
        $vols = Vol::all();
        $user = auth()->user();
       if ($user && ($user->hasRole('super_admin') || $user->hasRole('admin_vols') || $user->hasRole('admin_users'))) {
            $layout = 'layouts.admin';  } else {
            $layout = 'layouts.app';
        }
        return view('vols_disponible', compact('vols','layout'));
    }


     public function reserver($vol_id)
    { 
        $vol = Vol::findOrFail($vol_id);
         $layout = auth()->user()->hasAnyRole(['admin_vols', 'admin_users', 'super_admin']) 
              ? 'layouts/admin' 
              : 'layouts/app';
        return view('reserver', compact('vol', 'layout'));
    }

    
    public function formReserver(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|numeric', 
            'vol_id' => 'required|exists:vols,id', 
            'classe' => 'required|string',
            'nombre_places' => 'required|integer|min:1|max:20',
            'paiement' => 'required|string',
            'motif' => 'nullable|string|max:1000',
        ]);

        $reservation = new Reservation();
        $reservation->nom = $validated['nom'];
        $reservation->prenom = $validated['prenom'];
        $reservation->email = $validated['email'];
        $reservation->telephone = $validated['telephone'];
        $reservation->vol_id = $validated['vol_id'];
        $reservation->classe =$validated['classe'];
        $reservation->nombre_places =$validated['nombre_places'];
        $reservation->paiement =$validated['paiement'];

        $reservation->save();  return redirect('/confirmation/' . $reservation->id)->with('success', 'Réservation effectuée avec succès !'); }

    public function confirmation($reservation_id)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        $vol = Vol::findOrFail($reservation->vol_id);
        return view('confirmation', compact('reservation', 'vol'));
    }

    public function supprimerReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $vol = Vol::find($reservation->vol_id);
        if($vol) {
            $vol->places_disponibles += $reservation->nombre_places;
            $vol->save();
        }

        $reservation->delete();

        return redirect('/test_reservations')->with('info', 'Réservation annulée avec succès.');
    }
   
    public function mesReservations()
    {
        $userEmail = auth()->user()->email;
        $reservations = \App\Models\Reservation::where('email', $userEmail)
                                ->orderBy('created_at', 'desc')
                                ->get();
        $nombreDeReservations = $reservations->count();
        $layout = auth()->user()->hasAnyRole(['admin_vols', 'admin_users', 'super_admin']) 
              ? 'layouts/admin' 
              : 'layouts/app';

        return view('mes_reservations', [compact('reservations'),'reservations' => $reservations, 'nbRes' => $nombreDeReservations,'layout' => $layout] );
    }

  

}







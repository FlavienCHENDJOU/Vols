<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation; 
use App\Models\Vol; 
use Barryvdh\DomPDF\Facade\Pdf; 
use DB;

class ReservationController extends Controller
{
    
    public function accueil()
    {
        return view('accueil'); 
    }

    public function vols_disponible(Request $request)
    {
        $vols = Vol::all();
        $user = auth()->user();
       if ($user && ($user->hasRole('super_admin') || $user->hasRole('admin_vols') || $user->hasRole('admin_users'))) {
            $layout = 'layouts.admin';  } else {
            $layout = 'layouts.app';
        }
        $query = Vol::query();

        // Filtres
        if ($request->filled('depart')) {
            $query->whereRaw('LOWER(depart) LIKE ?', ['%' . strtolower($request->depart) . '%']);
        }
        if ($request->filled('destination')) {
            $query->whereRaw('LOWER(destination) LIKE ?', ['%' . strtolower($request->destination) . '%']);
        }
        if ($request->filled('date')) {
            $query->whereDate('date_depart', $request->date);
        }
        if ($request->filled('classe')) {
            $query->where('classe', $request->classe);
        }

        $vols = $query->orderBy('date_depart')->paginate(50);
        if ($request->ajax()) {
            return response()->json([
                'vols'          => $vols->items(),
                'next_page_url' => $vols->nextPageUrl(),
            ]);
        }
        return view('vols_disponible', compact('vols', 'layout'));
    }




     public function reserver($vol_id)
    { 
        $vol = Vol::findOrFail($vol_id);
         $layout = !auth()->user()->hasAnyRole([ 'NULL']) 
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
            'nombre_places' => 'required|integer|min:1|max:200',
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

        $reservation->save();  return redirect('/confirmation/' . $reservation->id)->with('success', 'Réservation effectuée avec succès !'); 
        
    }

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

        return back()->with('success', 'Réservation annulée. Les places ont été remises en vente.');
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

  

    public function store(Request $request)
    {
        $vol = Vol::findOrFail($request->vol_id);
        if ($request->nombre_places > $vol->places_disponibles) {
            return back()->with('error', "Désolé, il ne reste que {$vol->places_disponibles} places sur ce vol.");
        }
        Reservation::create([
            'vol_id' => $vol->id,
            'nombre_places' => $request->nombre_places,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,  
            'classe' => $request->classe,
            'paiement' => $request->paiement,
            
        ]);
        $vol->places_disponibles -= $request->nombre_places;
        $vol->save();

        return redirect()->route('vols.disponibles')->with('success', 'Réservation réussie !');
    }


    public function exportCSV()
    {
        $reservations = Reservation::with('vol')->get();
        $fileName = 'reservations_vols_' . date('d-m-Y') . '.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        $callback = function() use($reservations) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['ID', 'Nom', 'Prénom', 'Email', 'Téléphone', 'Vol', 'Classe', 'Places', 'Paiement', 'Date']);
            foreach ($reservations as $res) {
                fputcsv($file, [
                    $res->id,
                    $res->nom,
                    $res->prenom,
                    $res->email,
                    $res->telephone,
                    $res->vol->depart . ' -> ' . $res->vol->destination,
                    $res->classe,
                    $res->nombre_places,
                    $res->paiement,
                    $res->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPDF()
    {
        $reservations = Reservation::with('vol')->orderBy('created_at', 'desc')->get();
        $pdf = Pdf::loadView('export_pdf', compact('reservations'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('Rapport_Reservations_' . date('d-m-Y') . '.pdf');
    }

}







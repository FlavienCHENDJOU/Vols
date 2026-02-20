<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vol;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index() {
        $admin = Auth::user();
        $nbRes = Reservation::count(); 
        $nbVols = Vol::count();   
        $users = User::paginate(10);
        $allRoles = Role::all();    
        $nbUsers = $admin->can('voir-utilisateurs') ? User::count() : 0;
        return view('admin', compact('admin', 'nbRes', 'nbVols', 'nbUsers','users', 'allRoles'));
   }

    public function creerVol(Request $request) {
        if (!auth()->user()->can('creer-vols')) {
            return back()->with('error', "Vous n'avez pas le privilège de créer un vol.");
        }
        $dernierVol = Vol::max('id'); 
        $prochainNumero = $dernierVol ? $dernierVol + 1 : 1; 
        $request->validate([
            'ville_depart' => 'required',
            'ville_arrivee' => 'required',
            'date_depart' => 'required',
            'prix' => 'required|numeric',
            'places_disponibles' => 'required|integer'
        ]);
        $dateComplete = $request->date_depart;
        $dateSeule = date('Y-m-d', strtotime($dateComplete));
        $heureSeule = date('H:i:s', strtotime($dateComplete));
        Vol::create([
            'depart'       => $request->ville_depart,
            'destination'      => $request->ville_arrivee,
            'date_depart'        => $dateSeule,  
            'heure_depart'       => $heureSeule,
            'prix'               => $request->prix,
            'places_disponibles' => $request->places_disponibles,
        ]);

        return back()->with('success', 'Vol n°' . $prochainNumero . ' créé avec succès !');
    }

    public function listeVols() 
    {   
        if (!auth()->user()->can('voir-vols')) {
            return back()->with('error', "Vous n'avez pas le privilège de créer un vol.");
        }
        $vols = Vol::orderBy('id', 'asc') ->paginate(20);
         return view('adminvols', compact('vols'));
    }

    public function updateVol(Request $request, $id) {
        if (!auth()->user()->can('modifier-vols')) {
            return back()->with('error', "Action interdite.");
        }
        $vol = Vol::findOrFail($id);
        $request->validate([
            'depart' => 'required',
            'destination' => 'required',
            'date_depart' => 'required',
            'prix' => 'required|numeric',
            'places_disponibles' => 'required|integer'
        ]);
  
        $heure = date('H:i:s', strtotime($request->date_depart));
        $dateSeule = date('Y-m-d', strtotime($request->date_depart));

        $vol->update([
            'depart' => $request->depart,
            'destination' => $request->destination,
            'date_depart' => $dateSeule,
            'heure_depart' => $heure,
            'prix' => $request->prix,
            'places_disponibles' => $request->places_disponibles,
        ]);

        return back()->with('success', 'Le vol a été mis à jour avec succès !');
    }

    public function destroyVol($id) {
        if (!auth()->user()->can('supprimer-vols')) {
            return back()->with('error', "Suppression interdite.");
        }
        Vol::findOrFail($id)->delete();
        return back()->with('success', 'Le vol a été supprimé.');
    }
        

    public function listeReservations() {
        if (!auth()->user()->can('voir-reservations')) {
            return back()->with('error', "Vous n'avez pas le privilège de créer un vol.");
        }
        $reservations = Reservation::with(['user', 'vol'])->orderBy('created_at', 'asc') ->paginate(20);
        return view('adminreservations', compact('reservations'));
    }

    public function cancelReservation($id) {
        if (!auth()->user()->can('annuler-reservations')) {
            return back()->with('error', "Annulation impossible.");
        }
        $res = Reservation::findOrFail($id);
        $vol = Vol::find($res->vol_id);
        if($vol) {
            $vol->increment('places_disponibles');
        }

        $res->delete();
        return back()->with('success', 'Réservation annulée. La place a été restituée au vol.');
    }

    public function listeUsers() {
            if (!auth()->user()->can('voir-utilisateurs')) {
               return back()->with('error', "Vous n'avez pas le privilège de créer un vol.");
             }
            $users = User::orderBy('created_at', 'asc')->paginate(20);
            $allRoles = \Spatie\Permission\Models\Role::all(); 
            return view('adminuser', compact('users', 'allRoles'));
        }

    public function updateRole(Request $request, $id) {
        if (!auth()->user()->can('gerer-roles-permissions')) {
            return back()->with('error', "Vous n'avez pas le droit de modifier les rôles.");
        }
        $user = User::findOrFail($id);
        if ($user->id == Auth::id()) {
            return back()->with('error', 'Action impossible : Vous ne pouvez pas modifier votre propre rôle.');
        }

        if ($request->role == 'client') { $user->syncRoles([]); 
        } else {
            $user->syncRoles($request->role);
        }
        return back()->with('success', "Le rôle de {$user->prenom} a été mis à jour en : {$request->role}");
    } 

    public function destroyUser($id) {
        if (!auth()->user()->can('supprimer-utilisateurs')) {
            return back()->with('error', "Droit de suppression manquant.");
        }
        if ($id == Auth::id()) {
            return back()->with('error', 'Action impossible : vous êtes actuellement connecté avec ce compte.');
        }

        User::findOrFail($id)->delete();
        return back()->with('success', 'Utilisateur supprimé avec succès.');
    }

}




    
    



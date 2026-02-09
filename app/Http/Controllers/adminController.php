<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vol;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); 
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if ($request->password === env('ADMIN_PASSWORD')) {
            Auth::loginUsingId(1); // Connecte l'admin (ID 1)
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['password' => 'Mot de passe incorrect.']);
    }

    public function index()
    {
        return view('admin.dashboard'); 
    }

    // CRUD pour Vols
    public function storeVol(Request $request)
    {
        $request->validate([
            'vdepart' => 'required|string',
            'varrivee' => 'required|string',
            'date_depart' => 'required|date',
            'npalace' => 'required|integer',
            'prix' => 'required|numeric',
            'statut' => 'required|string',
        ]);

        Vol::create($request->all());

        return redirect()->route('admin.dashboard');
    }

    public function updateVol(Request $request, $id)
    {
        $vol = Vol::findOrFail($id);
        $vol->update($request->all());

        return redirect()->route('admin.dashboard');
    }

    public function destroyVol($id)
    {
        Vol::destroy($id);
        return redirect()->route('admin.dashboard');
    }

    // CRUD pour Utilisateurs
    public function storeUser(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'mail' => 'required|email',
            'password' => 'required|string',
        ]);

        User::create($request->all());

        return redirect()->route('admin.dashboard');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('admin.dashboard');
    }

    public function destroyUser($id)
    {
        User::destroy($id);
        return redirect()->route('admin.dashboard');
    }

    // CRUD pour Réservations
    public function storeReservation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'vol_id' => 'required|integer',
        ]);

        Reservation::create($request->all());

        return redirect()->route('admin.dashboard');
    }

    public function updateReservation(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update($request->all());

        return redirect()->route('admin.dashboard');
    }

    public function destroyReservation($id)
    {
        Reservation::destroy($id);
        return redirect()->route('admin.dashboard');
    }
}
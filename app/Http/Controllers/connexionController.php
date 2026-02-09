<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vol;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class connexionController extends Controller
{

    // Enregistrement d'un nouvel utilisateur
    public function register(Request $request)
    {
        // $request->validate([
        //     'nom' => 'required|string|max:255',
        //     'prenom' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|string|min:6|confirmed',
        // ]);

        User::create([
            
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'statut' => 'User',
        ]);

        return redirect('/connexion')->with('success', 'Inscription réussie. Vous pouvez vous connecter.');
    }

    // Authentification d'un utilisateur
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['email' => $request->mail, 'password' => $request->password])) {
            return redirect()->intended('home')->with('success', 'Connexion réussie.');
        }

        return back()->withErrors(['email' => 'Identifiants invalides.']);
    }

}







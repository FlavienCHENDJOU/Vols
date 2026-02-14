<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vol;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConnexionController extends Controller
{
    
    // Enregistrement d'un nouvel utilisateur
    public function register(Request $request)
    { 
        
        $request->validate([
            'nom'      => 'required|string|max:255',
            'prenom'   => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6', 
        ]);

        User::create([
            'nom'      => $request->nom,
            'prenom'   => $request->prenom,
            'email'    => $request->email,
            'password' => Hash::make($request->password), 
            'statut'   => 'User', 
        ]);


       return redirect('/connexion')->with('success', 'Votre compte a été créé avec succès !');
    }

    public function loginForm(){
        return view('connexion');
    }

    // Authentification d'un utilisateur
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
           $request->session()->regenerate();

        return redirect()->intended('/infoUtilisateur')->with('success', 'Heureux de vous revoir !');
        }

        return back()->withErrors([
             'email' => 'Désolé, l\'email ou le mot de passe ne correspond pas.',
        ])->onlyInput('email'); 
    }

}
     
   
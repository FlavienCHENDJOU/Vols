<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Vol;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   
    public function index(){
        $user = Auth::user();
        return view('userinfo', compact('user'));
    }
     
    public function updateUserInfo(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:users,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'mail' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8', 
        ]);

        $user = User::findOrFail($request->id);
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->mail = $request->mail;
        
        if ($request->password) {
            $user->password = bcrypt($request->password); 
        }

        $user->save();

        return redirect('/userinfo')->with('success', 'Profil mis à jour avec succès');
    }

    public function showReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $passager = Passager::findOrFail($reservation->passager_id);
        $vol = Vol::findOrFail($reservation->vol_id);

        $output = view('partials.passager_info', compact('passager'))->render();
        $output2 = view('partials.vol_info', compact('vol'))->render();

        return response()->json(['passager' => $output, 'vol' => $output2]);
    }


       
}
   
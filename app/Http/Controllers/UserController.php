<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Reservation;
use App\Models\Vol;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
    public function index(){
        $user = Auth::user();
        $nbRes = \App\Models\Reservation::where('email', $user->email)->count();
        $nbrpoints=50 * $nbRes;
        return view('infoUtilisateur', compact('user', 'nbRes','nbrpoints'));
    }
    
     
   public function updateInfo(Request $request)
{
    $user = Auth::user();
     if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
    }
     $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:6', 
       ]);

    $user->nom = $request->nom;
    $user->prenom = $request->prenom;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->back()->with('success', 'Vos informations ont été mises à jour avec succès !');
}
  public function updatePhoto(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = auth()->user(); 

    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('photos', 'public');
         $user->update([   'photo' => $path ]);
    }
    return back()->with('success', 'Votre photo de profil a été mise à jour !');
}

}
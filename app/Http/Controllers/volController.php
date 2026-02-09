<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vol;          
use DB;

class volController extends Controller
{
    // Méthode pour afficher la page d'accueil avec le formulaire de recherche
    public function accueil()
    {
        return view('accueil');  
    }
   
   
    // Méthode pour traiter le formulaire de recherche de vols
    public function rechercher(Request $request) 
    {
   
    // Validation des entrées du 
    $formulairevalidated = $request->validate([
        'destination' => 'required|string',
        'date' => 'required|date',
    ]);

    // Recherche des vols en fonction des 
    $critèresvols = Vol::where('destination', 'like', '%' . validated['destination'] )
        ->where('date',validated['date'])
        ->get();

    // Rediriger vers la page des résultats
    return view('resultats', compact('vols'));

   // Logique pour traiter le formulaire de recherche
    
    }


    public function resultats(Request $request)
    {
        return view('resultats') ;  // Logique pour récupérer les vols et les afficher
    }

    public function details($id)
    {
         
        $vol = Vol::findOrFail($id);
        return view('details', compact('vol'));
       // Logique pour afficher les détails d'un vol
    }

   
} 

    
        


<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Vol;
use Illuminate\Support\Facades\Auth;          
use DB;

class VolController extends Controller
{
     public function accueil()
    {
        return view('accueil');  
    }
     
    public function index2(Request $request)
    {
        
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

    // Requête AJAX (scroll infini) → retourne JSON
    if ($request->ajax()) {
        return response()->json([
            'vols'          => $vols->items(),
            'next_page_url' => $vols->nextPageUrl(),
        ]);
    }

    // Premier chargement → retourne la vue Blade
    return view('vols', compact('vols'));
    }
        
    
    public function index(Request $request)
    {
        $vols = Vol::orderBy('date_depart', 'asc')->paginate(50);
        $layout = 'layouts.admin'; 
        if ($request->ajax()) {

        return response()->json([
            'vols'          => $vols->items(), 
            'next_page_url' => $vols->nextPageUrl()
        ]);
                }

        return view('adminvols', compact('vols', 'layout'));
    }


    public function details($id)
    {
         
        $vol = Vol::findOrFail($id);
        $layout = $this->getDynamicLayout();
        return view('details', compact('vol'));
    }
    
    private function getDynamicLayout()
    {
        if (Auth::check() && Auth::user()->hasAnyRole(['admin_vols', 'admin_users', 'super_admin'])) {
            return 'layouts.admin';
        }
        return 'layouts.app';
    }

    public function rechercher(Request $request)
    {
       $query = Vol::where('places_disponibles', '>', 0)
                    ->where('date_depart', '>', now());

         $query->when($request->depart, function ($q, $depart) {
            return $q->where('depart', 'LIKE', "%{$depart}%");
        });

        $query->when($request->destination, function ($q, $dest) {
            return $q->where('destination', 'LIKE', "%{$dest}%");
        });

        $query->when($request->date, function ($q, $date) {
            return $q->whereDate('date_depart', $date);
        });
        
        $query->when($request->classe, function ($q, $classe) {
            return $q->where('classe', $classe);
        });
        
        $vols = $query->orderBy('date_depart', 'asc')->paginate(50);
        $layout = $this->getDynamicLayout();
        return view('vols_disponible', compact('vols', 'layout'));
    }

    public function historique()
    {
        $vols = Vol::where('places_disponibles', '<=', 0)
                ->orWhere('date_depart', '<', now()) 
                ->orderBy('date_depart', 'desc')
                ->paginate(50); 

        return view('adminvolshistorique', compact('vols'));
    }
 } 

            


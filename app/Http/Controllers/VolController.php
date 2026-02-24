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
   
    public function index()
    {
        $vols = Vol::paginate(20);
        $layout = 'layouts.admin';
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
   
} 

    


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        if (!auth()->user()->can('gerer-roles-permissions')) { abort(403); }
        $user = auth()->user();
         if ($user->hasRole('super_admin')) {
        $roles = Role::with('permissions')->get();
        } else {
             $roles = Role::where('created_by', $user->id)->with('permissions')->get();
        }
        $allUsers = \App\Models\User::select('nom','prenom', 'id')->get()->keyBy('id');
        $superAdminRole = Role::where('name', 'super_admin')->first();
        if ($superAdminRole) {
            $superAdminRole->syncPermissions(Permission::all());
    }
        $mainAdmin = \App\Models\User::role('super_admin')->first();
        return view('adminrolesindex', compact('roles', 'allUsers', 'mainAdmin'));
    }

   
    public function create()
    {
        $permissions = Permission::all();
        return view('adminrolescreate', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'created_by' => auth()->id() 
        ]);
         if ($role->name === 'super_admin') {
            $allPermissions = Permission::all();
            $role->syncPermissions($allPermissions);
        } else {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rôle créé avec succès !');
    }

     public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $user = auth()->user();
        if ($user->hasRole('super_admin') || $role->created_by == $user->id) {
            
            if ($role->name === 'super_admin') {
                return back()->with('error', 'Action interdite.');
            }

            $role->delete();
            return back()->with('success', 'Rôle supprimé.');
        }

        return back()->with('error', 'Vous n\'avez pas le droit de supprimer ce rôle.');
    }


public function edit($id)
{
    $role = Role::findOrFail($id);
    $user = auth()->user();
    if (!$user->hasRole('super_admin') && $role->created_by !== $user->id) {
        return back()->with('error', "Vous n'êtes pas le créateur de ce rôle.");
    }

    $permissions = Permission::all();
    return view('adminrolesedit', compact('role', 'permissions'));
}

public function update(Request $request, $id)
{
    $role = Role::findOrFail($id);
    $user = auth()->user();
    if (!$user->hasRole('super_admin') && $role->created_by !== $user->id) {
        return back()->with('error', "Action non autorisée.");
    }

    $request->validate([
        'permissions' => 'required|array'
    ]);
     if (!$user->hasRole('super_admin')) {
        foreach ($request->permissions as $permissionName) {
            if (!$user->hasPermissionTo($permissionName)) {
                return back()->with('error', "Vous ne pouvez pas donner la permission [$permissionName] car vous ne l'avez pas.");
            }
        }
    }
    $role->syncPermissions($request->permissions);

    return redirect()->route('roles.index')->with('success', 'Privilèges mis à jour avec succès !');
}


    
}



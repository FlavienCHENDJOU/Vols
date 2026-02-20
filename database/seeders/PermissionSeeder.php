<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        $permissions = [
            'voir-vols',
            'creer-vols',
            'modifier-vols',
            'supprimer-vols',
            
            'voir-reservations',
            'annuler-reservations',
            
            'voir-utilisateurs',
            'gerer-roles-permissions',
            'supprimer-utilisateurs',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }
    }
}
  
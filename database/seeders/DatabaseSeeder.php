<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
   public function run()
    {
          $this->call([
            PermissionSeeder::class,
            VolSeeder::class,
            ReservationSeeder::class, 
        ]);

        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $allPermissions = Permission::all();
        $superAdminRole->syncPermissions($allPermissions);
        $admin = User::firstOrCreate(
            ['email' => 'toto@gmail.com'], 
            [
                'nom' => 'Admin',
                'prenom' => 'Principal',
                'password' => Hash::make('toto123'), 
                'statut' => 'Super Admin'
            ]
        );
        $admin->assignRole($superAdminRole);
    }
}


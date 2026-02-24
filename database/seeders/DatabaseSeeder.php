<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
   public function run()
    {
        // 1. On lance d'abord les permissions (Indispensable !)
        $this->call([
            PermissionSeeder::class,
            VolSeeder::class,
            ReservationSeeder::class, 
        ]);

        // 2. On crée le rôle Super Admin s'il n'existe pas
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);

        // 3. On crée ton compte Super Admin par défaut
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Ton email de connexion
            [
                'nom' => 'Admin',
                'prenom' => 'Principal',
                'password' => Hash::make('password'), // Ton mot de passe
                'statut' => 'Super Admin'
            ]
        );

        // 4. On lui donne le rôle
        $admin->assignRole($superAdminRole);
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VolController;
use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use App\Models\Vol;
use App\Models\Reservation;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['web'])->group(function()
{


    Route::get('/', function () {  return view('home'); });

    Route::get('/accueil', [ReservationController::class, 'accueil']); 

    Route::get('/connexion', [ConnexionController::class, 'loginForm']);

    Route::post('/connexion', [ConnexionController::class, 'login']);

    Route::post('/enregistrement', [ConnexionController::class, 'register']);

 
});


Route::middleware(['auth'])->group(function() {

    Route::get('/infoUtilisateur', [UserController::class, 'index']);

    Route::post('/infoUtilisateur/update', [UserController::class, 'updateInfo']);

    Route::post('/profil/update-photo', [UserController::class, 'updatePhoto']);

    Route::get('/vols_disponible', [ReservationController::class, 'vols_disponible']);

    Route::get('/reserver/{vol_id}',[ReservationController::class, 'reserver']);

    Route::get('/mes-reservations', [ReservationController::class, 'mesReservations'])->middleware('auth');

    Route::get('/mes_reservations', [ReservationController::class, 'mesReservations']);
    
    Route::get('/confirmation/{reservation_id}', [ReservationController::class, 'confirmation']);

    Route::post('/form-reserver', [ReservationController::class, 'formReserver']);

    Route::delete('/reservation/supprimer/{id}', [ReservationController::class, 'supprimerReservation']);

    Route::get('/admin', [AdminController::class, 'index']);

    // Routes accessibles uniquement par l'admin des VOLS
    Route::middleware(['auth', 'role:admin_vols|super_admin'])->group(function () {

        Route::get('/admin/vols', [AdminController::class, 'listeVols']);

        Route::post('/admin/vols/ajouter', [AdminController::class, 'creerVol']);

        Route::post('/admin/vols/modifier/{id}', [AdminController::class, 'updateVol']);

        Route::get('/admin/vols/supprimer/{id}', [AdminController::class, 'destroyVol']);

        Route::get('/admin/reservations', [AdminController::class, 'listeReservations']);

        Route::get('/admin/reservations/supprimer/{id}', [AdminController::class, 'cancelReservation']);
    });

    // Routes accessibles uniquement par l'admin des UTILISATEURS
    Route::middleware(['auth', 'role:admin_users|super_admin'])->group(function () {
        
        Route::get('/admin/users', [AdminController::class, 'listeUsers']);

        Route::post('/admin/users/update-role/{id}', [AdminController::class, 'updateRole']);

        Route::get('/admin/utilisateurs/supprimer/{id}', [AdminController::class, 'destroyUser']);

    });


    // Route::middleware(['auth', 'role:super_admin|admin_vols|admin_users'])->group(function () {
    //     Route::get('/admin/roles', [RoleController::class, 'index'])->name('roles.index');
    //     Route::get('/admin/roles/creer', [RoleController::class, 'create'])->name('roles.create');
    //     Route::post('/admin/roles/enregistrer', [RoleController::class, 'store'])->name('roles.store');
    //     Route::delete('/admin/roles/supprimer/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
    //     Route::get('/admin/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
    //     Route::put('/admin/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');

    // });


    // --- GROUPE ADMIN (VOLS) ---
   Route::middleware(['permission:voir-vols'])->group(function () {
        Route::get('/admin/vols', [VolController::class, 'index'])->name('vols.index');
        
        Route::middleware(['permission:creer-vols'])->group(function () {
            Route::get('/admin/vols/creer', [VolController::class, 'create']);
            Route::post('/admin/vols/store', [VolController::class, 'store']);
        });

        Route::middleware(['permission:modifier-vols'])->group(function () {
            Route::get('/admin/vols/modifier/{id}', [VolController::class, 'edit']);
            Route::put('/admin/vols/update/{id}', [VolController::class, 'update']);
        });

        Route::middleware(['permission:supprimer-vols'])->group(function () {
            Route::delete('/admin/vols/supprimer/{id}', [VolController::class, 'destroy']);
        });
    });



    // --- GROUPE ADMIN (RÉSERVATIONS) ---
    Route::middleware(['permission:voir-reservations'])->group(function () {
        Route::get('/admin/reservations', [AdminController::class, 'listeReservations']);
        
        Route::middleware(['permission:annuler-reservations'])->group(function () {
            Route::delete('/admin/reservations/annuler/{id}', [AdminController::class, 'cancelReservation']);
        });
    });



    // --- GROUPE ADMIN (UTILISATEURS & RÔLES) ---
    Route::middleware(['permission:voir-utilisateurs'])->group(function () {
        Route::get('/admin/users', [AdminController::class, 'listeUsers']);

        Route::middleware(['permission:supprimer-utilisateurs'])->group(function () {
            Route::get('/admin/utilisateurs/supprimer/{id}', [AdminController::class, 'destroyUser']);
        });

        Route::middleware(['permission:gerer-roles-permissions'])->group(function () {
            // Gestion des Rôles
            Route::get('/admin/roles', [RoleController::class, 'index'])->name('roles.index');
            Route::get('/admin/roles/creer', [RoleController::class, 'create'])->name('roles.create');
            Route::post('/admin/roles/store', [RoleController::class, 'store'])->name('roles.store');
            Route::get('/admin/roles/edit/{id}', [RoleController::class, 'edit'])->name('roles.edit');
            Route::put('/admin/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
            Route::delete('/admin/roles/supprimer/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
            
            // Attribution des rôles aux utilisateurs
            Route::post('/admin/users/update-role/{id}', [AdminController::class, 'updateRole']);
        });
    });

    Route::get('/exit', function () {
        Auth::logout(); 
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/'); 
    });

 });



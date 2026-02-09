<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\volController;
use App\Http\Controllers\connexionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\adminController;
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


Route::get('/', function () {
    return view('home');
});
Route::get('/connexion', function () { 
    return view('connexion');
 });   


Route::get('/accueil', [ReservationController::class, 'accueil']);   

Route::get('/enregistrement',[connexionController::class,'register']); 

Route::post('/verification', [connexionController::class, 'login']); 

Route::get('/infoUtilisateur', [UserController::class, 'index']);

Route::post('/infoUtilisateur/update', [UserController::class, 'updateUserInfo'])->middleware('auth');

Route::get('/vols_disponible', [ReservationController::class, 'vols_disponible'])->name('vols_disponible');

Route::get('/reserver/{vol_id}', [ReservationController::class, 'reserver'])->name('reserver');

Route::get('/form-reserver', [ReservationController::class, 'formReserver'])->name('form.reserver');

Route::get('/confirmation/{reservation_id}', [ReservationController::class, 'confirmation'])->name('confirmation');

Route::get('/test_reservations',[ReservationController::class, 'test_reservations'])->name('test_reservations');
  
Route::post('/recherche', [volController::class, 'rechercher'])->name('recherche');

Route::get('/resultats', [volController::class, 'resultats'])->name('resultats');

Route::get('/vol/{id}', [volController::class, 'details'])->name('details');
 

 
});




Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware(['auth'])->group(function () {
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Routes CRUD pour Vols
    Route::post('/admin/vols', [AdminController::class, 'storeVol'])->name('admin.storeVol');
    Route::put('/admin/vols/{id}', [AdminController::class, 'updateVol'])->name('admin.updateVol');
    Route::delete('/admin/vols/{id}', [AdminController::class, 'destroyVol'])->name('admin.destroyVol');

    // Routes CRUD pour Utilisateurs
    Route::post('/admin/utilisateurs', [AdminController::class, 'storeUser'])->name('admin.storeUser');
    Route::put('/admin/utilisateurs/{id}', [AdminController::class, 'updateUser'])->name('admin.updateUser');
    Route::delete('/admin/utilisateurs/{id}', [AdminController::class, 'destroyUser'])->name('admin.destroyUser');

    // Routes CRUD pour Réservations
    Route::post('/admin/reservations', [AdminController::class, 'storeReservation'])->name('admin.storeReservation');
    Route::put('/admin/reservations/{id}', [AdminController::class, 'updateReservation'])->name('admin.updateReservation');
    Route::delete('/admin/reservations/{id}', [AdminController::class, 'destroyReservation'])->name('admin.destroyReservation');
});
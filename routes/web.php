<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\VolController;
use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
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

Route::get('/connexion', [connexionController::class, 'loginForm']);

Route::post('/connexion', [connexionController::class, 'login']);

Route::post('/enregistrement', [ConnexionController::class, 'register']);

 
});


Route::middleware(['auth'])->group(function() {

Route::get('/infoUtilisateur', [UserController::class, 'index']);

Route::post('/infoUtilisateur/update', [UserController::class, 'updateUserInfo']);

Route::get('/vols_disponible', [ReservationController::class, 'vols_disponible']);

Route::get('/test_reservations',[ReservationController::class, 'test_reservations']);
 
Route::get('/mes_reservations', [ReservationController::class, 'mesReservations']);
 
Route::get('/confirmation/{reservation_id}', [ReservationController::class, 'confirmation']);

Route::post('/form-reserver', [ReservationController::class, 'formReserver']);

Route::delete('/reservation/supprimer/{id}', [ReservationController::class, 'supprimerReservation']);

});


  

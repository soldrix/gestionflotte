<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/addVoiture','App\Http\Controllers\HomeController@VoitureForm');
Route::post('/addAssurance', [App\Http\Controllers\AssuranceController::class, 'createAssurance']);
Route::post('/addEntretiens', [App\Http\Controllers\EntretiensController::class, 'createEntretiens']);
Route::post('/addReparations', [App\Http\Controllers\ReparationsController::class, 'createReparations']);
Route::post('/addConsommation', [App\Http\Controllers\ConsommationController::class, 'create']);

Route::post('/delAssurance', [App\Http\Controllers\AssuranceController::class, 'deleteAssurance']);
Route::post('/delEntretiens', [App\Http\Controllers\EntretiensController::class, 'deleteEntretiens']);
Route::post('/delVoiture', [App\Http\Controllers\HomeController::class, 'deleteVoiture']);
Route::post('/delReparation', [App\Http\Controllers\ReparationsController::class, 'deleteReparations']);
Route::post('/delConsommation', [App\Http\Controllers\ConsommationController::class, 'delete']);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('voiture');
Route::get('/assurance', [App\Http\Controllers\AssuranceController::class, 'charge']);
Route::get('/entretiens', [App\Http\Controllers\EntretiensController::class, 'charge']);
Route::get('/reparation', [App\Http\Controllers\ReparationsController::class, 'charge']);
Route::get('/consommation', [App\Http\Controllers\ConsommationController::class, 'charge']);

Route::get('/voiture/{id}', [App\Http\Controllers\VoitureController::class, 'charge'])->name('voitureData');
Route::get('/voiture/', [App\Http\Controllers\VoitureController::class, 'charge']);


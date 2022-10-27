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

Route::post('/addVoiture',[App\Http\Controllers\HomeController::class, 'insertData']);
Route::post('/addAssurance', [App\Http\Controllers\AssuranceController::class, 'insertDatas']);
Route::post('/addEntretiens', [App\Http\Controllers\EntretiensController::class, 'insertDatas']);
Route::post('/addReparations', [App\Http\Controllers\ReparationsController::class, 'insertDatas']);
Route::post('/addConsommation', [App\Http\Controllers\ConsommationController::class, 'insertData']);
Route::post('/addAgence',[App\Http\Controllers\AgenceController::class, 'insertDatas']);
Route::post('/addLocation',[App\Http\Controllers\locationController::class, 'insertDatas']);

Route::post('/delAssurance', [App\Http\Controllers\AssuranceController::class, 'deleteAssurance']);
Route::post('/delEntretiens', [App\Http\Controllers\EntretiensController::class, 'deleteEntretiens']);
Route::post('/delVoiture', [App\Http\Controllers\HomeController::class, 'deleteVoiture']);
Route::post('/delReparations', [App\Http\Controllers\ReparationsController::class, 'deleteReparations']);
Route::post('/delConsommation', [App\Http\Controllers\ConsommationController::class, 'delete']);
Route::post('/delAgence',[App\Http\Controllers\AgenceController::class, 'delete']);
Route::post('/delLocation',[App\Http\Controllers\locationController::class, 'delete']);

Route::post('/updateAssurance', [App\Http\Controllers\AssuranceController::class, 'updateDatas']);
Route::post('/updateEntretiens', [App\Http\Controllers\EntretiensController::class, 'updateDatas']);
Route::post('/updateVoiture', [App\Http\Controllers\VoitureController::class, 'updateDatas']);
Route::post('/updateReparations', [App\Http\Controllers\ReparationsController::class, 'updateDatas']);
Route::post('/updateConsommation', [App\Http\Controllers\ConsommationController::class, 'updateDatas']);
Route::post('/updateAgence',[App\Http\Controllers\AgenceController::class, 'updateDatas']);
Route::post('/updateLocation', [App\Http\Controllers\locationController::class, 'updateDatas']);

Route::post('/getVoiture', [App\Http\Controllers\VoitureController::class, 'getVoiture']);
Route::post('/getConsommation', [App\Http\Controllers\ConsommationController::class, 'getConsommation']);
Route::post('/getEntretiens', [App\Http\Controllers\EntretiensController::class, 'getEntretiens']);
Route::post('/getReparations', [App\Http\Controllers\ReparationsController::class, 'getReparations']);
Route::post('/getAssurance', [App\Http\Controllers\AssuranceController::class, 'getAssurance']);
Route::post('/getAgence',[App\Http\Controllers\AgenceController::class, 'getAgence']);
Route::post('/getLocation', [App\Http\Controllers\locationController::class, 'getLocation']);

Route::post('/uploadImage', [App\Http\Controllers\VoitureController::class, 'uploadImage']);
Route::post('/loadAgence', [App\Http\Controllers\AgenceController::class, 'loadAgence']);
Route::post('/loadVoiture', [App\Http\Controllers\VoitureController::class, 'loadVoiture']);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('voiture');
Route::get('/assurance', [App\Http\Controllers\AssuranceController::class, 'charge']);
Route::get('/entretiens', [App\Http\Controllers\EntretiensController::class, 'charge']);
Route::get('/reparations', [App\Http\Controllers\ReparationsController::class, 'charge']);
Route::get('/consommation', [App\Http\Controllers\ConsommationController::class, 'charge']);
Route::get('/agence',[App\Http\Controllers\AgenceController::class, 'charge']);
Route::get('/location',[App\Http\Controllers\locationController::class, 'charge']);

Route::get('/voiture/{id}', [App\Http\Controllers\VoitureController::class, 'charge'])->name('voitureData');



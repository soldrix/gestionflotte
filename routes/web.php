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
Route::post('/addAssurance', [App\Http\Controllers\AssuranceController::class, 'createAssurance']);
Route::post('/addEntretiens', [App\Http\Controllers\EntretiensController::class, 'insertDatas']);
Route::post('/addReparations', [App\Http\Controllers\ReparationsController::class, 'createReparations']);
Route::post('/addConsommation', [App\Http\Controllers\ConsommationController::class, 'create']);

Route::post('/delAssurance', [App\Http\Controllers\AssuranceController::class, 'deleteAssurance']);
Route::post('/delEntretiens', [App\Http\Controllers\EntretiensController::class, 'deleteEntretiens']);
Route::post('/delVoiture', [App\Http\Controllers\HomeController::class, 'deleteVoiture']);
Route::post('/delReparation', [App\Http\Controllers\ReparationsController::class, 'deleteReparations']);
Route::post('/delConsommation', [App\Http\Controllers\ConsommationController::class, 'delete']);

Route::post('/updateAssurance', [App\Http\Controllers\AssuranceController::class, 'updateDatas']);
Route::post('/updateEntretiens', [App\Http\Controllers\EntretiensController::class, 'updateDatas']);
Route::post('/updateVoiture', [App\Http\Controllers\VoitureController::class, 'updateDatas']);
Route::post('/updateReparations', [App\Http\Controllers\ReparationsController::class, 'updateDatas']);
Route::post('/updateConsommation', [App\Http\Controllers\ConsommationController::class, 'updateDatas']);


Route::post('/voiture/addEntretien', [App\Http\Controllers\VoitureController::class, 'addEntretien']);
Route::post('/voiture/addReparation', [App\Http\Controllers\VoitureController::class, 'addReparation']);
Route::post('/voiture/addAssurance', [App\Http\Controllers\VoitureController::class, 'addAssurance']);
Route::post('/voiture/addConsommation', [App\Http\Controllers\VoitureController::class, 'addConsommation']);

Route::post('/getVoiture', [App\Http\Controllers\VoitureController::class, 'getVoiture']);
Route::post('/getConsommation', [App\Http\Controllers\ConsommationController::class, 'getConsommation']);
Route::post('/getEntretiens', [App\Http\Controllers\EntretiensController::class, 'getEntretiens']);
Route::post('/getReparations', [App\Http\Controllers\ReparationsController::class, 'getReparations']);
Route::post('/getAssurance', [App\Http\Controllers\AssuranceController::class, 'getAssurance']);

Route::post('/uploadImage', [App\Http\Controllers\VoitureController::class, 'uploadImage']);


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('voiture');
Route::get('/assurance', [App\Http\Controllers\AssuranceController::class, 'charge']);
Route::get('/entretiens', [App\Http\Controllers\EntretiensController::class, 'charge']);
Route::get('/reparation', [App\Http\Controllers\ReparationsController::class, 'charge']);
Route::get('/consommation', [App\Http\Controllers\ConsommationController::class, 'charge']);

Route::get('/voiture/{id}', [App\Http\Controllers\VoitureController::class, 'charge'])->name('voitureData');



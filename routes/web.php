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
Route::get('/entretiens',function (){
   return view('entretiens');
});

Route::get('/reparation',function (){
   return view('reparation');
});
Route::get('/carburants',function (){
   return view('carburants');
});
Route::get('/voiture',function (){
   return view('voiture');
});
Route::post('/addVoiture','App\Http\Controllers\HomeController@VoitureForm');

Route::post('/addAssurance', [App\Http\Controllers\AssuranceController::class, 'createAssurance']);
Route::post('/delAssurance', [App\Http\Controllers\AssuranceController::class, 'deleteAssurance']);
Route::post('/delVoiture', [App\Http\Controllers\HomeController::class, 'deleteVoiture']);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('voiture');
Route::get('/assurance', [App\Http\Controllers\AssuranceController::class, 'charge']);

Route::get('/voiture/{id}', [App\Http\Controllers\VoitureController::class, 'charge'])->name('voitureData');
Route::get('/voiture/', [App\Http\Controllers\VoitureController::class, 'charge']);


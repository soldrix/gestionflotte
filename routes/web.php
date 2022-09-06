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
Route::get('/assurance',function (){
   return view('assurance');
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

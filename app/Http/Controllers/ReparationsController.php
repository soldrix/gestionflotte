<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReparationsController extends Controller
{
    public function charge(){
        $voiture = DB::select('select * from voiture');
        $reparations = DB::select('SELECT reparations.*,voiture.immatriculation FROM `reparations` INNER JOIN voiture ON voiture.id = reparations.id_voiture ');
        return  view('/reparation',['voiture'=>$voiture,'reparations'=>$reparations]);
    }
    public function createReparations(Request $request){
        $validation = $request->validate([
            "typeRep" => "required",
            "dateRep" => "required",
            "montantRep" => "required",
            "garageRep" => "required",
            "id_voiture" => "required"
        ]);

        $note = (isset($request->noteRep)) ? $request->noteRep : null;
        DB::table('reparations')->insert([
            "typeRep" => $validation['typeRep'],
            "id_voiture" => $validation['id_voiture'],
            "dateRep" => $validation['dateRep'],
            "montantRep" => $validation['montantRep'],
            "garageRep" => $validation['garageRep'],
            "noteRep" => $note
        ]);

        return redirect('/reparation')->with('dataSave','success');
    }
    public function deleteReparations(Request $request) : void{
        $row = $request->id;
        DB::delete("DELETE FROM `reparations` WHERE id='$row'");
    }
}

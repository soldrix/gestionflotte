<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReparationsController extends Controller
{
    public function insertDatas($datas){
        $validation = $datas->validate([
            "typeRep" => "required",
            "dateRep" => "required",
            "montantRep" => "required",
            "garageRep" => "required",
            "id_voiture" => "required"
        ]);
        $tab =[
            "typeRep" => $validation['typeRep'],
            "id_voiture" => $validation['id_voiture'],
            "dateRep" => $validation['dateRep'],
            "montantRep" => $validation['montantRep'],
            "garageRep" => $validation['garageRep'],
            "noteRep" => (isset($datas->noteRep)) ? $datas->noteRep : null
        ];
        DB::table('reparations')->insert($tab);
        return $tab;
    }

    public function charge(){
        $voiture = DB::select('select * from voiture');
        $reparation = DB::select('SELECT reparations.*,voiture.immatriculation FROM `reparations` INNER JOIN voiture ON voiture.id = reparations.id_voiture');
        return  view('/reparation',['voiture'=>$voiture,'reparation'=>$reparation]);
    }
    public function createReparations(Request $request){
        $this->insertDatas($request);
        return redirect('/reparation')->with('dataSave','success');
    }
    public function deleteReparations(Request $request) : void{
        $row = $request->id;
        DB::delete("DELETE FROM `reparations` WHERE id='$row'");
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReparationsController extends Controller
{
    public function insertDatas(Request $request){
        $validation = $request->validate([
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
            "noteRep" => (isset($request->noteRep)) ? $request->noteRep : 'aucune note'
        ];
        DB::table('reparations')->insert($tab);
        return DB::table('reparations')->select('reparations.*','immatriculation')->join('voiture' , 'reparations.id_voiture', '=','voiture.id')->where($tab)->get();
    }
    public function updateDatas(Request $request){
        $validation = $request->validate([
            "typeRep" => "required",
            "dateRep" => "required",
            "montantRep" => "required",
            "garageRep" => "required"
        ]);
        $id = $request->id;
        DB::table('reparations')->where('id',$id)->update([
            "typeRep" => $validation['typeRep'],
            "dateRep" => $validation['dateRep'],
            "montantRep" => $validation['montantRep'],
            "garageRep" => $validation['garageRep'],
            "noteRep" => (isset($request->noteRep)) ? $request->noteRep : 'aucune note'
        ]);
        return DB::table('reparations')->select('reparations.*','immatriculation')->join('voiture' , 'reparations.id_voiture', '=','voiture.id')->where('reparations.id',$id)->get();
    }
    public function charge(){
        $voiture = DB::select('select * from voiture');
        $reparation = DB::select('SELECT reparations.*,voiture.immatriculation FROM `reparations` INNER JOIN voiture ON voiture.id = reparations.id_voiture');
        return  view('/reparation',['voiture'=>$voiture,'reparation'=>$reparation]);
    }
    public function deleteReparations(Request $request) : void{
        $row = $request->id;
        DB::delete("DELETE FROM `reparations` WHERE id='$row'");
    }
    public function getReparations(Request $request){
        $id = $request->id;
        $data =  DB::select("SELECT * from reparations where id='$id'");
        return json_encode($data);
    }
}

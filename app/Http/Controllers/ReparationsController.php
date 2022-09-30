<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReparationsController extends Controller
{
    public function verifDatas($datas){
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
        return $tab;
    }

    public function insertDatas($datas){
        return DB::table('reparations')->insert($this->verifDatas($datas));
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
        $json = new \stdClass();
        $json->id = $id;
        $json->typeRep = $validation['typeRep'];
        $json->montantRep = $validation['montantRep'];
        $json->garageRep = $validation['garageRep'];
        $json->dateRep = $validation['dateRep'];
        $json->noteRep = (isset($request->noteRep)) ? $request->noteRep : 'aucune note';
        return json_encode($json);
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
    public function getReparations(Request $request){
        $id = $request->id;
        $data =  DB::select("SELECT * from reparations where id='$id'");
        return json_encode($data);
    }
}

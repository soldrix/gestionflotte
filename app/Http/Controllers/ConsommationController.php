<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConsommationController extends Controller
{
    public function verifDatas($datas){
        $validation = $datas->validate([
            "litre" => "required",
            "montantCons" => "required",
            "id_voiture" => "required"
        ]);
        $tab =[
            "litre" => $validation['litre'],
            "montantCons" => $validation['montantCons'],
            "id_voiture" => $validation['id_voiture'],
        ];
        return $tab;
    }
    public function insertData($datas){
        return DB::table('reparations')->insert($this->verifDatas($datas));
    }
    public function updateDatas($datas) : void{
        DB::table('reparations')->upddate($this->verifDatas($datas));
    }
    public function charge(){
        $voiture = DB::select('select * from voiture');
        $consommation = DB::select('SELECT consommation.*,voiture.immatriculation FROM `consommation` INNER JOIN voiture ON voiture.id = consommation.id_voiture ');
        return  view('/consommation',['voiture'=>$voiture,'consommation'=>$consommation]);
    }
    public function create(Request $request){
        $this->insertData($request);
        return redirect('/consommation')->with('dataSave','success');
    }
    public function delete(Request $request) : void{
        $row = $request->id;
        DB::delete("DELETE FROM `consommation` WHERE id='$row'");
    }
    public function getConsommation(Request $request){
        $id = $request->id;
        $data =  DB::select("SELECT * from consommation where id='$id'");
        return json_encode($data);
    }
}

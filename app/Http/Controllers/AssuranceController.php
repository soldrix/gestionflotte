<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AssuranceController extends Controller
{
    public function insertDatas($datas){
        $validation = $datas->validate([
            "id_voiture" => "required",
            "nomAssu" => "required",
            "debutAssu" => "required",
            "finAssu" => "required",
            "frais" => "required",
        ]);
        DB::table('assurance')->insert([
            "nomAssu" => $validation['nomAssu'],
            "id_voiture" => $validation['id_voiture'],
            "debutAssu" => $validation['debutAssu'],
            "finAssu" => $validation['finAssu'],
            "frais" => $validation['frais'],
        ]);
        return $validation;
    }
    public function updateDatas(Request $request){
        $validation = $request->validate([
            "nomAssu" => "required",
            "debutAssu" => "required",
            "finAssu" => "required",
            "frais" => "required",
        ]);
        $id = $request->id;
        DB::table('assurance')->where('id',$id)->update([
            "nomAssu" => $validation['nomAssu'],
            "debutAssu" => $validation['debutAssu'],
            "finAssu" => $validation['finAssu'],
            "frais" => $validation['frais'],
        ]);
        $json = new \stdClass();
        $json->id = $id;
        $json->nomAssu = $validation['nomAssu'];
        $json->debutAssu = $validation['debutAssu'];
        $json->finAssu = $validation['finAssu'];
        $json->frais = $validation['frais'];
        return json_encode($json);
    }
    public function charge(){
        $voiture = DB::select('select * from voiture');
        $assurance = DB::select('SELECT assurance.*,voiture.immatriculation FROM `assurance` INNER JOIN voiture ON voiture.id = assurance.id_voiture ');
        return  view('/assurance',['voiture'=>$voiture,'assurance'=>$assurance]);
    }

    public function createAssurance(Request $request){
        $this->insertDatas($request);
        return redirect('/assurance')->with('dataSave','sucess');
    }
    public function deleteAssurance(Request $request) : void{
        $row = $request->id;
        DB::delete("DELETE FROM `assurance` WHERE id='$row'");
    }
    public function modification(Request $request){
        DB::table('assurance')->update($this->dbDataRow($request));
        return $request;
    }
    public function getAssurance(Request $request){
        $id = $request->id;
        $data =  DB::select("SELECT * from assurance where id='$id'");
        return json_encode($data);
    }
}

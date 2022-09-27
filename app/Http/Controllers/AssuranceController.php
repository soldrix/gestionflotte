<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssuranceController extends Controller
{
    public function charge(){
        $voiture = DB::select('select * from voiture');
        $assurance = DB::select('SELECT assurance.*,voiture.immatriculation FROM `assurance` INNER JOIN voiture ON voiture.id = assurance.id_voiture ');
        return  view('/assurance',['voiture'=>$voiture,'assurance'=>$assurance]);
    }
    public function createAssurance(Request $request){

        $validation = $request->validate([
            "id_voiture" => "required",
            "nomAssu" => "required",
            "debutAssu" => "required",
            "finAssu" => "required",
            "frais" => "required",
        ]);

        $assurance = DB::table('assurance')->insert([
            "nomAssu" => $validation['nomAssu'],
            "id_voiture" => $validation['id_voiture'],
            "debutAssu" => $validation['debutAssu'],
            "finAssu" => $validation['finAssu'],
            "frais" => $validation['frais'],
        ]);
        return redirect('/assurance')->with('dataSave','sucess');
    }
    public function deleteAssurance(Request $request){
        $row = $request->id_voiture;
        DB::delete("DELETE FROM `assurance` WHERE id_voiture='$row'");
    }
}

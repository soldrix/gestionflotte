<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssuranceController extends Controller
{
    public function createAssurance(Request $request){
        $validation = $request->validate([
            "nomAssu" => "required",
            "debutAssu" => "required",
            "finAssu" => "required",
            "frais" => "required",
            "immatriculation" => "required",
        ]);

        $immatriculation = $validation['immatriculation'];

        $idVoiture = DB::table('voiture')->select("id")->where('immatriculation',"'$immatriculation'");
        foreach ($idVoiture as $datas){
            $voitureID = $datas->id;
        }
        $assurance = DB::table('assurance')->insert([
            "nomAssu" => $validation['nomAssu'],
            "id_voiture" => $voitureID,
            "debutAssu" => $validation['debutAssu'],
            "finAssu" => $validation['finAssu'],
            "frais" => $validation['frais'],
        ]);

        return response()->json($assurance);
    }
}

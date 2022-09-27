<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntretiensController extends Controller
{
    public function createAssurance(Request $request){

            $validation = $request->validate([
                "typeEnt" => "required",
                "dateEnt" => "required",
                "montantEnt" => "required",
                "garageEnt" => "required",
            ]);
            $note = (isset($request->noteEnt)) ? $request->noteEnt : "";
            DB::table('entretiens')->insert([
                "typeEnt" => $validation['typeEnt'],
                "id_voiture" => $voitureID,
                "dateEnt" => $validation['dateEnt'],
                "montantEnt" => $validation['montantEnt'],
                "garageEnt" => $validation['garageEnt'],
                "noteEnt" => $note,
            ]);

    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntretiensController extends Controller
{
    public function charge(){
        $voiture = DB::select('select * from voiture');
        $entretiens = DB::select('SELECT entretiens.*,voiture.immatriculation FROM `entretiens` INNER JOIN voiture ON voiture.id = entretiens.id_voiture ');
        return  view('/entretiens',['voiture'=>$voiture,'entretiens'=>$entretiens]);
    }
    public function createEntretiens(Request $request){
        $validation = $request->validate([
                "typeEnt" => "required",
                "dateEnt" => "required",
                "montantEnt" => "required",
                "garageEnt" => "required",
                "id_voiture" => "required"
            ]);

        $note = (isset($request->noteEnt)) ? $request->noteEnt : null;
        DB::table('entretiens')->insert([
                "typeEnt" => $validation['typeEnt'],
                "id_voiture" => $validation['id_voiture'],
                "dateEnt" => $validation['dateEnt'],
                "montantEnt" => $validation['montantEnt'],
                "garageEnt" => $validation['garageEnt'],
                "noteEnt" => $note
        ]);

        return redirect('/entretiens')->with('dataSave','success');
    }
    public function deleteEntretiens(Request $request) : void{
        $row = $request->id;
        DB::delete("DELETE FROM `entretiens` WHERE id='$row'");
    }

}

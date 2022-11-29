<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntretiensController extends Controller
{
    public function insertDatas(Request $request){
        $validation = $request->validate([
            "typeEnt" => "required",
            "dateEnt" => "required",
            "montantEnt" => "required",
            "garageEnt" => "required",
            "id_voiture" => "required"
        ]);
        $tab = [
            "typeEnt" => $validation['typeEnt'],
            "id_voiture" => $validation['id_voiture'],
            "dateEnt" => $validation['dateEnt'],
            "montantEnt" => $validation['montantEnt'],
            "garageEnt" => $validation['garageEnt'],
            "noteEnt" => (isset($request->noteEnt)) ? $request->noteEnt : 'Aucune note'
        ];
        DB::table('entretiens')->insert($tab);
        return DB::table('entretiens')->select('entretiens.*','immatriculation')->join('voiture' , 'entretiens.id_voiture', '=','voiture.id')->where($tab)->get();
    }
    public function updateDatas(Request $request){
        $validation = $request->validate([
            "typeEnt" => "required",
            "dateEnt" => "required",
            "montantEnt" => "required",
            "garageEnt" => "required"
        ]);
        $id = $request->id;
        DB::table('entretiens')->where('id',$id)->update([
            "typeEnt" => $validation['typeEnt'],
            "dateEnt" => $validation['dateEnt'],
            "montantEnt" => $validation['montantEnt'],
            "garageEnt" => $validation['garageEnt'],
            "noteEnt" => (isset($request->noteEnt)) ? $request->noteEnt : 'Aucune note'
        ]);
        return DB::table('entretiens')->select('entretiens.*','immatriculation')->join('voiture' , 'entretiens.id_voiture', '=','voiture.id')->where('entretiens.id',$id)->get();
    }
    public function charge(){
        $user_type = Auth::user()->type;
        if ( $user_type === 'admin'){
            $voiture = DB::select('select * from voiture');
            $entretiens = DB::select('SELECT entretiens.*,voiture.immatriculation FROM `entretiens` INNER JOIN voiture ON voiture.id = entretiens.id_voiture ');
        }
        return ($user_type !=='admin') ? redirect('/home') : view('/entretiens',['voiture'=>$voiture,'entretiens'=>$entretiens]);
    }

    public function deleteEntretiens(Request $request) : void{
        $row = $request->id;
        DB::delete("DELETE FROM `entretiens` WHERE id='$row'");
    }
    public function getEntretiens(Request $request){
        $id = $request->id;
        $data =  DB::select("SELECT * from entretiens where id='$id'");
        return json_encode($data);
    }
}

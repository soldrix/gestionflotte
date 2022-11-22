<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class locationController extends Controller
{
    public function verification($datas){
        $validation = $datas->validate([
            "id_voiture" => "required",
            "id_agence" => "required",
            "dateDebut" => "required",
            "dateFin" => "required"
        ]);
        $tab = [
            "id_agence" => ($validation['id_agence'] !=='null') ? $validation['id_agence'] : null,
            "id_voiture" => ($validation['id_voiture'] !== 'null') ? $validation['id_voiture']: null,
            "dateDebut" => $validation['dateDebut'],
            "dateFin" => $validation['dateFin']
        ];
        return $tab;
    }
    public function insertDatas(Request $request){
        DB::table('location')->insert($this->verification($request));
        return DB::table('location')
            ->select('location.*','immatriculation','rue','ville')
            ->join('agence' , "agence.id", '=',"location.id_agence")
            ->join('voiture','voiture.id','=','location.id_voiture')
            ->where([
                "agence.id" => $request->id_agence,
                "id_voiture" => $request->id_voiture,
                "dateDebut" => $request->dateDebut,
                "dateFin" => $request->dateFin
            ])
            ->get();
    }
    public function updateDatas(Request $request){
        $id = $request->id;
        DB::table('location')->where('id',$id)->update($this->verification($request));
        return DB::table('location')
            ->select('location.*','immatriculation','rue','ville')
            ->join('agence' , "agence.id", '=',"location.id_agence")
            ->join('voiture','voiture.id','=','location.id_voiture')
            ->where([
                "agence.id" => $request->id_agence,
                "id_voiture" => $request->id_voiture,
                "dateDebut" => $request->dateDebut,
                "dateFin" => $request->dateFin
            ])
            ->get();
    }
    public function charge(){
        $user_type = Auth::user()->type;
        if ( $user_type === 'admin'){
            $agence = DB::table('agence')->get();
            $voiture = Db::table('voiture')->select('id','immatriculation')->get();
            $location = DB::select('SELECT location.*,immatriculation,ville,rue FROM `location` INNER JOIN voiture ON voiture.id = location.id_voiture inner join agence on agence.id = location.id_agence');
        }
        return ($user_type !=='admin') ? redirect('/home') : view('/location',['location'=>$location,'agence'=>$agence,'voiture'=>$voiture]);
    }
    public function delete(Request $request) : void{
        $row = $request->id;
        DB::delete("DELETE FROM `location` WHERE id='$row'");
    }
    public function getLocation(Request $request){
        $id = $request->id;
        $data =  DB::select("SELECT * from location where id='$id'");
        return json_encode($data);
    }
}

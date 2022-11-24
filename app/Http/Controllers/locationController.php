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
            "dateDebut" => "required",
            "dateFin" => "required"
        ]);
        $tab = [
            "id_voiture" => ($validation['id_voiture'] !== 'null') ? $validation['id_voiture']: null,
            "dateDebut" => $validation['dateDebut'],
            "dateFin" => $validation['dateFin']
        ];
        return $tab;
    }
    public function insertDatas(Request $request){
        DB::table('location')->insert($this->verification($request));
        return DB::table('location')
            ->select('location.*','immatriculation')
            ->join('voiture','voiture.id','=','location.id_voiture')
            ->where([
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
            ->select('location.*','immatriculation')
            ->leftjoin('voiture','voiture.id','=','location.id_voiture')
            ->where([
                "id_voiture" =>  ($request->id_voiture !== 'null') ? $request->id_voiture : null,
                "dateDebut" => $request->dateDebut,
                "dateFin" => $request->dateFin
            ])
            ->get();
    }
    public function charge(){
        $user_type = Auth::user()->type;
        if ( $user_type === 'admin'){
            $voiture = Db::table('voiture')->select('id','immatriculation')->get();
            $location = DB::select('SELECT location.*,immatriculation FROM `location` left JOIN voiture ON voiture.id = location.id_voiture');
        }
        return ($user_type !=='admin') ? redirect('/home') : view('/location',['location'=>$location,'voiture'=>$voiture]);
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
    public function getLocationDate(Request $request){
       return DB::table('location')->select('location.dateDebut','location.dateFin','voiture.prix')->leftJoin('voiture', 'location.id_voiture', '=', 'voiture.id')
           ->where([
           'location.id_voiture' => $request->id_voiture
       ])->get(['dateDebut','dateFin']);
    }
}

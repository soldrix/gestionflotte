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
            "dateFin" => "required",
            'montant' => 'required'
        ]);
        $tab = [
            "id_voiture" => ($validation['id_voiture'] !== 'null') ? $validation['id_voiture']: null,
            "dateDebut" => $validation['dateDebut'],
            "dateFin" => $validation['dateFin'],
            "montant" => $validation['montant'],
            'id_users' => Auth::id()
        ];
        return $tab;
    }
    public function insertDatas(Request $request){
        $id = DB::table('location')->insertGetId($this->verification($request));
        return DB::table('location')
            ->select('location.*','immatriculation')
            ->join('voiture','voiture.id','=','location.id_voiture')
            ->where([
                "location.id" => $id,
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
                'location.id' => $id
            ])
            ->get();
    }
    public function charge(){
        $user_type = Auth::user()->type;
        if ( $user_type === 'admin'){
            $voiture = Db::table('voiture')->select('id','immatriculation')->get();
            $location = DB::select('SELECT location.*,immatriculation FROM `location` left JOIN voiture ON voiture.id = location.id_voiture');
        }
        else{
            $location = DB::table('location')->select('location.*','voiture.marque','voiture.model')
            ->leftJoin('voiture','location.id_voiture', '=' ,'voiture.id')
            ->where([
                'id_users' => Auth::id()
            ])
            ->get();
        }
        return ($user_type !=='admin') ? view('/location',['location'=>$location]) : view('/location',['location'=>$location,'voiture'=>$voiture]);
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
       $voiture = DB::table('voiture')->where([
           'id' => $request->id_voiture
       ])->get('prix');
       $Date =  DB::table('location')
           ->where([
           'id_voiture' => $request->id_voiture
       ])->get(['dateDebut','dateFin']);
       if ((count($Date) >=1)){
           $voiture[0]->dateDebut = $Date[0]->dateDebut;
           $voiture[0]->dateFin = $Date[0]->dateFin;
       }
       return $voiture;
    }

    public function chargeVoiture(Request $request){
        $voiture = DB::table('voiture')->where([
            'id_agence' => $request->id_agence
        ])->get();
        $agence = DB::table('agence')->where([
            'id'=> $request->id_agence
        ])->get();
        $type = DB::select('SELECT distinct type from voiture');
        $voiture =(!empty($voiture)) ?  $voiture : json_encode(null);
        return  view('/locationVoiture',['voiture' => $voiture,'type' => $type,'agence' => $agence,'nbVoiture' => count($voiture)]);
    }
}

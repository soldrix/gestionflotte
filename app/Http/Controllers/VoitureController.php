<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoitureController extends Controller
{
    public function charge(Request $request){
        $id = (isset($request->id)) ? $request->id : null ;
        $voitureData = ($id != null) ? DB::select("select * from voiture where id='$id'") : DB::select("select * from voiture LIMIT 1");

        foreach ($voitureData as $datas){
            $voitureID = $datas->id;
        }
        $datas1 = ($id != null) ? DB::select("select * from assurance where id_voiture='$id'") : DB::select("select * from assurance where id_voiture='$voitureID'");
        $datas2 = ($id != null) ? DB::select("select * from consommation where id_voiture='$id'") : DB::select("select * from consommation where id_voiture='$voitureID'");
        $datas3 = ($id != null) ? DB::select("select * from entretiens where id_voiture='$id'") : DB::select("select * from entretiens where id_voiture='$voitureID'");
        $datas4 = ($id != null) ? DB::select("select * from reparations where id_voiture='$id'") : DB::select("select * from reparations where id_voiture='$voitureID'");

        return view('voiture',['voitureData'=>$voitureData,'assurance'=>$datas1,"consommation"=>$datas2,"entretiens"=>$datas3,"reparations"=>$datas4]);
    }

}

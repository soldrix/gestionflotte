<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;

class VoitureController extends Controller
{
    public function charge(Request $request){
        $id = (isset($request->id)) ? $request->id : null ;
        $voitureData = DB::select("select * from voiture where id='$id'");

        foreach ($voitureData as $datas){
            $voitureID = $datas->id;
        }
        $nbData = Db::select("SELECT COUNT(reparations.id) AS 'nbRep',COUNT(entretiens.id) AS 'nbEnt',COUNT(consommation.id) AS 'nbCons',COUNT(assurance.id) AS 'nbAssu' FROM voiture INNER JOIN reparations on voiture.id= reparations.id_voiture INNER JOIN entretiens on voiture.id = entretiens.id_voiture INNER JOIN consommation on voiture.id = consommation.id_voiture INNER JOIN assurance on voiture.id =assurance.id_voiture WHERE voiture.id = '$voitureID'");
        $datas1 = DB::select("select * from assurance where id_voiture='$id'");
        $datas2 = DB::select("select * from consommation where id_voiture='$id'");
        $datas3 = DB::select("select * from entretiens where id_voiture='$id'");
        $datas4 = DB::select("select * from reparations where id_voiture='$id'");

        return view('voiture',['voitureData'=>$voitureData,'assurance'=>$datas1,"consommation"=>$datas2,"entretiens"=>$datas3,"reparations"=>$datas4,"nbData"=>$nbData]);
    }
    public function addEntretien(Request $request){
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
        $ValueDB = DB::table('entretiens')
            ->where('typeEnt',$validation['typeEnt'])
            ->where('id_voiture',$validation['id_voiture'])
            ->where('dateEnt',$validation['dateEnt'])
            ->where('garageEnt',$validation['garageEnt'])
            ->where('noteEnt',$note)
            ->get();

        return $ValueDB;
    }
    public function addReparation(Request $request){
        $validation = $request->validate([
            "typeRep" => "required",
            "dateRep" => "required",
            "montantRep" => "required",
            "garageRep" => "required",
            "id_voiture" => "required"
        ]);

        $note = (isset($request->noteRep)) ? $request->noteRep : null;
        DB::table('reparations')->insert([
            "typeRep" => $validation['typeRep'],
            "id_voiture" => $validation['id_voiture'],
            "dateRep" => $validation['dateRep'],
            "montantRep" => $validation['montantRep'],
            "garageRep" => $validation['garageRep'],
            "noteRep" => $note
        ]);
        $ValueDB = DB::table('reparations')
            ->where('typeRep',$validation['typeRep'])
            ->where('id_voiture',$validation['id_voiture'])
            ->where('dateRep',$validation['dateRep'])
            ->where('garageRep',$validation['garageRep'])
            ->where('noteRep',$note)
            ->get();
        return $ValueDB;
    }
    public function addAssurance(Request $request){
        $validation = $request->validate([
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
        $ValueDB = DB::table('assurance')
            ->where('nomAssu',$validation['nomAssu'])
            ->where('id_voiture',$validation['id_voiture'])
            ->where('debutAssu',$validation['debutAssu'])
            ->where('finAssu',$validation['finAssu'])
            ->where('frais',$validation['frais'])
            ->get();
        return $ValueDB;
    }
    public function addConsommation(Request $request){
        $validation = $request->validate([
            "litre" => "required",
            "montantCons" => "required",
            "id_voiture" => "required"
        ]);

        DB::table('consommation')->insert([
            "litre" => $validation['litre'],
            "montantCons" => $validation['montantCons'],
            "id_voiture" => $validation['id_voiture'],
        ]);
        $ValueDB = DB::table('consommation')
            ->where('litre',$validation['litre'])
            ->where('id_voiture',$validation['id_voiture'])
            ->where('montantCons',$validation['montantCons'])
            ->get();
        return $ValueDB;
    }
}

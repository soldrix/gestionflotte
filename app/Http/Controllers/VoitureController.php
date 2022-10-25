<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoitureController extends Controller
{
    public function charge(Request $request){
        $user_type = Auth::user()->type;
        $id = (isset($request->id)) ? $request->id : null ;
        $voitureData = DB::select("select * from voiture where id='$id'");
        if ($user_type === 'admin'){
            $datas1 = DB::select("select * from assurance where id_voiture='$id'");
            $datas2 = DB::select("select * from consommation where id_voiture='$id'");
            $datas3 = DB::select("select * from entretiens where id_voiture='$id'");
            $datas4 = DB::select("select * from reparations where id_voiture='$id'");
            $json = new \stdClass();
            $json->nbAssu  = count($datas1);
            $json->nbCons  = count($datas2);
            $json->nbEnt  = count($datas3);
            $json->nbRep  = count($datas4);
        }
        return ($user_type !== 'admin') ? view('voiture',['voitureData'=>$voitureData]) : view('voiture',['voitureData'=>$voitureData,'assurance'=>$datas1,"consommation"=>$datas2,"entretiens"=>$datas3,"reparations"=>$datas4,'nbData'=>$json]);
    }
    public function getVoiture(Request $request){
        $id = $request->id;
        $data =  DB::select("SELECT * from voiture where id='$id'");
        return json_encode($data);
    }

    public function updateDatas(Request $request){

        $validation = $request->validate([
            'marque' => 'required',
            'model'=>'required',
            'circulation' => 'required',
            'carburant' => 'required',
            'immatriculation' => 'required',
            'status' => 'required',
            'puissance' => 'required'
        ]);
        $id = $request->id;
        DB::table('voiture')->where('id',$id)->update([
            "marque" => $validation['marque'],
            "model" => $validation['model'],
            "circulation" => $validation['circulation'],
            "immatriculation" => $validation['immatriculation'],
            "statut" => $validation['status'],
            "carburant" => $validation['carburant'],
            "puissance" => $validation['puissance'],
        ]);
        if($request->file('file') !== null){
            $file = $request->file('file');
            // Generate a file name with extension
            $fileName = 'voiture-'.time().'.'.$file->getClientOriginalExtension();

            // Save the file
            $file->storeAs('/public/upload', $fileName);
            $path = "upload/".$fileName;
            Db::table('voiture')->where('id', $id)->update(['image' => $path]);
        }
        $datasVoiture = $this->getVoiture($request);
        return $datasVoiture;
    }
}

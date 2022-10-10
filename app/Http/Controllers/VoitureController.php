<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $entretiens = new EntretiensController();
        $validation = $entretiens->insertDatas($request);
        $ValueDB = DB::table('entretiens')
            ->where('typeEnt',$validation['typeEnt'])
            ->where('id_voiture',$validation['id_voiture'])
            ->where('dateEnt',$validation['dateEnt'])
            ->where('garageEnt',$validation['garageEnt'])
            ->where('noteEnt',$validation['noteEnt'])
            ->get();
        return $ValueDB;
    }
    public function addReparation(Request $request){
        $reparation = new ReparationsController();
        $validation = $reparation->insertDatas($request);
        $ValueDB = DB::table('reparations')
            ->where('typeRep',$validation['typeRep'])
            ->where('id_voiture',$validation['id_voiture'])
            ->where('dateRep',$validation['dateRep'])
            ->where('garageRep',$validation['garageRep'])
            ->where('noteRep',$validation['noteRep'])
            ->get();
        return $ValueDB;
    }
    public function addAssurance(Request $request){
        $AssuranceController = new AssuranceController();
        $validation = $AssuranceController->insertDatas($request);
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
        $consommation = new ConsommationController();
        $validation = $consommation->insertData($request);
        $ValueDB = DB::table('consommation')
            ->where('litre',$validation['litre'])
            ->where('id_voiture',$validation['id_voiture'])
            ->where('montantCons',$validation['montantCons'])
            ->get();
        return $ValueDB;
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
    public function uploadImage(Request $request){

            $file = $request->file('file');
            $id = json_decode($request->id);
            // Generate a file name with extension
            $fileName = 'voiture-'.time().'.'.$file->getClientOriginalExtension();

            // Save the file
            $file->storeAs('/public/upload', $fileName);
            $path = "upload/".$fileName;
            DB::update("update voiture set image='$path' where id='$id'");
            $json = new \stdClass();
            $json->id = $id;
            $json->image = $path;

        return json_encode($json);
    }
}

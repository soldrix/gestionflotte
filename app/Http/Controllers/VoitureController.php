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
            foreach ($voitureData as $datas){
                if ($datas->id_agence !== '' && $datas->id_agence !== null){
                    $voitureData = DB::table('voiture')->select('voiture.*','agence.ville','agence.rue')
                        ->join('agence', 'agence.id', '=', 'voiture.id_agence')
                        ->where([
                            'voiture.id' => $request->id
                        ])->get();
                }else{
                    $voitureData = DB::select("select * from voiture where id='$id'");
                    $voitureData[0]->ville = '';
                    $voitureData[0]->rue = 'Aucune agence';
                }
            }
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
        return ($user_type !== 'admin') ?
            view('voiture',['voitureData'=>$voitureData]) :
            view('voiture',[
                'voitureData'=>$voitureData,
                'assurance'=>$datas1,"consommation"=>$datas2,"entretiens"=>$datas3,"reparations"=>$datas4,'nbData'=>$json]);
    }
    public function getVoiture(Request $request){
        $id = $request->id;
        $id_agence = strval($request->id_agence);
            if ($id_agence !== '' && $id_agence !== 'null'){
                $voitureData = DB::table('voiture')->select('voiture.*','agence.ville','agence.rue')
                    ->join('agence', 'agence.id', '=', 'voiture.id_agence')
                    ->where([
                        'voiture.id' => $request->id
                    ])->get();
            }else{
                $voitureData = DB::select("select * from voiture where id='$id'");
                $voitureData[0]->ville = '';
                $voitureData[0]->rue = 'Aucune agence';
            }
        return $voitureData;
    }

    public function updateDatas(Request $request){

        $validation = $request->validate([
            'marque' => 'required',
            'model'=>'required',
            'circulation' => 'required',
            'carburant' => 'required',
            'immatriculation' => 'required',
            'status' => 'required',
            'puissance' => 'required',
            'typeVoiture' => 'required',
            'nbPlace' => 'required',
            'nbPorte' => 'required',
            'id_agence' => 'required',
            'prix' => 'required'
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
            'type' => $validation['typeVoiture'],
            'nbPlace' => $validation['nbPlace'],
            'nbPorte' => $validation['nbPorte'],
            'prix' => $validation['prix'],
            'id_agence' => ($validation['id_agence'] === 'null') ? null :  $validation['id_agence']
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
    public function loadVoiture(){
        return json_encode(DB::select('select * from voiture'));
    }
}

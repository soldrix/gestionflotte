<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $voiture = DB::select('select * from voiture');
        return view('home',['voiture'=>$voiture]);
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');
        // Generate a file name with extension
        $fileName = 'voiture-'.time().'.'.$file->getClientOriginalExtension();

        // Save the file
        $file->storeAs('/public/upload', $fileName);
        $path = "upload/".$fileName;
        return $path;
    }
    public function createVoitureForm(Request $request) {
        return view('addVoiture');
    }
    public function VoitureForm(Request $request) {

        // Form validation
        $validation = $request->validate([
            'marque' => 'required',
            'model'=>'required',
            'circulation' => 'required',
            'carburant' => 'required',
            'immatriculation' => 'required',
            'status' => 'required',
            'puissance' => 'required',
            'file' => 'required',
        ]);

        $file = $request->file('file');
        // Generate a file name with extension
        $fileName = 'voiture-'.time().'.'.$file->getClientOriginalExtension();

        // Save the file
        $file->storeAs('/public/upload', $fileName);
        $path = "upload/".$fileName;

        DB::table('voiture')->insert([
            "image" => $path,
            "marque" => $validation['marque'],
            "model" => $validation['model'],
            "circulation" => $validation['circulation'],
            "immatriculation" => $validation['immatriculation'],
            "statut" => $validation['status'],
            "carburant" => $validation['carburant'],
            "puissance" => $validation['puissance'],
        ]);


        if (isset($request->typeEnt)){
            $validation = $request->validate([
                "typeEnt" => "required",
                "dateEnt" => "required",
                "montantEnt" => "required",
                "garageEnt" => "required",
            ]);
            $note = (isset($request->noteEnt)) ? $request->noteEnt : "";
            DB::table('entretiens')->insert([
                "typeEnt" => $validation['typeEnt'],
                "id_voiture" => $voitureID,
                "dateEnt" => $validation['dateEnt'],
                "montantEnt" => $validation['montantEnt'],
                "garageEnt" => $validation['garageEnt'],
                "noteEnt" => $note,
            ]);
        }
        if (isset($request->typeRep)){
            $validation = $request->validate([
                "typeRep" => "required",
                "dateRep" => "required",
                "montantRep" => "required",
                "garageRep" => "required",
            ]);
            $note = (isset($request->noteRep)) ? $request->noteRep : "";
            DB::table('entretiens')->insert([
                "typeRep" => $validation['typeEnt'],
                "id_voiture" => $voitureID,
                "dateRep" => $validation['dateEnt'],
                "montantRep" => $validation['montantEnt'],
                "garageRep" => $validation['garageEnt'],
                "noteRep" => $note,
            ]);
        }
        if (isset($request->montantCons)){
            $validation = $request->validate([
                "montantCons" => "required",
                "litre" => "required",
            ]);
            DB::table('entretiens')->insert([
                "montantCons" => $validation['montantCons'],
                "id_voiture" => $voitureID,
                "litre" => $validation['litre'],
            ]);
        }
        $voiture = DB::select('select * from voiture');
        return json_encode($voiture);
  }
}

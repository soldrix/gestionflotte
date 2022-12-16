<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Util\Json;

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

    public function verifDatas($datas){
        $validation = $datas->validate([
            'marque' => 'required',
            'model'=>'required',
            'circulation' => 'required',
            'carburant' => 'required',
            'immatriculation' => 'required',
            'status' => 'required',
            'puissance' => 'required',
            'file' => 'required',
            'prix' => 'required',
            'nbPorte' => 'required',
            'nbPlace' => 'required',
            'id_agence' => 'required',
            'typeVoiture' => 'required'
        ]);
        $file = $datas->file('file');
        // Generate a file name with extension
        $fileName = 'voiture-'.time().'.'.$file->getClientOriginalExtension();
        // Save the file
//        $file->storeAs('/public/upload', $fileName);
        Storage::disk('public')->put('/upload/' . $fileName, File::get($file));
        $path = "upload/".$fileName;
        $tab =[
            "marque" => $validation['marque'],
            "model" => $validation['model'],
            "circulation" => $validation['circulation'],
            "immatriculation" => $validation['immatriculation'],
            "statut" => $validation['status'],
            "carburant" => $validation['carburant'],
            "puissance" => $validation['puissance'],
            'nbPorte' => $validation['nbPorte'],
            'type' => $validation['typeVoiture'],
            'image' => $path,
            'nbPlace' => $validation['nbPlace'],
            'prix' => $validation['prix'],
            'id_agence' => ($validation['id_agence'] !== "null") ?  $validation['id_agence'] : null
        ];
        return $tab;
    }
    public function insertData(Request $request){
         DB::table('voiture')->insert($this->verifDatas($request));
        return DB::table('voiture')->select()->where($this->verifDatas($request))->get();
    }
    public function index()
    {
        $voiture = DB::select('select * from voiture');
        return view('home',(Auth::user()->type !== 'admin') ? ['voiture'=>$voiture,'agence'=>DB::select('SELECT * from agence') ,'type'=> DB::select('SELECT distinct type from voiture'),'nbVoiture'=>count($voiture)] : ['voiture'=>$voiture]);
    }
    public function deleteVoiture(Request $request):void{
        $id = $request->id;
        $car =  DB::table('voiture')->where('id',$id)->get();
        foreach ($car as $datas){
            if(Storage::disk('public')->exists($datas->image)){
                Storage::disk('public')->delete($datas->image);
            }else{
                error_log($datas->image);
            }
        }
        DB::delete("DELETE FROM `voiture` WHERE id='$id'");
    }

}

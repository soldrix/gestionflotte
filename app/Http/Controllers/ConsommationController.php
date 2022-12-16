<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsommationController extends Controller
{
    public function insertData(Request $request){
        if (Auth::check()){
            $validation = $request->validate([
                "litre" => "required",
                "montantCons" => "required",
                "id_voiture" => "required"
            ]);
            $tab =[
                "litre" => $validation['litre'],
                "montantCons" => $validation['montantCons'],
                "id_voiture" => $validation['id_voiture'],
            ];
            DB::table('consommation')->insert($tab);
            return DB::table('consommation')->select('consommation.*','immatriculation')->join('voiture' , 'consommation.id_voiture', '=','voiture.id')->where($tab)->get();
        }
        return redirect('/login');
    }
    public function updateDatas(Request $request){
        if (Auth::check()){
            $validation = $request->validate([
                "litre" => "required",
                "montantCons" => "required"
            ]);
            $id = $request->id;
            DB::table('consommation')->where('id',$id)->update([
                "litre" => $validation['litre'],
                "montantCons" => $validation['montantCons']
            ]);
            return DB::table('consommation')->select('consommation.*','immatriculation')->join('voiture' , 'consommation.id_voiture', '=','voiture.id')->where('consommation.id',$id)->get();
        }
        return redirect('/login');
    }
    public function charge(){
        if (Auth::check()){
            $user_type = Auth::user()->type;
            if ($user_type === 'admin'){
                $voiture = DB::select('select * from voiture');
                $consommation = DB::select('SELECT consommation.*,voiture.immatriculation FROM `consommation` INNER JOIN voiture ON voiture.id = consommation.id_voiture ');
            }
            return ($user_type !== 'admin') ? redirect('/home') : view('/consommation',['voiture'=>$voiture,'consommation'=>$consommation]);
        }
        return redirect('/login');
    }
    public function delete(Request $request) : void{
        if (Auth::check()){
            $row = $request->id;
            DB::delete("DELETE FROM `consommation` WHERE id='$row'");
        }else{
            redirect('/login');
        }
    }
    public function getConsommation(Request $request){
        if (Auth::check()){
            $id = $request->id;
            $data =  DB::select("SELECT * from consommation where id='$id'");
            return json_encode($data);
        }
        return redirect('/login');
    }
}

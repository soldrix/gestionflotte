<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AssuranceController extends Controller
{
    public function insertDatas(Request $request){
        if (Auth::check()){
            $validation = $request->validate([
                "id_voiture" => "required",
                "nomAssu" => "required",
                "debutAssu" => "required",
                "finAssu" => "required",
                "frais" => "required",
            ]);
            $tab = [
                "nomAssu" => $validation['nomAssu'],
                "id_voiture" => $validation['id_voiture'],
                "debutAssu" => $validation['debutAssu'],
                "finAssu" => $validation['finAssu'],
                "frais" => $validation['frais'],
            ];
            DB::table('assurance')->insert($tab);
            return DB::table('assurance')->select('assurance.*','immatriculation')->join('voiture' , 'assurance.id_voiture', '=','voiture.id')->where($tab)->get();
        }
        return redirect('/login');
    }
    public function updateDatas(Request $request){
        if (Auth::check()){
            $validation = $request->validate([
                "nomAssu" => "required",
                "debutAssu" => "required",
                "finAssu" => "required",
                "frais" => "required",
            ]);
            $id = $request->id;
            DB::table('assurance')->where('id',$id)->update([
                "nomAssu" => $validation['nomAssu'],
                "debutAssu" => $validation['debutAssu'],
                "finAssu" => $validation['finAssu'],
                "frais" => $validation['frais'],
            ]);
            return DB::table('assurance')->select('assurance.*','immatriculation')->join('voiture' , 'assurance.id_voiture', '=','voiture.id')->where('assurance.id',$id)->get();
        }
        return redirect('/login');
    }
    public function charge(){
        if(Auth::check()){
            $user_type = Auth::user()->type;
            if($user_type === 'admin'){
                $voiture = DB::select('select * from voiture');
                $assurance = DB::select('SELECT assurance.*,voiture.immatriculation FROM `assurance` INNER JOIN voiture ON voiture.id = assurance.id_voiture ');
            }
            return ($user_type !== 'admin') ? redirect('/home') : view('/assurance',['voiture'=>$voiture,'assurance'=>$assurance]);
        }
        return redirect('/login');
    }

    public function deleteAssurance(Request $request) : void{
        if (Auth::check()){
            $row = $request->id;
            DB::delete("DELETE FROM `assurance` WHERE id='$row'");
        }else{
            redirect('/login');
        }
    }
    public function getAssurance(Request $request){
        if (Auth::check()){
            $id = $request->id;
            $data =  DB::select("SELECT * from assurance where id='$id'");
            return json_encode($data);
        }
        return redirect('/login');
    }
}

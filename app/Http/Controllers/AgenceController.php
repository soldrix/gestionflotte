<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgenceController extends Controller
{
    public function insertDatas(Request $request){
        if (Auth::check()){
            $validation = $request->validate([
                "ville" => "required",
                "rue" => "required"
            ]);
            $tab = [
                "ville" => $validation['ville'],
                "rue" => $validation['rue']
            ];
            DB::table('agence')->insert($tab);
            return DB::table('agence')->select('*')->where($tab)->get();
        }
        return redirect('/login');
    }
    public function updateDatas(Request $request){
        if (Auth::check()){
            $validation = $request->validate([
                "ville" => "required",
                "rue" => "required"
            ]);
            $id = $request->id;
            DB::table('agence')->where('id',$id)->update([
                "ville" => $validation['ville'],
                "rue" => $validation['rue']
            ]);
            return DB::table('agence')->select('*')->where('id',$id)->get();
        }
        return redirect('/login');
    }
    public function loadAgence(){
        if (Auth::check()){
            return json_encode(DB::select('select * from agence'));
        }
        return redirect('/login');
    }
    public function charge(){
        if (Auth::check()){
            $user_type = Auth::user()->type;
            if($user_type === 'admin'){
                $agence = DB::select('select * from agence');
            }
            return ($user_type !== 'admin') ? redirect('/home') : view('/agence',['agence'=>$agence]);
        }
        return redirect('/login');
    }

    public function delete(Request $request) : void{
        if (Auth::check()){
            $row = $request->id;
            DB::delete("DELETE FROM `agence` WHERE id='$row'");
        }else{
          redirect('/login');
        }
    }
    public function getAgence(Request $request){
        if (Auth::check()){
            $id = $request->id;
            $data =  DB::select("SELECT * from agence where id='$id'");
            return json_encode($data);
        }
        return redirect('/login');
    }
    public function getAgenceSearch(Request $request){
        if (Auth::check()){
            $research = '%'.$request->search.'%';
            $agence =  DB::table('agence')->where('ville','like',$research)
                ->orWhere('rue','like',$research)
                ->get();
            return ((count($agence) >= 1 ) ? $agence : json_encode(null));
        }
        return redirect('/login');
    }
}

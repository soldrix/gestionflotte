<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgenceController extends Controller
{
    public function insertDatas(Request $request){
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
    public function updateDatas(Request $request){
        $validation = $request->validate([
            "ville" => "required",
            "rue" => "required"
        ]);
        $id = $request->id;
        DB::table('assurance')->where('id',$id)->update([
            "ville" => $validation['ville'],
            "rue" => $validation['rue']
        ]);
        return DB::table('agence')->select('*')->where('id',$id)->get();
    }
    public function loadAgence(){
        return json_encode(DB::select('select * from agence'));
    }
    public function charge(){
        $user_type = Auth::user()->type;
        if($user_type === 'admin'){
            $agence = DB::select('select * from agence');
        }
        return ($user_type !== 'admin') ? redirect('/home') : view('/agence',['agence'=>$agence]);
    }

    public function delete(Request $request) : void{
        $row = $request->id;
        DB::delete("DELETE FROM `agence` WHERE id='$row'");
    }
    public function getAssurance(Request $request){
        $id = $request->id;
        $data =  DB::select("SELECT * from agence where id='$id'");
        return json_encode($data);
    }
}

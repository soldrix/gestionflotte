<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function updateEmail(Request $request){
        //validation rules
        $validation = Validator::make($request->all(),[
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
        ],
        [
            'email.unique' => 'L\'email est déjà utiliser.',
            'email.required' => 'L\':attribute ne peut pas être vide.',
            'password.required' => 'Le mot de passe ne peut pas être vide.'
        ]);
        if(!Hash::check($request->password, Auth::user()->getAuthPassword()) && isset($request->password)){
            $validation->errors()->add('password','Mot de passe incorrect');
            throw new ValidationException($validation);
        }
        $validation->validate();
        if($validation->fails()){
            return $validation->errors();
        }else{
            $user =Auth::user();
            $user->email = $request->email;
            $user->save();
            return 'L\'email a été modifié.';
        }
    }
    public function updateName(Request $request){
        //validation rules
        $validation = Validator::make($request->all(),[
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
        ],
        [
            'name.required' => 'Le prenom ne peut pas être vide.',
            'password.required' => 'Le mot de passe ne peut pas être vide.'
        ]);
        if(!Hash::check($request->password, Auth::user()->getAuthPassword()) && isset($request->password)){
            $validation->errors()->add('password','Mot de passe incorrect');
            throw new ValidationException($validation);
        }
        $validation->validate();
        if($validation->fails()){
            return $validation->errors();
        }else{
            $user =Auth::user();
            $user->name = $request->name;
            $user->save();
            return 'Le prenom a été modifié.';
        }
    }
    public function updatePassword(Request $request){
        //validation rules
        $validation = Validator::make($request->all(),[
            'password' => ['required', 'string'],
            'newPassword' => ['required', 'string', "min:8"],
        ],
        [
            'required' => 'Le mot de passe ne peut pas être vide.',
            'min' => 'Le mot de pas doit contenir au moins 8 caractère.'
        ]);
        if (!Hash::check($request->password, Auth::user()->getAuthPassword())){
            $validation->errors()->add('password','Mot de passe incorrect');
            throw new ValidationException($validation);
        }
        $validation->validate();
        if($validation->fails()){
            return $validation->errors();
        }else{
            $user =Auth::user();
            $user->password = Hash::make($request->newPassword);
            $user->save();
            return 'Le mot de passe a été modifié.';
        }
    }
    public function delete(){
       $user = Auth::user();
        if($user === null){
            return redirect('/login');
        }else{
            $user->delete();
            return redirect('/login')->with('message','Le compte a été supprimer avec succès.');
        }
    }
    public function charge(){
        return view('/profil');
    }
}

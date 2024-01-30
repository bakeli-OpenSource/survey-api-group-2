<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Utilisateur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class Usercontroller extends Controller
{
    public function redirect()
    {
        $usertype=Auth::user()->usertype;
        if($usertype=='1')

        {
            return view('admin.home');
        }
    }


    public function getUsers() {
        $users = Utilisateur::all();
        return response($users, 200);
    }

    public function getUser($id) {
        $user = Utilisateur::find($id);
    
        if (!$user) {
            return response(['message' => "Aucun utilisateur trouvé avec l'ID $id"], 404);
        }
    
        return response($user, 200);
    }

    public function register(Request $request){
        $registerDonnee = $request->validate([
            "name"=> ["required","string", "min:2","max:255"],
            "email"=> ["required","email", "unique:utilisateurs","email"],
            "password"=> ["required"],
        ]);
        $registers = Utilisateur::create([
            "name"=> $registerDonnee["name"],
            "email"=> $registerDonnee["email"],
            "password"=>bcrypt($registerDonnee["password"])
        ]);
        return response($registers,201);
    }

    public function login(Request $request) {
        $registerDonnee = $request->validate([
            "email"=> ["required","email",],
            "password"=> ["required"],
        ]);
        $register = Utilisateur::where("email",$registerDonnee["email"])->first();
        if(!$register) {
            return response(['message'=>"Ancune utilisareur n'est trouver avec l'email suivant $registerDonnee[email]"],401);
        }
        if(!Hash::check($registerDonnee["password"],$register->password)) {
            return response(['message'=>"Ancune utilisareur trouver avec se mot de passe"],401);
        }
        $token = $register->createToken("CLE_SECRETE")->plainTextToken;
        return response([
            "register" => $register,
            "token" => $token
        ],200);
    // return response(['register'=>$register],200);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequestUser;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Sondage;
use App\Models\Utilisateur;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class Usercontroller extends Controller
{
    public function register(RegisterUserRequest $request)
    { 
        try 
        {
        $user = new Utilisateur();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password, [
        'round' => 12
        ]);
        $user->save();

        return response()->json([
            'status_code' => 200,
            'status_message' => "L'utilisateur a été bien ajouté",
            'user' => $user 
        ]);

    } catch (Exception $e) {
        return response()->json($e);
    }
}

// login

public function login(LoginRequestUser $request)
{
    if (Auth::guard('utilisateur')->attempt(['email' => $request['email'], 'password' => $request['password']])) {
        $user = Utilisateur::where('email', $request['email'])->firstOrFail();
        // $token = $user->createToken('MA_CLE_DE_SECURITE')->plainTextToken;

        return response()->json([
            'status_code' => 200,
            'status_message' => "Connexion réussie",
            'user' => $user,
            // 'token' => $token
        ]); 
    } else {
        return response()->json([
            'status_code' => 403,
            'status_message' => "informations de connexion incorrect"
        ]);
    }
    
}

public function index(Request $request)
    {
        try {
            $query = Utilisateur::query();
            $perPage = 2;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if ($search) {
                $query->whereRaw("email LIKE '%" . $search . "%'");
            }
            $total = $query->count();
            $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get(); 

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Liste des utilisateurs',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result
            ]);
            
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

}
    




 // public function redirect()
    // {
    //     $usertype=Auth::user()->usertype;
    //     if($usertype=='1')

    //     {
    //         return view('admin.home');
    //     }
    // }


    // public function getUsers() {
    //     $users = User::all();
    //     return response($users, 200);
    // }

    // public function getUser($id) {
    //     $user = User::find($id);
    
    //     if (!$user) {
    //         return response(['message' => "Aucun utilisateur trouvé avec l'ID $id"], 404);
    //     }
    
    //     return response($user, 200);
    // }

    // public function register(Request $request){
    //     $registerDonnee = $request->validate([
    //         "name"=> ["required","string", "min:2","max:255"],
    //         "email"=> ["required","email", "unique:users","email"],
    //         "password"=> ["required"],
    //     ]);
    //     $registers = User::create([
    //         "name"=> $registerDonnee["name"],
    //         "email"=> $registerDonnee["email"],
    //         "password"=>bcrypt($registerDonnee["password"])
    //     ]);
    //     return response($registers,201);
    // }


    // // register

    // public function login(LoginRequestUser $request) {
    //     $loginData = $request->validate([
    //         'email' => 'email|required',
    //         'password' => 'required'
    //     ]);
    
    //     if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
    //         $user = auth()->user();
    //         $token = $user->createToken('authToken')->plainTextToken;
     
    //      return response()->json([
    //         'user' => $user,
    //         'access_token' => $token]);
    //     }else {
    //         return response()->json(['message' => 'Invalid Credentials']);

    //     }

         
    // }
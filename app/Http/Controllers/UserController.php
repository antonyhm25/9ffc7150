<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index()
    {
        $genders = User::all();
        return response()->json([
            'message' => 'OK',
            'data' => $genders,
        ],200);
    }

    public function login(Request $request)
    {
        $rules = array(
            'username' => 'required|email',
            'password_laravel' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $validator->errors();
        }
        
        $user = User::where('username',$request->username)->get()->first();
    
        if ($user && Hash::check($request->password_laravel, $user->password_laravel)) {
            $token = $user->createToken('Laravel')->accessToken;
            return response()->json([
                'res' => true,
                'token' => $token,
                'message' => 'Bienvenido al sistema',
            ], 200);
        } else {
            return response()->json([
                'res' => false,
                'message' => 'Email o password incorrecto',
            ], 400);
        }
    }

    public function logout()
    {
        //Obtenemos usuario logeado
        $user = Auth::user();
        //Busca todos los token del usuario en la base de datos y los eliminamos;
        $user->tokens->each(function($token){
           $token->delete();
        });
        return response()->json([
            'res' => true,
            'message'=> 'Bye',
        ],200);
    }

}

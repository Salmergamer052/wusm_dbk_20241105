<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request) {
        $validatedData = $request->validate(rules: [
        'name'=>['required','string','max:255'],
        'email'=>['required','string','email','max:255','unique:users'],
        'password'=>['required','string','min:8','max:20'],
        ]);

        $user = User::create(attributes:[
            'name'=> $validatedData['name'],
            'email'=> $validatedData['email'],
            'password'=> Hash::make(value: $validatedData['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(data: [
            "success"=> true,
            "errors"=>[
                "code"=>0,
                "msg"=>""
            ],
            "data"=>[
                "access_token"=>$token,
                "token_type" => "Bearer"
            ],
            "msg"=>"Usuario creado satisfactoriamente",
            "count"=>1
        ]);
    }

    public function Login(Request $request) {
        if(!Auth::attempt($request->only("email", "password"))){
            return response()->json([
                "success"=> false,
                "error"=>[
                    "code"=>401,
                    "msd"=> "No se reconocen las credenciales"
                ],
                "data"=>"",
                "count"=> 0
                

            ], 401);
        }
        $user = User::where("email", $request->email)->firstOrFail();
        $token = $user->createToken("auth_token")->plainTextToken;

        return response()->json([
            "success"=> false,
            "error"=>[
                "code"=>200,
                "msd"=> "No se reconocen las credenciales"
            ],
            "data"=>"",
            "count"=> 0
            

        ], 200);
    }

    public function me(Request $request){
        return response()->json([
            "success"=> true,
                 "error"=>[
                    "code"=>200,
                    "msg"=> ""
                 ],
                 "data"=>$request_>user(),
                 "count"=> 1
                ], 200);
    }

}
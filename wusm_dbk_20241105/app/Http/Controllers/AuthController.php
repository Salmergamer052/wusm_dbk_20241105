<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register(Request $request): void{
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

}
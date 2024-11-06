<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function register(Request $request) {
        $validate = $request->validate(rules: [
            'name'=>['required', 'string','max:255'],
            'email'=>['required','string','email','max:255','unique:users'],
            'password'=>['required', 'string','min:8','max:20'],

        ]);

        $user = User::create(Attributes:[
            'name'=> $validatedData['name'],
            'email'=> $validatedData['email'],
            'password'=> Hash::make(value: $validatedData['password']),

        ])
    }
}

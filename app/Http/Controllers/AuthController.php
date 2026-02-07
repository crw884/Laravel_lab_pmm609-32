<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();
        if(!$user){
            return response(['message' => 'Email не найден.'], 401);
        }

        if (!Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Неверный пароль'], 401);
        }

        $token = $user->createToken('sc-token')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response([
            'message' => 'Logged out'
            // я не знаю нужно ли чтобы ответы APIшки были на русском вообще,
            // пока пусть так будет
        ]);
    }
}

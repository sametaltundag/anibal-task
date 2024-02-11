<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Giriş yapma
    public function login(LoginRequest $request){

        // Doğrulama sorgusu true/false
        $check = $request->validated();
        if(!$check){
            return response()->json(['errors' => $check], 422);
        }

        // Kullanıcı sorgusu
        $user = User::where('email', $check['email'])->first();

        //Giriş kontrolü
        if(!$user || !Hash::check($check['password'], $user->password)){
            return response([
                'message' => 'Kullanıcı adı veya şifre hatalı!'
            ], 401);
        }

        // Doğrulama sonrası token oluşturma
        $token = $user->createToken('blogtoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        // Token ve kullanıcı bilgilerini geri döndürür
        return response($response, 201);
    }




    // Kayıt oluşturma
    public function register(RegisterRequest $request){

        // Gelen isteğin gereklilik kontrolü
        $check = $request->validated();
        if(!$check){
            return response()->json(['errors' => $check], 422);
        }


        // Kullanıcı oluşturma
        $user = User::create([
            'name' => $check['name'],
            'email' => $check['email'],
            'password' => Hash::make($check['password'])
        ]);

        $token = $user->createToken('blogtoken')->plainTextToken;

        // Doğrulama sonrası token ve kullanıcı bilgilerini oluşturma
        $response = [
            'user' => $user,
            'token' => $token
        ];

        // Token ve kullanıcı bilgilerini geri döndürme
        return response($response, 201);
    }



    // Çıkış Yapma
    public function logout(Request $request){
        Auth::logout();
        return response()->json([
            'message' => 'Cikis yapildi'
        ]);
    }
}

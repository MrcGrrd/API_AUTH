<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        return User::create([
            'USER_CODE' => $request->input('UserCode'),
            'USER_NAME' => $request->input('UserName'),
            'PASSWORD' => Hash::make($request->input('password')),
            'USER_TYPE' => $request->input('UserType'),
            'EMAIL_ADD' => $request->input('Email')
        ]);
    }

    public function login(Request $request)
    {  
        
         $user = User::where('USER_CODE', $request->UserCode)->first();

        if ($user && Hash::check($request->password, $user->PASSWORD)) {
            Auth::login($user);

         $user = Auth::user();

         $token = $user->createToken('token')->plainTextToken;

         $cookie = cookie('jwt', $token, 68 * 24);

         DB::insert('update users set token = ? where USER_CODE = ?', [$token, $request->UserCode]);

          return response([
              'message' => $token
          ])->withCookie($cookie);

        }
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Success'
        ])->withCookie($cookie);
    }
}

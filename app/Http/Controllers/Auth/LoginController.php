<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class LoginController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if($validator->fails() || !$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'Invalid data!'
            ], 400);
        }

        $token = $user->createToken('mytoken')->plainTextToken;

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ],
            'token' => $token
        ], 200);
    }
}

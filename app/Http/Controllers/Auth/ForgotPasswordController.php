<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

class ForgotPasswordController extends Controller
{
    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if($validator->fails() || !$user){
            return response()->json([
                'message' => 'Dados inválidos ou email não existe em nosso sistema!'
            ], 400);
        }

        return response()->json([
            'message' => "Link para redefinição de senha foi enviada para $user->email"
        ], 200);
    }
}

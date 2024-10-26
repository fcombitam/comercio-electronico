<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function getToken(Request $request)
    {
        $validator = validator($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 403,
                'message' => 'Informacion Invalida',
                'errors' => $validator->errors()
            ], 403);
        }

        if (!Auth::attempt($request->only('email', 'password')) || !User::where('email', $request->email)->first()) {
            return response()->json([
                'code' => '403',
                'message' => 'Informacion Invalida'
            ], 403);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        if (User::TYPE_ADMIN != $user->type) {
            return response()->json([
                'code' => 403,
                'message' => 'No tienes permisos para acceder a esta información'
            ], 403);
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth-token', ['admin-logged']);

        return response()->json([
            'code' => '200',
            'message' => 'Informacion Correcta, No olvides usar este bearer token para autenticarte en las demas rutas Api,DESARROLLADO CON LARAVEL SANCTUM',
            'accessToken' => $token->plainTextToken,
            'token_type' => 'Bearer'
        ], 200);
    }
}

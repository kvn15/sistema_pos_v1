<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    // Login
    public function login(LoginRequest $request) {

        $credencials = $request->only('user', 'password');

        try {
            if (!$token = auth()->attempt(["user" => $request->user, "password" => $request->password, "state" => 1])) {
                return response()->json([
                    'message' => 'Credenciales Incorrectas o Usuario de Baja'
                ], 200);
            }
        } catch (JWTException $e) {
            return response()->json([
                'message' => 'No se creo el Token'
            ], 500);
        }

        $user = auth()->user();

        return response()->json([
            'message' => 'Bienvenido, '.$user->name,
            'token_acceso' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => [
                "id" => $user->id,
                "name" => $user->name,
                "user" => $user->user,
                "email" => $user->email,
                "file_foto" => $user->file_foto ?? '',
                "role_id" => $user->role_id,
                "role_name" => $user->role->rol_name
            ]
        ], 200);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Sesión Cerrada']);
    }

}

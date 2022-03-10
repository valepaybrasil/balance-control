<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends Controller
{

    public function login(Request $request)
    {
        $credenciais = request(['api_token', 'access_token']);
        $usuario = null;
        if ($credenciais) {
            $usuario = User::where('api_token', $credenciais['api_token'])
                           ->where('access_token', $credenciais['access_token'])
                           ->first();
        }

        if (!$usuario) {
            $response = ['error' => 'Nao autorizado!'];
            return response()->json($response, 401);
        }

        $response['name'] = $usuario->name;
        $response['email'] = $usuario->email;
        $response['token'] = $usuario->createToken('token')->accessToken;

        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
    }
}

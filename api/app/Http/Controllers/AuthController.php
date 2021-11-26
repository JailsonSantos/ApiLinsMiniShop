<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Autenticação e Validação
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

// Model
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['create', 'login', 'unauthorized']]);
    }

    public function create(Request $request)
    {
        $array = ['error' => ''];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!$validator->fails()) {


            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            $emailExists = User::where('email', $email)->count();

            if ($emailExists === 0) {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $newUser = new User();

                $newUser->name = $name;
                $newUser->email = $email;
                $newUser->password = $hash;
                $newUser->save();

                //Fazer login Auth::attempt()
                $token = Auth::attempt([
                    'email' => $email,
                    'password' => $password
                ]);

                if (!$token) {
                    $array['error'] = 'Ocorreu um erro!';
                    return $array;
                }

                $info = Auth::user();
                $info['avatar'] = url('media/avatars/' . $info['avatar']);
                $array['data'] = $info;
                $array['token'] = $token;
            } else {
                $array['error'] = 'E-mail já cadastrado.';
                return $array;
            }
        } else {
            $array['error'] = 'Dados incorretos.';
            return $array;
        }

        return $array;
    }

    public function login(Request $request)
    {
        $array = ['error' => ''];

        $email = $request->input('email');
        $password = $request->input('password');

        $token = Auth::attempt([
            'email' => $email,
            'password' => $password
        ]);

        if (!$token) {
            $array['error'] = 'Usuário e/o senha errados!';
            return $array;
        }

        $info = Auth::user();
        $info['avatar'] = url('media/avatars/' . $info['avatar']);
        $array['data'] = $info;
        $array['token'] = $token;

        return $array;
    }

    public function logout()
    {

        Auth::logout();

        return ['error' => ''];
    }

    // Gera um novo token
    public function refresh()
    {
        $array = ['error' => ''];

        $token = Auth::refresh();

        $info = Auth::user();
        $info['avatar'] = url('media/avatars/' . $info['avatar']);
        $array['data'] = $info;
        $array['token'] = $token;

        return $array;
    }

    // Função não autorizado
    public function unauthorized()
    {
        return response()->json([
            'error' => 'Não Autorizado',
        ], 401);
    }
}

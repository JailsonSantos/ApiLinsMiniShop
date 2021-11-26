<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Autenticação
use Illuminate\Support\Facades\Auth;

// Validador
use Illuminate\Support\Facades\Validator;

// Models
use App\Models\User;
use App\Models\UserFavorite;
use App\Models\UserAppointment;
use App\Models\Barber;
use App\Models\BarberServices;

// Validando Senhas
use Illuminate\Validation\Rules\Password;

// Biblioteca de images
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    private $loggedUser;

    // Verifica e o usuário está  logado, e captura as suas informações
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->loggedUser = Auth::user();
    }

    // Ler dados do Usuário
    public function read()
    {
        $array = ['error' => ''];

        $info = $this->loggedUser;
        $info['avatar'] = url('media/avatars/' . $info['avatar']);
        $array['data'] = $info;

        return $array;
    }

    // Adicionar favoritos
    public function toggleFavorite(Request $request)
    {
        $array = ['error' => ''];

        $id_barber = $request->input('barber');

        $barber = Barber::find($id_barber);

        if ($barber) {
            $fav = UserFavorite::select()
                ->where('id_user', $this->loggedUser->id)
                ->where('id_barber', $id_barber)
                ->first();

            if ($fav) {
                // Remover Barbeiro
                $fav->delete();
                $array['have'] = false;
            } else {
                // Adicionar Barbeiro
                $newFav = new UserFavorite();
                $newFav->id_user = $this->loggedUser->id;
                $newFav->id_barber = $id_barber;
                $newFav->save();
                $array['have'] = true;
            }
        } else {
            $array['error'] = 'Barbeiro inexistente!';
        }

        return $array;
    }

    // Seleção de todos Favoritos de um usuario logado
    public function getFavorites()
    {
        $array = ['error' => '', 'list' => []];

        $favs = UserFavorite::select()
            ->where('id_user', $this->loggedUser->id)
            ->get();

        if ($favs) {

            foreach ($favs as $fav) {

                $barber = Barber::find($fav['id_barber']);
                $barber['avatar'] = url('media/avatars/' . $barber['avatar']);
                $array['list'][] = $barber;
            }
        }

        return $array;
    }

    // Agendamentos do usuario
    public function getAppointments()
    {
        $array = ['error' => '', 'list' => []];

        $apps = UserAppointment::select()
            ->where('id_user', $this->loggedUser->id)
            ->orderBy('ap_datetime', 'DESC')
            ->get();

        if ($apps) {
            foreach ($apps as $app) {
                $barber = Barber::find($app['id_barber']);
                $barber['avatar'] = url('media/avatars/' . $barber['avatar']);

                $service = BarberServices::find($app['id_service']);

                $array['list'][] = [
                    'id' => $app['id'],
                    'dateTime' => $app['ap_datetime'],
                    'barber' => $barber,
                    'server' => $service

                ];
            }
        }

        return $array;
    }

    // Atualização de dados do usuário
    public function update(Request $request)
    {
        $array = ['error' => ''];

        $rules = [
            'name' => 'min:2',
            'email' => 'email|unique:users',
            'password' => ['required', 'confirmed', Password::min(4)],
            'password_confirmation'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $array['error'] = $validator->errors();
            return $array;
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');


        $user = User::find($this->loggedUser->id);

        if ($name) {
            $user->name = $name;
        }
        if ($email) {
            $user->email = $email;
        }
        if ($password) {
            $user->password = password_hash($password, PASSWORD_DEFAULT);
        }

        $user->save();

        return $array;
    }

    // Atualização de imagens
    public function updateAvatar(Request $request)
    {
        $array = ['error' => ''];

        $rules = [
            'avatar' => 'required|image|mimes:png,jpg,jpeg'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $array['error'] = $validator->errors();
            return $array;
        }

        $avatar = $request->file('avatar');
        $destino = public_path('/media/avatars');

        $avatarName = md5(time() . rand(0, 999)) . '.jpg';

        $img = Image::make($avatar->getRealPath());
        $img->fit(300, 300)->save($destino . '/' . $avatarName);

        $user = User::find($this->loggedUser->id);
        $user->avatar = $avatarName;
        $user->save();


        return $array;
    }
}

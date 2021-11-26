<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Autenticação
use Illuminate\Support\Facades\Auth;

// Models
use App\Models\User;
use App\Models\UserAppointment;
use App\Models\UserFavorite;

use App\Models\Barber;
use App\Models\BarberPhotos;
use App\Models\BarberServices;
use App\Models\BarberTestimonial;
use App\Models\BarberAvailability;

class BarberController extends Controller
{
    private $loggedUser;

    // Verifica e o usuário está  logado, e captura as suas informações
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->loggedUser = Auth::user();
    }

    /*   
        // Cria barbeiros aleatórios
    public function createRandom()
    {
        $array = ['error' => ''];

        for ($q = 0; $q < 15; $q++) {
            $names = ['Jailson', 'Langela', 'Missilene', 'Dina Ellem', 'Wilson', 'Nicolas', 'Nicleyton', 'João', 'José', 'Aldetina'];
            $lastnames = ['Santos', 'Lins', 'Barros', 'Braga', 'Silva', 'Nunes', 'Oliveira', 'Perreira', 'Santana', 'De Jesu'];

            $services1 = ['Corte', 'Pintura', 'Hidrataçao', 'Escova', 'Prancha', 'Depilação'];
            $services2 = ['Cabelo', 'Unhas', 'Pernas', 'Sobrancelhas', 'Buço'];

            $depos = [
                'Cheguei lá com o cabelo sem vida,sem corte e o Júlio renovou totalmente meu visual, super atencioso,',
                'o salão no geral muito bom, o assistente do Júlio que lava nosso cabelo também é ótimo!! Com certeza voltarei!!',
                'Gostaria de Parabenizar o Grand Salão pela excelente qualidade dos serviços e principalmente pelo atendimento que recebi. ',
                'Eu saí do salão realizada, meu cabelo ficou maravilhoso Apaixonada por tudo! - Voltarei e super indico!',
                'Aluguei o salão para me arrumar pro meu casamento, e posso dizer que tudo estava maravilhoso.',
                'O atendimento do pessoal do salão em especial foi excelente, me ajudou com tudo. em cada detalhe, demonstrando amor pelo que faz.'
            ];

            // Lat: -2.527747, Long: -44.254005 São Luís - MA 
            // Gerando os barreiros aleatórios
            $newBarber = new Barber();
            $newBarber->name = $names[rand(0, count($names) - 1)] . ' ' . $lastnames[rand(0, count($lastnames) - 1)];
            $newBarber->avatar = rand(1, 4) . '.png';
            $newBarber->stars = rand(2, 4) . '.' . rand(0, 9);
            $newBarber->latitude = '-2.5' . rand(0, 9) . '7747';
            $newBarber->longitude = '-44.2' . rand(0, 9) . '4005';
            $newBarber->save();

            $ns = rand(3, 6);
            for ($w = 0; $w < 4; $w++) {
                $newBarberPhoto = new BarberPhotos();
                $newBarberPhoto->id_barber = $newBarber->id;
                $newBarberPhoto->url = rand(1, 5) . '.png';
                $newBarberPhoto->save();
            }

            for ($w = 0; $w < $ns; $w++) {
                $newBarberService = new BarberServices();
                $newBarberService->id_barber = $newBarber->id;
                $newBarberService->name = $services1[rand(0, count($services1) - 1)] . ' de ' . $services2[rand(0, count($services2) - 1)];
                $newBarberService->price = rand(1, 99) . '.' . rand(0, 100);
                $newBarberService->save();
            }

            for ($w = 0; $w < 3; $w++) {
                $newBarberTestimonial = new BarberTestimonial();
                $newBarberTestimonial->id_barber = $newBarber->id;
                $newBarberTestimonial->name = $names[rand(0, count($names) - 1)] . ' ' . $lastnames[rand(0, count($lastnames) - 1)];
                $newBarberTestimonial->rate = rand(2, 4) . '.' . rand(0, 9);
                $newBarberTestimonial->body = $depos[rand(0, count($depos) - 1)];
                $newBarberTestimonial->save();
            }

            // Gerando disponibilidade diferntes de horaríos pra agendamentos
            for ($e = 0; $e < 4; $e++) {
                $rAdd = rand(7, 10);
                $hours = [];

                for ($r = 0; $r < 8; $r++) {
                    $time = $r + $rAdd;

                    if ($time < 10) {
                        $time = '0' . $time;
                    }
                    $hours[] = $time . ':00';
                }

                $newBarberAvailable = new BarberAvailability();
                $newBarberAvailable->id_barber = $newBarber->id;
                $newBarberAvailable->weekday = $e;
                $newBarberAvailable->hours = implode(',', $hours);
                $newBarberAvailable->save();
            }
        }

        return $array;
    } */

    // Função de busca de localização por latitude ou longitute, ou endereço (ex: sao luis)
    private function searchGeo($address)
    {
        $key = env('MAPS_KEY', null);

        $address = urlencode($address);

        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=' . $key;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        curl_close($ch);

        return json_decode($res, true);
    }

    // Lista todos os barbeiros com locaização de lat e long
    public function list(Request $request)
    {
        $array = ['error' => ''];

        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $city = $request->input('city');
        $offset = $request->input('offset');

        // Paginação
        if (!$offset) {
            $offset = 0;
        }


        if (!empty($city)) {
            $res = $this->searchGeo($city);

            if (count($res['results']) > 0) {
                $lat = $res['results'][0]['geometry']['location']['lat'];
                $lng = $res['results'][0]['geometry']['location']['lng'];
            }
        } elseif (!empty($lat) && !empty($lng)) {
            $res = $this->searchGeo($lat . ',' . $lng);

            if (count($res['results']) > 0) {
                $city = $res['results'][0]['formatted_address'];
            }
        } else {
            $lat = '-2.527713';
            $lgn = '-44.253956';
            $city = 'São Luis';
        }


        // Listar todos sem filtro e com filtro
        // $barbers = Barber::all();
        $barbers = Barber::select(Barber::raw('*, SQRT(
            POW(69.1 * (latitude - ' . $lat . '), 2) +
            POW(69.1 * (' . $lgn . '- longitude) * COS (latitude /57.3),2)) AS distance'))
            ->havingRaw('distance < ? ', [10])
            ->orderBy('distance', 'ASC')
            ->offset($offset)
            ->limit(5)
            ->get();

        // Alter o nome do avatar para a url completa do avatar
        foreach ($barbers as $bkey => $bvalue) {
            $barbers[$bkey]['avatar'] = url('media/avatars' . $barbers[$bkey]['avatar']);
        }

        $array['data'] = $barbers;
        $array['loc'] = 'São Luis';
        return $array;
    }

    // One Barber
    public function one($id)
    {
        $array = ['error' => ''];
        $barber = Barber::find($id);

        if ($barber) {
            $barber['avatar'] = url('media/avatars' . $barber['avatar']);
            $barber['favorited'] = false;
            $barber['photos'] = [];
            $barber['services'] = [];
            $barber['testimonials'] = [];
            $barber['available'] = [];

            // Verificando favorito
            $cFavorite = UserFavorite::where('id_user', $this->loggedUser->id)
                ->where('id_barber', $barber->id)
                ->count();

            if ($cFavorite > 0) {
                $barber['favorited'] = true;
            }

            // Pegando as fotos do Barbeiro
            $barber['photos'] = BarberPhotos::select(['id', 'url'])
                ->where('id_barber', $barber->id)
                ->get();
            foreach ($barber['photos'] as $bpkey => $bpvalue) {
                $barber['photos'][$bpkey]['url'] = url('media/uploads' . $barber['photos'][$bpkey]['url']);
            }

            // Pegando os serviços do Barbeiro
            $barber['services'] = BarberServices::select(['id', 'name', 'price'])
                ->where('id_barber', $barber->id)
                ->get();

            // Pegando os depoimentos do Barbeiro
            $barber['testimonials'] = BarberTestimonial::select(['id', 'name', 'rate', 'body'])
                ->where('id_barber', $barber->id)
                ->get();

            // Pegando a disponibilidade do Barbeiro
            // 2021-01-02 09:00
            // 2021-02-03 10:00
            $availability = [];

            // Pegando a disponibilidade captura
            $avails = BarberAvailability::where('id_barber', $barber->id)->get();
            $availWeekdays = [];

            foreach ($avails as $item) {
                $availWeekdays[$item['weekday']] = explode(',', $item['hours']);
            }

            // Pegar os agendamentos de hoje ate os próximos 20 dias
            $appointments = [];
            $appQuery = UserAppointment::where('id_barber', $barber->id)
                ->whereBetween('ap_datetime', [
                    date('Y-m-d') . ' 00:00:00',
                    date('Y-m-d', strtotime('+20 days')) . ' 23:59:59'
                ])
                ->get();

            // Formatando as datas
            foreach ($appQuery as $appItem) {
                $appointments[] = $appItem['ap_datetime'];
            }

            // Gerar disponibilidade real da semana
            for ($q = 0; $q < 20; $q++) {
                $timeItem = strtotime('+' . $q . ' days');
                $weekday = date('w', $timeItem);

                // Disponibilidade na semana
                if (in_array($weekday, array_keys($availWeekdays))) {
                    $hours = [];

                    $dayItem = date('Y-m-d', $timeItem);

                    foreach ($availWeekdays[$weekday] as $hourItem) {
                        $dayFormated = $dayItem . ' ' . $hourItem . ':00';

                        if (!in_array($dayFormated, $appointments)) {
                            $hours[] = $hourItem;
                        }
                    }

                    if (count($hours) > 0) {
                        $availability[] = [
                            'date' => $dayItem,
                            'hours' => $hours,
                        ];
                    }
                }
            }

            $barber['available'] = $availability;

            $array['data'] = $barber;
        } else {
            $array['error'] = 'Barbeiro não existe';
            return $array;
        }

        return $array;
    }

    // Agendar serviço com o barbeiro
    public function setAppointment($id, Request $request)
    {
        // services, year, month, day, hour
        $array = ['error' => ''];

        $service = $request->input('service');
        $year = intval($request->input('year'));
        $month = intval($request->input('month'));
        $day = intval($request->input('day'));
        $hour = intval($request->input('hour'));

        // Verificando se os valores são menores que 10
        $month = ($month < 10) ? '0' . $month : $month;
        $day = ($day < 10) ? '0' . $day : $day;
        $hour = ($hour < 10) ? '0' . $hour : $hour;

        // Lista de verificaçoes
        // 1 - Serviço existe
        $barberservice = BarberServices::select()
            ->where('id', $service)
            ->where('id_barber', $id)
            ->first();

        if ($barberservice) {
            // 2 - A data é real
            $apDate = $year . '-' . $month . '-' . $day . ' ' . $hour . ':00:00';
            if (strtotime($apDate) > 0) {
                // 3 - O barbeiro já possui agendamento no dia e hora
                $apps = UserAppointment::select()
                    ->where('id_barber', $id)
                    ->where('ap_datetime', $apDate)
                    ->count();

                if ($apps === 0) {
                    // 4.1 - O Barbeiro atenda na data solicitada pelo usuario
                    $weekday = date('w', strtotime($apDate));
                    $avail = BarberAvailability::select()
                        ->where('id_barber', $id)
                        ->where('weekday', $weekday)
                        ->first();

                    if ($avail) {
                        // 4.2 - O Barbeiro atenda na hora solicitada pelo usuario
                        $hours = explode(',', $avail['hours']);
                        if (in_array($hour . ':00', $hours)) {
                            // 5 - Fazer o agendamento
                            $newApp = new UserAppointment();

                            $newApp->id_user = $this->loggedUser->id;
                            $newApp->id_barber = $id;
                            $newApp->id_service = $service;
                            $newApp->ap_datetime = $apDate;
                            $newApp->save();
                        } else {
                            $array['error'] = 'Barbeiro não atende nessa hora';
                        }
                    } else {
                        $array['error'] = 'Barbeiro não atende neste dia';
                    }
                } else {
                    $array['error'] = 'Barbeiro ja possui agendamento neste dia!';
                }
            } else {
                $array['error'] =  'Data inválida!';
            }
        } else {
            $array['error'] = 'Serviço inexistente!';
        }

        return $array;
    }

    // Busca de Barbeiros
    public function search(Request $request)
    {
        $array = ['error' => '', 'list' => []];

        $q = $request->input('q');

        if ($q) {
            $barbers = Barber::select()
                ->where('name', 'LIKE', '%' . $q . '%')
                ->get();

            foreach ($barbers as $bkey => $barber) {
                $barbers[$bkey]['avatar'] = url('media/avatars/' . $barbers[$bkey]['avatar']);
            }
            $array['list'] = $barbers;
        } else {
            $array['error'] = 'Digite algo para buscar';
        }
        return $array;
    }
}

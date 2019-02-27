<?php

namespace App\Http\Controllers;

use App\AdminTable;
use App\Agenda;
use App\Anomalias;
use App\Avisos;
use App\AvisosTemp;
use App\Delegacion;
use App\EntidadesPagos;
use App\ObservacionesRapidas;
use App\Resultados;
use App\User;
use App\Usuarios;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;


class ClientesController extends Controller
{

    public function index()
    {
        $delegaciones = Delegacion::all();

        $perPage = 6;
        $page = Input::get('page');
        $pageName = 'page';
        $page = Paginator::resolveCurrentPage($pageName);
        $offSet = ($page * $perPage) - $perPage;

        $agenda = new Agenda();

        $agendas = $agenda->offset($offSet)->limit($perPage)->orderByDesc('id')->get();

        $total_registros = Agenda::all()->count();
        $array = [];
        $agendaCollection = null;

        foreach ($agendas as $agenda) {

            $user = User::where('id', $agenda->admin_id)->first()->name;

            $pendientes = Avisos::where('estado', 1)->where('agenda_id', $agenda->id)->count();
            $realizados = Avisos::where('estado', '>', 1)->where('agenda_id', $agenda->id)->count();
            $cargasPendientes = AvisosTemp::where('agenda_id', $agenda->id)->count();

            $flag = false;

            if ($pendientes > 0){
                $flag = true;
            }
            if ($cargasPendientes > 0){
                $flag = true;
            }

            if ($realizados > 0){
                $flag = true;
            }

            array_push($array, (object)array(
                'id' => $agenda->id,
                'codigo' => $agenda->codigo,
                'fecha' => $agenda->fecha,
                'delegacion' => $agenda->delegacion->nombre,
                'usuario' => $user,
                'pendientes' => $pendientes,
                'realizados' => $realizados,
                'cargasPendientes' => $cargasPendientes,
                'flag' => $flag
            ));
        }

        $agendaCollection = new Collection($array);

        $posts = new LengthAwarePaginator($agendaCollection, $total_registros, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);

        return view('agenda.agenda',
            [
                'totalAvisos' => 0,
                'delegaciones' => $delegaciones,
                'agendas' => $posts
            ])->withPosts($posts);
    }

    public function save(Request $request)
    {

        $agenda = new Agenda();
        $agenda->fecha = $request->fecha;
        $agenda->delegacion_id = $request->delegacion;
        $agenda->admin_id = Auth::user()->id;

        $agenda->save();

        $anio = Carbon::now()->year;

        $agenda->codigo = "AGE-" . $agenda->id . "-" . $anio;

        $agenda->save();

        return redirect()->route('agenda');
    }

    public function edit($id){
        $aviso = Avisos::where('id', $id)->first();
        $resultados = Resultados::all();
        $anomalias = Anomalias::all();
        $recaudos = EntidadesPagos::all();
        $observaciones = ObservacionesRapidas::all();

        $filename = $aviso->id . ".png";

        $path = config('myconfig.public_fotos')  . $filename;

        $id = Auth::user()->id;

        return view('agenda.editar', [
            'aviso' => $aviso,
            'id' => $id,
            'resultados' => $resultados,
            'anomalias' => $anomalias,
            'recaudos' => $recaudos,
            'observaciones' => $observaciones,
            'path' => $path
        ]);
    }
}

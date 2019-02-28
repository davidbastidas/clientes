<?php

namespace App\Http\Controllers;

use App\Clientes;
use App\ClientesArchivos;
use App\Poblacion;
use App\TipoEsquema as Esquema;
use App\TipoVehiculo as Vehiculos;
use App\User;
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

    public function descarga($id)
    {
      $archivo = ClientesArchivos::where('cliente_id',$id)->first();

      $file = config('myconfig.ruta_documentos'). $archivo->nombre_doc;
      $headers = array(
        'Content-Type' => 'application/pdf',
      );
      return response()->download($file, $archivo->nombre_doc, $headers);
    }

    public function save(Request $request) {

      if(isset($request->nombres)){
        $cliente = null;
        if(isset($request->cliente)){
          $cliente = Clientes::find($request->cliente);
        }else{
          $cliente = new Clientes();
        }

        $cliente->nombres = $request->nombres;
        $cliente->cedula = $request->cedula;
        $cliente->poblacion = $request->poblacion;
        $cliente->resolucion = $request->resolucion;
        $cliente->tipo_esquema = $request->tipo_esquema;
        $cliente->cantidad_escoltas = $request->cantidad_escoltas;
        $cliente->serial_chaleco = $request->serial_chaleco;
        $cliente->imei_celular = $request->imei_celular;
        $cliente->tipo_vehiculo = $request->tipo_vehiculo;
        $cliente->placa_vehiculo = $request->placa_vehiculo;
        $cliente->observaciones = $request->observaciones;
        $cliente->estado = 1;
        $cliente->user_id = Auth::user()->id;

        $cliente->save();

        if($request->file('file') != null){
          $uploadedFile = $request->file('file');

          if ($uploadedFile->isValid()) {
            $documento = null;
            if(isset($request->cliente)){
              $documento = ClientesArchivos::where('cliente_id',$cliente->id)->first();
            }else{
              $documento = new ClientesArchivos();
              $documento->cliente_id = $cliente->id;
              $documento->nombre_doc = '';
              $documento->save();
              $documento->nombre_doc = $documento->id.'.pdf';
              $documento->save();
            }
            $uploadedFile->move(config('myconfig.ruta_documentos'), $documento->nombre_doc);
          }
        }
        return redirect()->route('cliente.buscar',['identificacion' => $cliente->id]);
      }else{
        $poblacion = Poblacion::all();
        $esquema = Esquema::all();
        $vehiculos = Vehiculos::all();
        return view('clientes.formulario',
          [
            'poblacion' => $poblacion,
            'esquema' => $esquema,
            'vehiculos' => $vehiculos
          ]);
      }
      return redirect()->route('home');
    }

    public function edit($id){
      $cliente = Clientes::where('id', $id)->first();
      $poblacion = Poblacion::all();
      $esquema = Esquema::all();
      $vehiculos = Vehiculos::all();
      return view('clientes.formulario',
          [
            'poblacion' => $poblacion,
            'esquema' => $esquema,
            'vehiculos' => $vehiculos,
            'cliente' => $cliente
          ]);
    }

    public function buscar(){
      $identificacion = Input::get('identificacion');
      $clientes = Clientes::where('cedula', $identificacion)->get();
      return view('home', [
        'clientes' => $clientes,
        'identificacion' => $identificacion
      ]);
    }
}

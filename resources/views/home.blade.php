@extends('layouts.app')
@section('content')
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
          <div class="card-body">
            <h4 class="card-title">Ingrese la identificacion para consultar el Beneficiario</h4>
            <div class="row flex-grow">
              <div class="col-8">
                <form class="form-inline" method="GET" action="{{ route('cliente.buscar') }}">
                  <div class="form-group">
                    <input type="text" class="form-control" name="identificacion" placeholder="Identificacion" value="@isset($identificacion){{$identificacion}}@endisset">
                    <button type="submit" class="btn btn-success mr-2">Buscar</button>
                  </div>
                </form>
              </div>
            </div>

            <br>
            @isset($clientes)
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th> Beneficiario </th>
                    <th> Identificacion </th>
                    <th> Poblacion </th>
                    <th> Resolucion </th>
                    <th> Documento </th>
                    <th> Accion </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($clientes as $cliente)
                    <tr>
                      <td> {{$cliente->nombres}} </td>
                      <td> {{$cliente->cedula}} </td>
                      <td> {{$cliente->poblacionFk->nombre}} </td>
                      <td> {{$cliente->resolucion}} </td>
                      <td>
                        <a href="{{ route('cliente.descarga.documento', ['id' => $cliente->id]) }}" class="file-icon-wrapper">
                          <div class="btn btn-outline-danger file-icon">
                            <i class="mdi mdi-file-pdf"></i>
                          </div>
                        </a>
                      </td>
                      <td>
                        <a href="{{route('cliente.edit', ['id' => $cliente->id])}}" class="btn btn-primary btn-fw">
                          Ver
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endisset
          </div>
      </div>
    </div>
  </div>
@endsection

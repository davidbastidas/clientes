@extends('layouts.app')
<style>
    .little{
        font-size: 20px !important;
    }
</style>
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <center><h3>GUARDAR BENEFICIARIO</h3></center>
                    <br><br>
                    <form method="post" action="{{route('cliente.save')}}" enctype="multipart/form-data" style="padding: 0">
                      {{ csrf_field() }}
                        <input type="hidden" name="cliente" value="@isset($cliente->id){{$cliente->id}}@endisset">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Nombres</label>
                                <input type="text" class="form-control" name="nombres" placeholder="Nombre" value="@isset($cliente->id){{$cliente->nombres}}@endisset">
                              </div>
                              <div class="form-group">
                                <label>Cedula</label>
                                <input type="text" class="form-control" name="cedula" placeholder="Cedula" value="@isset($cliente->id){{$cliente->cedula}}@endisset">
                              </div>
                              <div class="form-group">
                                <label>Poblacion</label>
                                <select class="form-control" name="poblacion">
                                  <option value="">[Seleccione Poblacion]</option>
                                  @foreach ($poblacion as $pob)
                                     @isset($cliente->id)
                                       @if ($pob->id == $cliente->poblacion)
                                         <option value="{{$pob->id}}" selected>{{$pob->nombre}}</option>
                                       @endif
                                     @else
                                       <option value="{{$pob->id}}">{{$pob->nombre}}</option>
                                     @endisset
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Resolucion</label>
                                <input type="text" class="form-control" name="resolucion" placeholder="Resolucion" value="@isset($cliente->id){{$cliente->resolucion}}@endisset">
                              </div>
                              <div class="form-group">
                                <label>Esquema</label>
                                <select class="form-control" name="tipo_esquema">
                                  <option value="">[Seleccione Tipo de Esquema]</option>
                                  @foreach ($esquema as $esq)
                                    @isset($cliente->id)
                                      @if ($esq->id == $cliente->tipo_esquema)
                                        <option value="{{$esq->id}}" selected>{{$esq->nombre}}</option>
                                      @endif
                                    @else
                                      <option value="{{$esq->id}}">{{$esq->nombre}}</option>
                                    @endisset
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Cantidad Escoltas</label>
                                <input type="text" class="form-control" name="cantidad_escoltas" placeholder="Cantidad Escoltas" value="@isset($cliente->id){{$cliente->cantidad_escoltas}}@endisset">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Serial Chaleco</label>
                                <input type="text" class="form-control" name="serial_chaleco" placeholder="Serial Chaleco" value="@isset($cliente->id){{$cliente->serial_chaleco}}@endisset">
                              </div>
                              <div class="form-group">
                                <label>IMEI Celular</label>
                                <input type="text" class="form-control" name="imei_celular" placeholder="IMEI Celular" value="@isset($cliente->id){{$cliente->imei_celular}}@endisset">
                              </div>
                              <div class="form-group">
                                <label>Tipo de Vehiculo</label>
                                <select class="form-control" name="tipo_vehiculo">
                                  <option value="">[Seleccione Tipo de Vehiculo]</option>
                                  @foreach ($vehiculos as $veh)
                                    @isset($cliente->id)
                                      @if ($veh->id == $cliente->tipo_vehiculo)
                                        <option value="{{$veh->id}}" selected>{{$veh->nombre}}</option>
                                      @endif
                                    @else
                                      <option value="{{$veh->id}}">{{$veh->nombre}}</option>
                                    @endisset
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Placa Vehiculo</label>
                                <input type="text" class="form-control" name="placa_vehiculo" placeholder="Placa Vehiculo" value="@isset($cliente->id){{$cliente->placa_vehiculo}}@endisset">
                              </div>
                              <div class="form-group">
                                <label>Observaciones</label>
                                <textarea class="form-control" name="observaciones" rows="2">@isset($cliente->id){{$cliente->observaciones}}@endisset</textarea>
                              </div>
                              <div class="form-group">
                                <label>Documento</label>
                                <input class="form-control" type="file" name="file"/>
                              </div>
                            </div>
                          </div>

                        <div class="row">
                            <div class="col-md-3">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

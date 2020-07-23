@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Remesa
          <small>Detalles de Bodega</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('remesa.index')}}"><i class="fa fa-list"></i> Remesas</a></li>
          <li class="active">Detalle</li>
        </ol>
    </section>
@stop

@section('content')
    <form id="RemesaForm">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-8">
                                <label for="bodega">Bodega:</label>
                                <select name="bodega" class="form-control" id="bodega">
                                        <option>{{ $bodega[0]->nombre_bodega }}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="fechaIngreso">Fecha de ingreso:</label>
                                <input type="text" class="form-control" name="fechaIngreso" value="{{$fecha}}" readOnly>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div>
                            <table id="tablaRegistro" class="table table-striped table-bordered no-margin-bottom nowrap"  width="100%">
                                <thead>
                                    <tr>
                                        <th>Nombre del Tipo</th>
                                        <th>Planchas</th>
                                        <th>Unidad por Plancha</th>
                                        <th>Número Inicial</th>
                                        <th>Número Final</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($result as $res)
                                <tr>
                                    <td>{{$res->codigo}}</td>
                                    <td>{{$res->planchas}}</td>
                                    <td>{{$res->unidad_por_plancha}}</td>
                                    <td>{{$res->numeracion_inicial}}</td>
                                    <td>{{$res->numeracion_final}}</td>
                                    <td>{{$res->cantidad}}</td>
                                    <td>Q.{{$res->total}}.00</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-danger form-button' href="{{ route('remesa.index') }}">Regresar</a>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>


@stop

@push('scripts')
<script src="{{asset('js/remesas/create.js')}}"></script>
@endpush

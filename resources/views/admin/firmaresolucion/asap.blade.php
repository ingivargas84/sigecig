@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Autorización de Solicitudes de Auxilio Póstumo
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('resolucion.index')}}"><i class="fa fa-list"></i> Autorizacion</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="AsapForm"  action="{{route('asap.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="nombre">Colegiado:</label>
                                <input type="text" readonly class="form-control" placeholder="Nombre:" name="nombre" value="{{$solicitud->n_colegiado}}" >
                            </div>
                            <div class="col-sm-7">
                                <label for="nombre">Nombre Colegiado:</label>
                                <input type="text" readonly class="form-control" placeholder="Nombre:" name="nombre" value="{{$solicitud->n_colegiado}}" >
                            </div>
                            <div class="col-sm-3">
                            <label for="telefono">Fecha de Nacimiento:</label>
                                <input type="text" readonly class="form-control" placeholder="Telefono:" name="telefono" value="{{$solicitud->fecha_solicitud}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-9">
                                <label for="telefono">Profesión:</label>
                                <input type="text" readonly class="form-control" placeholder="Telefono:" name="telefono" value="{{$solicitud->fecha_solicitud}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="dpi">DPI/CUI:</label>
                                <input type="text" readonly class="form-control" placeholder="Dpi:" name="dpi" value="{{$solicitud->fecha_solicitud}}" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" readonly class="form-control" placeholder="Telefono:" name="telefono" value="{{$solicitud->fecha_solicitud}}">
                            </div>
                            <div class="col-sm-4">
                                <label for="dpi">Banco:</label>
                                <input type="text" readonly class="form-control" placeholder="Banco:" name="banco" value="{{$banco[0]->nombre_banco}}" >
                            </div>
                            <div class="col-sm-3">
                                <label for="telefono">Tipo de Cuenta:</label>
                                <input type="text" readonly class="form-control" placeholder="Telefono:" name="telefono" value="{{$tipocuenta[0]->tipo_cuenta}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="telefono">No Cuenta Bancaria:</label>
                                <input type="text" readonly class="form-control" placeholder="Telefono:" name="telefono" value="{{$solicitud->no_cuenta}}">
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('resolucion.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonAutorizar" name="ButtonAutorizar">Autorizar</button>
                            <button class="btn btn-danger form-button" id="ButtonRechazar" name="ButtonRechazar">Rechazar</button>
                        </div>


                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush


@push('scripts')
<script src="{{asset('js/resolucion/asap.js')}}"></script>
@endpush

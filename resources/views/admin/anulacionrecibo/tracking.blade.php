@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Trackin Anulación de Recibo
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('colaborador.index')}}"><i class="fa fa-list"></i> Anulación de Recibo</a></li>
          <li class="active">Tracking</li>
        </ol>
    </section>
@stop

@section('content')
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="peticion" style="font-size: large;">PETICIÓN DEL CAJERO:</label>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8">
                                <label for="fecha_solicitud">Fecha:</label>
                                <input type="text" class="form-control" name="fecha_solicitud" id="fecha_solicitud" readOnly value="{{ $consulta->fecha_solicitud }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8">
                                <label for="estado_peticion">Estado:</label>
                                <input type="text" class="form-control" name="estado_peticion" id="estado_peticion" readOnly value="{{ $consulta->estado_recibo }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8">
                                <label for="usuario_cajero_id">Usuario:</label>
                                <input type="text" class="form-control" name="usuario_cajero_id" id="usuario_cajero_id" readOnly value="{{ $consulta->cajero }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="peticion" style="font-size: large;">APROBACIÓN DE CONTABILIDAD:</label>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8">
                                <label for="fecha_solicitud">Fecha:</label>
                                <input type="text" class="form-control" name="fecha_respuesta" id="fecha_respuesta" readOnly value="{{ $consulta->fecha_aprueba_rechazo }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8">
                                <label for="fecha_solicitud">Estado:</label>
                                @if ($consulta->fecha_aprueba_rechazo != null)
                                    <input type="text" class="form-control" name="estado_peticion" id="estado_peticion" readOnly value="{{ $consulta->estado_recibo }}">
                                @else
                                    <input type="text" class="form-control" name="estado_peticion" id="estado_peticion" readOnly>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8">
                                <label for="fecha_solicitud">Usuario:</label>
                                <input type="text" class="form-control" name="usuario_contabilidad_id" id="usuario_contabilidad_id" readOnly value="{{ $consulta->conta }}">
                            </div>
                        </div>
                    </div>
                </div>
                <br><br><br><br>
                <br><br><br><br>
                <div class="text-right m-t-15">
                    <a class='btn btn-danger form-button' style="padding: 6px 46px" href="{{ route('anulacion.index') }}">Regresar</a>
                </div>
            </div>
        </div>
    </div>

@stop

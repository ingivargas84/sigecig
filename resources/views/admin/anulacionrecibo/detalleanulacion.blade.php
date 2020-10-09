@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Detalles del proceso de Anulación
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('anulacion.index')}}"><i class="fa fa-list"></i> Anulacion Index</a></li>
          <li class="active">Detalle de Anulación</li>
        </ol>
    </section>
@stop

@section('content')
    <form id="DetalleAnulacionForm">
        {{csrf_field()}}
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <br><br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <label for="fechaHoy">Cajero que solicita anulación</label>
                                    <input type="text" class="form-control" id="nombreCajero" name="nombreCajero" readOnly value="{{ $datosCajero[0]->name }}">
                                    <input type="text" class="form-control" id="idCajero" name="idCajero" readOnly value="{{ Auth::user()->id }}" style="display:none;">
                                </div>
                                <div class="col-md-4">
                                    <label for="fechaHoy">Sede:</label>
                                    <input type="text" class="form-control" id="nombreSede" name="nombreSede" readOnly value="{{ $datosCajero[0]->nombre_sede }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="fechaHoy">Fecha de Solicitud</label>
                                    <input type="text" class="form-control" id="fechaSolicitud" name="fechaSolicitud" readOnly value="{{ date('Y-m-d h:i:s', strtotime($solicitud->fecha_solicitud)) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="solicitud">Motivo de solicitud de anulación:</label>
                            <textarea class="form-control" id="solicitud" name="solicitud" rows="3" readOnly>{{$solicitud->razon_solicitud}}</textarea>
                            <br><br><br>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-5">
                                    <label for="fechaHoy">Usuario de respuesta de anulación</label>
                                    @if ($tieneRespuesta == 'no')
                                        <input type="text" class="form-control" id="nombreUsuarioRespuesta" name="nombreUsuarioRespuesta" readOnly>
                                    @elseif ($tieneRespuesta == 'si')
                                        <input type="text" class="form-control" id="nombreUsuarioRespuesta" name="nombreUsuarioRespuesta" readOnly value="{{ $nombreContador }}">
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label for="fechaHoy">Fecha de Respuesta</label>
                                    @if ($tieneRespuesta == 'no')
                                        <input type="text" class="form-control" id="fechaHoy" name="fechaHoy" readOnly>
                                    @elseif ($tieneRespuesta == 'si')
                                        <input type="text" class="form-control" id="fechaHoy" name="fechaHoy" readOnly value="{{ date('Y-m-d h:i:s', strtotime($solicitud->fecha_aprueba_rechazo)) }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="respuesta">Respuesta de anulación:</label>
                            @if ($tieneRespuesta == 'no')
                                <textarea class="form-control" id="cuadroRespuesta" name="cuadroRespuesta" readOnly rows="3"></textarea>
                            @elseif ($tieneRespuesta == 'si')
                                <textarea class="form-control" id="respuesta" name="respuesta" rows="3" readOnly>{{ $solicitud->razon_rechazo }}</textarea>
                            @endif
                        </div>
                        <br><br><br>
                    </div>
                    <br><br><br><br><br><br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="text-right m-t-15">
                                    <a class='btn btn-danger form-button' style="padding: 6px 46px" href="{{ route('anulacion.index') }}">Regresar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="loader loader-bar"></div>


@stop

@push('scripts')
<script src="{{asset('js/anulacion/respuesta.js')}}"></script>
<script src="{{asset('js/anulacion/bootstrapSwitchButton.js')}}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/anulacion/bootstrapSwitchButton.css') }}">
@endpush

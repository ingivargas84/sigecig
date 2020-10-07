@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Detalle de Recibo: {{$idMaestro}}
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li class="active">Detalle de Recibo</li>
        </ol>
    </section>
@stop

@section('content')
    <form id="RespuestaAnulacionForm" method="POST" action="{{route('respuestaAnulacion.save')}}">
        {{csrf_field()}}
        <input type="text" name="numeroRecibo" id="numeroRecibo" style="display:none;" value="{{ $idMaestro }}" class="form-control">
        <input type="text" name="tipoDeCliente" id="tipoDeCliente" style="display:none;" value="{{ $datos[0]->tipo_de_cliente_id }}" class="form-control">
        <input type="text" name="idAnulacion" id="idAnulacion" style="display:none;" value="{{ $idAnulacion }}" class="form-control">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-9">
                            <label for="bodega">Nombre:</label>
                            <input type="text" readOnly id="nombreCliente" name="nombreCliente" class="form-control" value="{{$datos[0]->nombre}}">
                        </div>
                        <div class="col-md-3">
                            <label for="bodega">Serie:</label>
                            <input type="text" readOnly id="serierecibo" name="serierecibo" class="form-control" value="{{$datos[0]->serie}}">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            @if ($cliente == 'colegiado')
                                <label for="bodega">No. Colegiado:</label>
                            @elseif ($cliente == 'empresa')
                                <label for="bodega">Nit:</label>
                            @else
                                <label for="bodega">Número de Identificación:</label>
                            @endif
                            <input type="text" readOnly id="NoIdentificacion" name="NoIdentificacion" class="form-control" value="{{$datos[0]->numero_de_identificacion}}">
                        </div>
                        <div class="col-md-6">
                            <label for="fechaIngreso">Fecha de creación:</label>
                            <input type="text" readOnly id="fechaCreacion" name="fechaCreacion" class="form-control" value="{{ \Carbon\Carbon::parse($datos[0]->created_at)->format('d/m/Y H:i:s')}}">
                        </div>
                    </div>
                    <br><br>
                    <div>
                        <table id="tablaDetalle" class="table table-striped table-bordered no-margin-bottom nowrap"  width="100%">
                            <thead>
                                <tr>
                                    <th width="15%">CÓDIGO</th>
                                    <th width="65%">DESCRIPCIÓN</th>
                                    <th width="10%">CANTIDAD</th>
                                    <th width="10%">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detalles as $det)
                                    <tr>
                                        <td>{{$det->codigo_compra}}</td>
                                        <td>{{$det->tipo_de_pago}}</td>
                                        <td>{{$det->cantidad}}</td>
                                        <td>{{$det->total}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align:center;background: #03306D;color:white;font-size: x-large"><b>TOTAL</b></td>
                                    <td style="background: #03306D;"><input type="text" name="generalTotal" id="generalTotal" class="form-control" readOnly value="{{$datos[0]->monto_total}}"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <br>
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
                                    <input type="text" class="form-control" id="nombreUsuarioRespuesta" name="nombreUsuarioRespuesta" readOnly value="{{ $nombreContador }}">
                                    <input type="text" class="form-control" id="idUsuarioRespuesta" name="idUsuarioRespuesta" readOnly value="{{ $idContador }}" style="display:none;">
                                </div>
                                <div class="col-md-3">
                                    <label for="fechaHoy">Fecha de Respuesta</label>
                                    @if ($tieneRespuesta == 'no')
                                        <input type="text" class="form-control" id="fechaHoy" name="fechaHoy" readOnly value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}">
                                    @elseif ($tieneRespuesta == 'si')
                                        <input type="text" class="form-control" id="fechaHoy" name="fechaHoy" readOnly value="{{ date('Y-m-d h:i:s', strtotime($solicitud->fecha_aprueba_rechazo)) }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="respuesta">Respuesta de anulación:</label>
                                @if ($tieneRespuesta == 'no')
                                    <textarea class="form-control" id="respuesta" name="respuesta" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <label class="radio-inline">
                                    <input name="tipoRespuesta" type="checkbox" data-toggle="toggle" value="2">
                                    <b>Aprobar Anulación</b>
                                </label>
                                <label class="radio-inline">
                                    <input name="tipoRespuesta" type="checkbox" data-toggle="toggle" value="3">
                                    <b>Rechazar Anulación</b>
                                </label>
                            </div>
                            @elseif ($tieneRespuesta == 'si')
                                <textarea class="form-control" id="respuesta" name="respuesta" rows="3" readOnly>{{ $solicitud->razon_rechazo }}</textarea>
                            @endif
                            <br><br><br>
                        </div>
                    </div>
                    <br><br><br><br><br><br>
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="text-right m-t-15">
                                    <a class='btn btn-danger form-button' href="{{ route('dashboard') }}">Regresar</a>
                                    @if ($tieneRespuesta == 'no')
                                        <a class="btn btn-primary" id="guardar" style="padding: 6px 46px">Guardar</a>
                                    @endif
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

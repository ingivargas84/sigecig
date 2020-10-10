@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Detalle de Recibo: {{$id}}
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('anulacion.index')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li class="active">Detalle de Recibo</li>
        </ol>
    </section>
@stop

@section('content')
    <form id="ReciboDetalleForm">
        {{csrf_field()}}
        <input type="text" name="numeroRecibo" style="display:none;" value="{{$id}}" class="form-control">
        <input type="text" name="tipoDeCliente" style="display:none;" value="{{$datos[0]->tipo_de_cliente_id}}" class="form-control">
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
                    <br><br><br><br><br><br>
                    <div class="text-right m-t-15">
                        <a class='btn btn-danger form-button'style="padding: 6px 46px"  href="{{ route('anulacion.index') }}">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="loader loader-bar"></div>


@stop

@push('scripts')
<script src="{{asset('js/anulacion/detalle.js')}}"></script>
@endpush

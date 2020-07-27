@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Traspaso
          <small>Ingresar Traspaso</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('traspaso.index')}}"><i class="fa fa-list"></i> Traspaso</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form id="TrasladoForm">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="bodega1" style="font-size: large;">Bodega De Origen:</label>
                                        <select name="bodega1" class="form-control" id="bodega1">
                                            <option value="">-- Escoja la Categoría --</option>
                                            @foreach ($bodega as $bo)
                                                <option value="{{ $bo->id }}">{{ $bo->nombre_bodega }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="col-md-12">
                                <table id="tablaRegistro" class="table table-striped table-bordered no-margin-bottom nowrap"  width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Nombre del Timbre</th>
                                            <th style="text-align:center;">Existencia por Bodega</th>
                                            <th style="text-align:center;">Cantidad a traspasar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>TC01</b></td>
                                            <td><input type="number" name="existenciaTc01B1" id="existenciaTc01B1" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="cantidadTraspasoTc01B1" id="cantidadTraspasoTc01B1" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC05</b></td>
                                            <td><input type="number" name="existenciaTc05B1" id="existenciaTc05B1" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="cantidadTraspasoTc05B1" id="cantidadTraspasoTc05B1" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC10</b></td>
                                            <td><input type="number" name="existenciaTc10B1" id="existenciaTc10B1" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="cantidadTraspasoTc10B1" id="cantidadTraspasoTc10B1" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC20</b></td>
                                            <td><input type="number" name="existenciaTc20B1" id="existenciaTc20B1" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="cantidadTraspasoTc20B1" id="cantidadTraspasoTc20B1" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC50</b></td>
                                            <td><input type="number" name="existenciaTc50B1" id="existenciaTc50B1" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="cantidadTraspasoTc50B1" id="cantidadTraspasoTc50B1" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC100</b></td>
                                            <td><input type="number" name="existenciaTc100B1" id="existenciaTc100B1" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="cantidadTraspasoTc100B1" id="cantidadTraspasoTc100B1" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC200</b></td>
                                            <td><input type="number" name="existenciaTc200B1" id="existenciaTc200B1" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="cantidadTraspasoTc200B1" id="cantidadTraspasoTc200B1" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC500</b></td>
                                            <td><input type="number" name="existenciaTc500B1" id="existenciaTc500B1" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="cantidadTraspasoTc500B1" id="cantidadTraspasoTc500B1" class="form-control" min="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="bodega2" style="font-size: large;">Bodega Destino:</label>
                                        <select name="bodega2" class="form-control" id="bodega2">
                                            <option value="">-- Escoja la Categoría --</option>
                                            @foreach ($bodega as $bo)
                                                <option value="{{ $bo->id }}">{{ $bo->nombre_bodega }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="col-md-12">
                                <table id="tablaRegistro" class="table table-striped table-bordered no-margin-bottom nowrap"  width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Nombre del Timbre</th>
                                            <th style="text-align:center;">Existencia por Bodega</th>
                                            <th style="text-align:center;">Nueva Existencia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>TC01</b></td>
                                            <td><input type="number" name="existenciaTc01B2" id="existenciaTc01B2" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="nuevaCantidadTc01B2" id="nuevaCantidadTc01B2" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC05</b></td>
                                            <td><input type="number" name="existenciaTc05B2" id="existenciaTc05B2" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="nuevaCantidadTc05B2" id="nuevaCantidadTc05B2" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC10</b></td>
                                            <td><input type="number" name="existenciaTc10B2" id="existenciaTc10B2" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="nuevaCantidadTc10B2" id="nuevaCantidadTc10B2" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC20</b></td>
                                            <td><input type="number" name="existenciaTc20B2" id="existenciaTc20B2" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="nuevaCantidadTc20B2" id="nuevaCantidadTc20B2" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC50</b></td>
                                            <td><input type="number" name="existenciaTc50B2" id="existenciaTc50B2" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="nuevaCantidadTc50B2" id="nuevaCantidadTc50B2" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC100</b></td>
                                            <td><input type="number" name="existenciaTc100B2" id="existenciaTc100B2" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="nuevaCantidadTc100B2" id="nuevaCantidadTc100B2" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC200</b></td>
                                            <td><input type="number" name="existenciaTc200B2" id="existenciaTc200B2" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="nuevaCantidadTc200B2" id="nuevaCantidadTc200B2" class="form-control" min="0"></td>
                                        </tr>
                                        <tr>
                                            <td><b>TC500</b></td>
                                            <td><input type="number" name="existenciaTc500B2" id="existenciaTc500B2" class="form-control" readOnly min="0"></td>
                                            <td><input type="number" name="nuevaCantidadTc500B2" id="nuevaCantidadTc500B2" class="form-control" min="0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-danger form-button' href="{{ route('traspaso.index') }}">Regresar</a>
                            <a class="btn btn-primary form-button" style="padding: 6px 46px" id="guardar">Guardar</a>
                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>


@stop

@push('scripts')
<script src="{{asset('js/traspasos/create.js')}}"></script>
@endpush

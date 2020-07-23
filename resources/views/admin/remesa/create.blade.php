@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Remesa
          <small>Ingresar A Bodega</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('remesa.index')}}"><i class="fa fa-list"></i> Remesas</a></li>
          <li class="active">Crear</li>
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
                                    <option value="">-- Escoja la Categoría --</option>
                                    @foreach ($bodega as $bo)
                                        <option value="{{ $bo->id }}">{{ $bo->nombre_bodega }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="fechaIngreso">Fecha de ingreso:</label>
                                <input type="text" class="form-control" name="fechaIngreso" value="<?php echo date("d/m/Y");?>" readOnly>
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
                                    <tr>
                                        <td value="30">TC01</td>
                                        <td><input type="number" name="planchasTc01" id="planchasTc01" class="form-control" min="0"></td>
                                        <td><input type="number" name="unidadPlanchaTc01" id="unidadPlanchaTc01" class="form-control" min="0" value="40"></td>
                                        <td><input type="number" name="numeroInicialTc01" id="numeroInicialTc01" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="numeroFinalTc01" id="numeroFinalTc01" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="cantidadTc01" id="cantidadTc01" class="form-control" value="0" readOnly></td>
                                        <td><input type="text" name="totalTc01" id="totalTc01" class="form-control" readOnly></td>
                                    </tr>
                                    <tr>
                                        <td>TC05</td>
                                        <td><input type="number" name="planchasTc05" id="planchasTc05" class="form-control" min="0"></td>
                                        <td><input type="number" name="unidadPlanchaTc05" id="unidadPlanchaTc05" class="form-control" min="0" value="40"></td>
                                        <td><input type="number" name="numeroInicialTc05" id="numeroInicialTc05" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="numeroFinalTc05" id="numeroFinalTc05" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="cantidadTc05" id="cantidadTc05" class="form-control" value="0" readOnly></td>
                                        <td><input type="text" name="totalTc05" id="totalTc05" class="form-control" readOnly></td>
                                    </tr>
                                    <tr>
                                        <td>TC10</td>
                                        <td><input type="number" name="planchasTc10" id="planchasTc10" class="form-control" min="0"></td>
                                        <td><input type="number" name="unidadPlanchaTc10" id="unidadPlanchaTc10" class="form-control" min="0" value="40"></td>
                                        <td><input type="number" name="numeroInicialTc10" id="numeroInicialTc10" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="numeroFinalTc10" id="numeroFinalTc10" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="cantidadTc10" id="cantidadTc10" class="form-control" value="0" readOnly></td>
                                        <td><input type="text" name="totalTc10" id="totalTc10" class="form-control" readOnly></td>
                                    </tr>
                                    <tr>
                                        <td>TC20</td>
                                        <td><input type="number" name="planchasTc20" id="planchasTc20" class="form-control" min="0"></td>
                                        <td><input type="number" name="unidadPlanchaTc20" id="unidadPlanchaTc20" class="form-control" min="0" value="40"></td>
                                        <td><input type="number" name="numeroInicialTc20" id="numeroInicialTc20" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="numeroFinalTc20" id="numeroFinalTc20" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="cantidadTc20" id="cantidadTc20" class="form-control" value="0" readOnly></td>
                                        <td><input type="text" name="totalTc20" id="totalTc20" class="form-control" readOnly></td>
                                    </tr>
                                    <tr>
                                        <td>TC50</td>
                                        <td><input type="number" name="planchasTc50" id="planchasTc50" class="form-control" min="0"></td>
                                        <td><input type="number" name="unidadPlanchaTc50" id="unidadPlanchaTc50" class="form-control" min="0" value="40"></td>
                                        <td><input type="number" name="numeroInicialTc50" id="numeroInicialTc50" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="numeroFinalTc50" id="numeroFinalTc50" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="cantidadTc50" id="cantidadTc50" class="form-control" value="0" readOnly></td>
                                        <td><input type="text" name="totalTc50" id="totalTc50" class="form-control" readOnly></td>
                                    </tr>
                                    <tr>
                                        <td>TC100</td>
                                        <td><input type="number" name="planchasTc100" id="planchasTc100" class="form-control" min="0"></td>
                                        <td><input type="number" name="unidadPlanchaTc100" id="unidadPlanchaTc100" class="form-control" min="0" value="40"></td>
                                        <td><input type="number" name="numeroInicialTc100" id="numeroInicialTc100" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="numeroFinalTc100" id="numeroFinalTc100" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="cantidadTc100" id="cantidadTc100" class="form-control" value="0" readOnly></td>
                                        <td><input type="text" name="totalTc100" id="totalTc100" class="form-control" readOnly></td>
                                    </tr>
                                    <tr>
                                        <td>TC200</td>
                                        <td><input type="number" name="planchasTc200" id="planchasTc200" class="form-control" min="0"></td>
                                        <td><input type="number" name="unidadPlanchaTc200" id="unidadPlanchaTc200" class="form-control" min="0" value="40"></td>
                                        <td><input type="number" name="numeroInicialTc200" id="numeroInicialTc200" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="numeroFinalTc200" id="numeroFinalTc200" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="cantidadTc200" id="cantidadTc200" class="form-control" value="0" readOnly></td>
                                        <td><input type="text" name="totalTc200" id="totalTc200" class="form-control" readOnly></td>
                                    </tr>
                                    <tr>
                                        <td>TC500</td>
                                        <td><input type="number" name="planchasTc500" id="planchasTc500" class="form-control" min="0"></td>
                                        <td><input type="number" name="unidadPlanchaTc500" id="unidadPlanchaTc500" class="form-control" min="0" value="40"></td>
                                        <td><input type="number" name="numeroInicialTc500" id="numeroInicialTc500" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="numeroFinalTc500" id="numeroFinalTc500" class="form-control" readOnly min="0"></td>
                                        <td><input type="number" name="cantidadTc500" id="cantidadTc500" class="form-control" value="0" readOnly></td>
                                        <td><input type="text" name="totalTc500" id="totalTc500" class="form-control" readOnly></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" style="text-align:center;background: #03306D;color:white;font-size: x-large"><b>TOTAL</b></td>
                                        <td style="background: #03306D;"><input type="text" name="generalCantidad" id="generalCantidad" class="form-control" readOnly></td>
                                        <td style="background: #03306D;"><input type="text" name="generalTotal" id="generalTotal" class="form-control" readOnly></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <br>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-danger form-button' href="{{ route('remesa.index') }}">Regresar</a>
                            <a class="btn btn-primary form-button" id="guardar">Guardar</a>
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

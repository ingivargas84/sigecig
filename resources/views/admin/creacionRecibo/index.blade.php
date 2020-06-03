@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1><center>Creción de Recibos</center></h1>
  </section>

  @endsection

@section('content')


<form method="POST" id="ReciboForm">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body"  id="app">
                        <br>
                        <div class="row">
                            <div class="col-sm-3 col-lg-4 col-md-offset-1">
                                <div class="form-group">
                                    <label for="tipoCliente" class="control-label">TIPO DE CLIENTE</label>
                                    <div>
                                        <label class="radio-inline">
                                            <input checked="checked" name="tipoCliente" type="radio" value="c">
                                            Colegiado
                                        </label>
                                        <label class="radio-inline">
                                            <input name="tipoCliente" type="radio" value="p">
                                            Particular
                                        </label>
                                        <label class="radio-inline">
                                            <input name="tipoCliente" type="radio" value="e">
                                            Empresa
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div id="c" class="desc"> <!-- Inicia vista Colegiado -->
                            <div class="row col-sm-offset-1">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="c_cliente" class="control-label">Colegiado</label>
                                        <div>
                                            <input type="number" id="c_cliente" name="c_cliente" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <label for="n_cliente" class="control-label">Nombres</label>
                                        <div>
                                            <input type="text" disabled id="n_cliente" name="n_cliente" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="divStatus" style="display: block;">
                                    <div class="form-group">
                                        <label for="estado" class="control-label">Status</label>
                                        <div>
                                            <input id="estado" disabled type="text" class="form-control" name="estado" style="color: rgb(0, 128, 0)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-sm-offset-1">
                                <div class="col-sm-5" id="divf_ult_timbre" style="display: block;">
                                    <div class="form-group">
                                        <label for="f_ult_timbre" class="control-label">Fecha de último pago de timbre</label>
                                        <div>
                                            <input id="f_ult_timbre" disabled type="text" class="form-control" name="f_ult_timbre" style="color: rgb(0, 128, 0)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" id="divf_ult_pago" style="display: block;">
                                    <div class="form-group">
                                        <label for="f_ult_pago" class="control-label">Fecha de último pago de colegio</label>
                                        <div>
                                            <input id="f_ult_pago" disabled type="text" class="form-control" name="f_ult_pago" style="color: rgb(0, 128, 0)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="divmontoTimbre" style="display: block;">
                                    <div class="form-group">
                                        <label for="monto_timbre" class="control-label">Pago timbre</label>
                                        <div>
                                            <input id="monto_timbre" disabled type="text" class="form-control" name="monto_timbre">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-sm-offset-1">
                                <div class="col-sm-11" id="divComplemento" style="display: block;">
                                    <div class="form-group">
                                        <label for="complemento" class="control-label">Complemento</label>
                                        <div>
                                            <input id="complemento" type="text" class="form-control" name="complemento">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-sm-offset-1">
                                <div class="col-sm-2" id="divCdigo" style="display: block;">
                                    <div class="form-group">
                                        <label for="codigo" class="control-label">Codigo</label>
                                        <select name="codigo" class="form-control" id="codigo">
                                            <option value="">-- Escoja --</option>
                                            @foreach ($tipo as $ti)
                                                <option value="{{ $ti->id }}">{{ $ti->codigo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1" id="divCantidad" style="display: block;">
                                    <div class="form-group">
                                        <label for="cantidad" class="control-label">Cantidad</label>
                                        <div>
                                            <input id="cantidad" type="number" min="1" class="form-control" name="cantidad" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1 col-lg-2" id="divprecioU" style="display: block;">
                                    <div class="form-group">
                                        <label for="precioU" class="control-label">Precio U.</label>
                                        <div>
                                            <input id="precioU" disabled type="text" class="form-control" name="precioU">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" id="divdescTipoPago" style="display: block;">
                                    <div class="form-group">
                                        <label for="descTipoPago" class="control-label">Descripcion</label>
                                        <div>
                                            <input id="descTipoPago" disabled type="text" class="form-control" name="descTipoPago">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="divsubtotal" style="display: block;">
                                    <div class="form-group">
                                        <label for="subtotal" class="control-label">Subtotal</label>
                                        <div>
                                            <input id="subtotal" disabled type="text" class="form-control" name="subtotal">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1" id="divcategoria_id" style="display: none;">
                                    <div class="form-group">
                                        <label for="categoria_id" class="control-label">categorida_id</label>
                                        <div>
                                            <input id="categoria_id" disabled type="text" class="form-control" name="categoria_id">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1" id="divButtonAgregar" style="display: block;">
                                    <div class="form-group">
                                        <label for="buttonAgregar" class="control-label"></label>
                                        <div>
                                            <a id="buttonAgregar" class="btn btn-danger" name="buttonAgregar" onclick="agregarproductof()">+</a>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="row">
                                <div style="padding: 0px 26px;" id="detalle">
                                    <table class="table table-striped table-hover" id="tablaDetalle"><thead><tr><th style="display: none;">Código</th><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Descripcion</th><th>Subtotal</th><th style="display: none;">categoria_id</th><th>Eliminar</th></tr></thead>
                                        <tbody>
                                        @if(isset($detalle))
                                            @foreach ($detalle as $fila)
                                            <tr>
                                            <td style="display: none;">{!! $fila->codigo; !!}</td>
                                            <td>{!! $fila->nombreCodigo; !!}</td>
                                            <td>{!! $fila->cantidad; !!}</td>
                                            <td>{!! $fila->precioU; !!}</td>
                                            <td>{!! $fila->descripcion; !!}</td>
                                            <td style="display: none;">{!! $fila->categoria_id; !!}</td>
                                            <td align="right" class="subtotal">{!! $fila->subtotal; !!}</td>
                                            <td><button class="form-button btn btn-danger" onclick="eliminardetalle(this)" type="button">Eliminar</button></td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-2 col-sm-offset-8" id="divTotal" style="display: block;">
                                    <div class="form-group">
                                        <label for="total" class="control-label">Total</label>
                                        <div>
                                            <input id="total" disabled type="text" class="form-control" name="total">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="e" class="desc" style="display: none"> <!-- Inicia vista de Empresa -->
                            <div class="row col-sm-offset-1">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="nit" class="control-label">Nit</label>
                                        <div>
                                            <input type="text" id="nit" name="nit" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="empresa" class="control-label">Empresa</label>
                                        <div>
                                            <input type="text" disabled id="empresa" name="empresa" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-sm-offset-1">
                                <div class="col-sm-2" id="divColegioE" style="display: block;">
                                    <div class="form-group">
                                        <label for="codigoE" class="control-label">Codigo</label>
                                        <select name="codigoE" class="form-control" id="codigoE">
                                            <option value="">-- Escoja --</option>
                                            @foreach ($tipo as $ti)
                                                <option value="{{ $ti->id }}">{{ $ti->codigo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1" id="divCantidadE" style="display: block;">
                                    <div class="form-group">
                                        <label for="cantidadE" class="control-label">Cantidad</label>
                                        <div>
                                            <input id="cantidadE" type="number" min="1" class="form-control" name="cantidadE" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1 col-lg-2" id="divprecioUE" style="display: block;">
                                    <div class="form-group">
                                        <label for="precioUE" class="control-label">Precio U.</label>
                                        <div>
                                            <input id="precioUE" disabled type="text" class="form-control" name="precioUE">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" id="divdescTipoPagoE" style="display: block;">
                                    <div class="form-group">
                                        <label for="descTipoPagoE" class="control-label">Descripcion</label>
                                        <div>
                                            <input id="descTipoPagoE" disabled type="text" class="form-control" name="descTipoPagoE">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="divsubtotalE" style="display: block;">
                                    <div class="form-group">
                                        <label for="subtotalE" class="control-label">Subtotal</label>
                                        <div>
                                            <input id="subtotalE" disabled type="text" class="form-control" name="subtotalE">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1" id="divcategoria_idE" style="display: none;">
                                    <div class="form-group">
                                        <label for="categoria_idE" class="control-label">categorida_id</label>
                                        <div>
                                            <input id="categoria_idE" disabled type="text" class="form-control" name="categoria_idE">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1" id="divButtonAgregarE" style="display: block;">
                                    <div class="form-group">
                                        <label for="buttonAgregarE" class="control-label"></label>
                                        <div>
                                            <a id="buttonAgregarE" class="btn btn-danger" name="buttonAgregarE" onclick="agregarproductofE()">+</a>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="row">
                                <div style="padding: 0px 26px;" id="detalleE">
                                    <table class="table table-striped table-hover" id="tablaDetalleE"><thead><tr><th style="display: none;">Código</th><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Descripcion</th><th>Subtotal</th><th style="display: none;">categoria_id</th><th>Eliminar</th></tr></thead>
                                        <tbody>
                                        @if(isset($detalleE))
                                            @foreach ($detalleE as $fila)
                                            <tr>
                                            <td style="display: none;">{!! $fila->codigoE; !!}</td>
                                            <td>{!! $fila->nombreCodigoE; !!}</td>
                                            <td>{!! $fila->cantidadE; !!}</td>
                                            <td>{!! $fila->precioUE; !!}</td>
                                            <td>{!! $fila->descripcionE; !!}</td>
                                            <td style="display: none;">{!! $fila->categoria_idE; !!}</td>
                                            <td align="right" class="subtotalE">{!! $fila->subtotal; !!}</td>
                                            <td><button class="form-button btn btn-danger" onclick="eliminardetalleE(this)" type="button">Eliminar</button></td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-2 col-sm-offset-8" id="divTotalE" style="display: block;">
                                    <div class="form-group">
                                        <label for="totalE" class="control-label">Total</label>
                                        <div>
                                            <input id="totalE" disabled type="text" class="form-control" name="totalE">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="p" class="desc" style="display: none"> <!-- Inicia vista Particular -->
                            <div class="row col-sm-offset-1">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="dpi" class="control-label">DPI</label>
                                        <div>
                                            <input type="number" id="dpi" name="dpi" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="nombre" class="control-label">Nombre</label>
                                        <div>
                                            <input type="text" id="nombre" name="nombre" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-sm-offset-1">
                                <div class="col-sm-2" id="divColegioP" style="display: block;">
                                    <div class="form-group">
                                        <label for="codigoP" class="control-label">Codigo</label>
                                        <select name="codigoP" class="form-control" id="codigoP">
                                            <option value="">-- Escoja --</option>
                                            @foreach ($tipo as $ti)
                                                <option value="{{ $ti->id }}">{{ $ti->codigo }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1" id="divCantidadP" style="display: block;">
                                    <div class="form-group">
                                        <label for="cantidadP" class="control-label">Cantidad</label>
                                        <div>
                                            <input id="cantidadP" type="number" min="1" class="form-control" name="cantidadP" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1 col-lg-2" id="divprecioUP" style="display: block;">
                                    <div class="form-group">
                                        <label for="precioUP" class="control-label">Precio U.</label>
                                        <div>
                                            <input id="precioUP" disabled type="text" class="form-control" name="precioUP">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" id="divdescTipoPagoP" style="display: block;">
                                    <div class="form-group">
                                        <label for="descTipoPagoP" class="control-label">Descripcion</label>
                                        <div>
                                            <input id="descTipoPagoP" disabled type="text" class="form-control" name="descTipoPagoP">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="divsubtotalP" style="display: block;">
                                    <div class="form-group">
                                        <label for="subtotalP" class="control-label">Subtotal</label>
                                        <div>
                                            <input id="subtotalP" disabled type="text" class="form-control" name="subtotalP">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1" id="divcategoria_idP" style="display: none;">
                                    <div class="form-group">
                                        <label for="categoria_idP" class="control-label">categorida_id</label>
                                        <div>
                                            <input id="categoria_idP" disabled type="text" class="form-control" name="categoria_idP">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1" id="divButtonAgregarP" style="display: block;">
                                    <div class="form-group">
                                        <label for="buttonAgregarP" class="control-label"></label>
                                        <div>
                                            <a id="buttonAgregarP" class="btn btn-danger" name="buttonAgregarP" onclick="agregarproductofP()">+</a>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                            <div class="row">
                                <div style="padding: 0px 26px;" id="detalleP">
                                    <table class="table table-striped table-hover" id="tablaDetalleP"><thead><tr><th style="display: none;">Código</th><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Descripcion</th><th>Subtotal</th><th style="display: none;">categoria_idP</th><th>Eliminar</th></tr></thead>
                                        <tbody>
                                        @if(isset($detalleP))
                                            @foreach ($detalleP as $fila)
                                            <tr>
                                            <td style="display: none;">{!! $fila->codigoP; !!}</td>
                                            <td>{!! $fila->nombreCodigoP; !!}</td>
                                            <td>{!! $fila->cantidadP; !!}</td>
                                            <td>{!! $fila->precioUP; !!}</td>
                                            <td>{!! $fila->descripcionP; !!}</td>
                                            <td style="display: none;">{!! $fila->categoria_idP; !!}</td>
                                            <td align="right" class="subtotalP">{!! $fila->subtotalP; !!}</td>
                                            <td><button class="form-button btn btn-danger" onclick="eliminardetalleP(this)" type="button">Eliminar</button></td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-sm-2 col-sm-offset-8" id="divTotalP" style="display: block;">
                                    <div class="form-group">
                                        <label for="totalP" class="control-label">Total</label>
                                        <div>
                                            <input id="totalP" disabled type="text" class="form-control" name="totalP">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</form>
    <div class="loader loader-bar"></div>

@endsection

@push('scripts')
<script src="{{asset('js/creacionRecibo/index.js')}}"></script>
<script>
    $(document).ready(function() {
        // $("#e").hide();
        // $("#p").hide();
        $("input[name$='tipoCliente']").click(function() {
            var test = $(this).val();
            $("div.desc").hide();
            $("#" + test).show();
            $('input[type="text"]').val('');
            $('input[type="number"]').val('');
            $('select[name="codigo"]').val('');
            $('select[name="codigoE"]').val('');
            $('select[name="codigoP"]').val('');
            $("tbody").children().remove()
    });
});
</script>

@endpush

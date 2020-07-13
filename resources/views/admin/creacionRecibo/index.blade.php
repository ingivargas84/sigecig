@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1><center>RECIBOS CIG</center></h1>
  </section>
  <style>
    table tbody tr:nth-child(even){
        background: white;
    }
  </style>

  @endsection

@section('content')




<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-body"  id="app">
            <br>
            <div class="">
                <div class="col-sm-3 col-md-3 col-lg-5">
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
                <div class="col-md-offset-5 col-sm-2 col-lg-2">
                    <div class="form-group">
                        <label for="serieRecibo" class="control-label">Serie de Recibo</label>
                        <div>
                            <label class="radio-inline">
                                <input name="serieRecibo" type="radio" id="serieReciboA" value="a">
                                A
                            </label>
                            <label class="radio-inline">
                                <input name="serieRecibo" checked="checked" type="radio" id="serieReciboB" value="b">
                                B
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <input name="emisionDeRecibo" id="emisionDeRecibo" style="display: none;">
            <div id="c" class="desc col-md-12 col-lg-12"> <!-- Inicia vista Colegiado -->
            {!! Form::open( array( 'id' => 'colegiadoForm' ) ) !!}
            <input name="tipoDeCliente" id="tipoDeCliente" value="c" style="display: none;">
            <input name="tipoSerieRecibo" id="tipoSerieRecibo" style="display: none;">

            <div class="loader loader-bar is-active"></div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="c_cliente" class="control-label">Colegiado</label>
                            <div>
                                <input type="number" id="c_cliente" name="c_cliente" class="form-control" min="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 col-md-7 col-lg-7">
                        <div class="form-group">
                            <label for="n_cliente" class="control-label">Nombres</label>
                            <div>
                                <input type="text" disabled id="n_cliente" name="n_cliente" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3" id="divStatus" style="display: block;">
                        <div class="form-group">
                            <label for="estado" class="control-label">Status</label>
                            <div>
                                <input id="estado" disabled type="text" class="form-control" name="estado" style="color: rgb(0, 128, 0)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5" id="divf_ult_timbre" style="display: block;">
                        <div class="form-group">
                            <label for="f_ult_timbre" class="control-label">Fecha de último pago de timbre</label>
                            <div>
                                <input id="f_ult_timbre" disabled type="text" class="form-control" name="f_ult_timbre" style="color: rgb(0, 128, 0)">
                                <input name="fechaTimbre" id="fechaTimbre" style="display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4" id="divf_ult_pago" style="display: block;">
                        <div class="form-group">
                            <label for="f_ult_pago" class="control-label">Fecha de último pago de colegio</label>
                            <div>
                                <input id="f_ult_pago" disabled type="text" class="form-control" name="f_ult_pago" style="color: rgb(0, 128, 0)">
                                <input name="fechaColegio" id="fechaColegio" style="display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3" id="divmontoTimbre" style="display: block;">
                        <div class="form-group">
                            <label for="monto_timbre" class="control-label">Pago timbre</label>
                            <div>
                                <input id="monto_timbre" disabled type="text" class="form-control" name="monto_timbre">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-9 col-lg-9" id="divComplemento" style="display: block;">
                        <div class="form-group">
                            <label for="complemento" class="control-label">Complemento</label>
                            <div>
                                <input id="complemento" type="text" class="form-control" name="complemento">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-lg-3" id="divFechaReactivacion" style="display: block;">
                        <div class="form-group">
                            <label for="fecha_pago" class="control-label">Fecha Reactivación</label>
                            <div>
                                <input id="fecha_pago" disabled type="date" class="form-control" name="fecha_pago">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-lg-2" id="divCdigo" style="display: block;">
                        <div class="form-group">
                            <label for="codigo" class="control-label">Código</label>
                            <select name="codigo" id="codigo" class="form-control" id="codigo">
                                <option value="">-- Escoja --</option>
                                @foreach ($tipo as $ti)
                                        <option value="{{ $ti->id }}">{{ $ti->codigo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col-lg-2" id="divCantidad" style="display: block;">
                        <div class="form-group">
                            <label for="cantidad" class="control-label">Cantidad</label>
                            <div>
                                <input id="cantidad" type="number" min="1" class="form-control" name="cantidad" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-lg-2" id="divprecioU" style="display: block;">
                        <div class="form-group">
                            <label for="precioU" class="control-label">Precio U.</label>
                            <div>
                                <input id="precioU" disabled type="text" class="form-control" name="precioU">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-lg-3" id="divdescTipoPago" style="display: block;">
                        <div class="form-group">
                            <label for="descTipoPago" class="control-label">Descripción</label>
                            <div>
                                <input id="descTipoPago" disabled type="text" class="form-control" name="descTipoPago">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-lg-2" id="divsubtotal" style="display: block;">
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
                    <div class="col-sm-1 col-lg-1" id="divButtonAgregar" style="display: block;">
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
                        <table class="table table-striped table-hover" id="tablaDetalle"><thead><tr><th style="display: none;">Código</th><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Descripción</th><th>Subtotal</th><th style="display: none;">categoria_id</th><th>Eliminar</th></tr></thead>
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
                            <label for="total" class="control-label">Total A Pagar</label>
                            <div>
                                <input id="total" disabled type="text" class="form-control" name="total" style="text-align:right;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="tipoDePago" class="control-label">TIPO DE PAGO</label>
                            <div>
                                <label class="checkbox-inline col-sm-2"><input type="checkbox" name="tipoDePago" id="tipoDePagoEfectivo" onchange="comprobarCheckEfectivo();" value="efectivo">Efectivo</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePago" id="tipoDePagoCheque" onchange="comprobarCheckCheque();" value="cheque">Cheque</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePago" id="tipoDePagoTarjeta" onchange="comprobarCheckTarjeta();" value="tarjeta">Tarjeta</label>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="number" id="montoefectivo" name="montoefectivo" class="form-control" min="0" readOnly placeholder="Monto">
                                <input name="pagoEfectivo" id="pagoEfectivo" value="" style="display: none;">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="number" id="montoCheque" name="montoCheque" class="form-control" min="0" readOnly placeholder="Monto">
                                <input name="pagoCheque" id="pagoCheque" value="" style="display: none;">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="number" id="montoTarjeta" name="montoTarjeta" class="form-control" min="0" readOnly placeholder="Monto">
                                <input name="pagoTarjeta" id="pagoTarjeta" value="" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="col-sm-offset-2 col-sm-3">
                            <div class="form-group">
                                <input type="number" id="cheque" name="cheque" class="form-control" placeholder="No. de cheque" min="0" style="display: none;">
                            </div>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <div class="form-group">
                                <input type="number" id="tarjeta" name="tarjeta" class="form-control" placeholder="No. de voucher" min="0" style="display: none;">
                            </div>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <div class="form-group">
                                <select name="pos" class="form-control" id="pos" style="display: none;">
                                    <option value="">-- Escoja POS --</option>
                                    @foreach ($pos as $po)
                                        <option value="{{ $po->id }}">{{ $po->pos_cobro }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="_token" id="equipoToken" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="">
                        <div class="col-md-3">
                            <a class="btn btn-success edit" style="padding: 6px 16px 6px 46px;" id="guardarRecibo" name="guardarRecibo">
                                GUARDAR <i class="green-icon fa fa-check-square" style="margin-left: 25px;"></i>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-primary" style="padding: 6px 16px 6px 46px;" id="nuevoRecibo" name="nuevoRecibo">
                                NUEVO <i class="blue-icon fa fa-plus-square" style="margin-left: 25px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

            <div id="e" class="desc col-md-12 col-lg-12" style="display: none"> <!-- Inicia vista de Empresa -->
            {!! Form::open( array( 'id' => 'empresaForm' ) ) !!}
            <input name="tipoDeCliente" id="tipoDeCliente" type="radio" value="e" style="display: none;">
            <input name="tipoSerieReciboE" id="tipoSerieReciboE" style="display: none;">
            <div class="loader loader-bar is-active"></div>
                <div class="row">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="nit" class="control-label">Nit</label>
                            <div>
                                <input type="text" id="nit" name="nit" required class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7 col-md-7 col-lg-7">
                        <div class="form-group">
                            <label for="empresa" class="control-label">Empresa</label>
                            <div>
                                <input type="text" disabled id="empresa" name="empresa" required class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-lg-2" id="divColegioE" style="display: block;">
                        <div class="form-group">
                            <label for="codigoE" class="control-label">Código</label>
                            <select name="codigoE" class="form-control" id="codigoE">
                                <option value="">-- Escoja --</option>
                                @foreach ($tipo as $ti)
                                        <option value="{{ $ti->id }}">{{ $ti->codigo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col-lg-2" id="divCantidadE" style="display: block;">
                        <div class="form-group">
                            <label for="cantidadE" class="control-label">Cantidad</label>
                            <div>
                                <input id="cantidadE" type="number" min="1" class="form-control" name="cantidadE" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-lg-2" id="divprecioUE" style="display: block;">
                        <div class="form-group">
                            <label for="precioUE" class="control-label">Precio U.</label>
                            <div>
                                <input id="precioUE" disabled type="text" class="form-control" name="precioUE">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-lg-3" id="divdescTipoPagoE" style="display: block;">
                        <div class="form-group">
                            <label for="descTipoPagoE" class="control-label">Descripción</label>
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
                    <div class="col-sm-1 col-lg-1" id="divcategoria_idE" style="display: none;">
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
                        <table class="table table-striped table-hover" id="tablaDetalleE"><thead><tr><th style="display: none;">Código</th><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Descripción</th><th>Subtotal</th><th style="display: none;">categoria_id</th><th>Eliminar</th></tr></thead>
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
                                <input id="totalE" disabled type="text" class="form-control" name="totalE" style="text-align:right;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="form-group">
                            <label for="tipoDePagoE" class="control-label">TIPO DE PAGO</label>
                            <div>
                                <label class="checkbox-inline col-sm-2"><input type="checkbox" name="tipoDePagoE" id="tipoDePagoEfectivoE" onchange="comprobarCheckEfectivoE();" value="efectivoE">Efectivo</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePagoE" id="tipoDePagoChequeE" onchange="comprobarCheckChequeE();" value="chequeE">Cheque</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePagoE" id="tipoDePagoTarjetaE" onchange="comprobarCheckTarjetaE();" value="tarjetaE">Tarjeta</label>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="number" id="montoefectivoE" name="montoefectivoE" class="form-control" min="0" readOnly placeholder="Monto">
                                <input name="pagoEfectivoE" id="pagoEfectivoE" value="" style="display: none;">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="number" id="montoChequeE" name="montoChequeE" class="form-control" min="0" readOnly placeholder="Monto">
                                <input name="pagoChequeE" id="pagoChequeE" value="" style="display: none;">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="number" id="montoTarjetaE" name="montoTarjetaE" class="form-control" min="0" readOnly placeholder="Monto">
                                <input name="pagoTarjetaE" id="pagoTarjetaE" value="" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="col-sm-offset-2 col-sm-3">
                            <div class="form-group">
                                <input type="number" id="chequeE" name="chequeE" class="form-control" placeholder="No. de cheque" min="0" style="display: none;">
                            </div>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <div class="form-group">
                                <input type="number" id="tarjetaE" name="tarjetaE" class="form-control" placeholder="No. de voucher" min="0" style="display: none;">
                            </div>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <div class="form-group">
                                <select name="posE" class="form-control" id="posE" style="display: none;">
                                    <option value="">-- Escoja POS --</option>
                                    @foreach ($pos as $po)
                                        <option value="{{ $po->id }}">{{ $po->pos_cobro }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="col-md-3">
                            <a class="btn btn-success edit" style="padding: 6px 16px 6px 46px;" id="guardarReciboE" name="guardarReciboE">
                                GUARDAR <i class="green-icon fa fa-check-square" style="margin-left: 25px;"></i>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-primary" style="padding: 6px 16px 6px 46px;">
                                NUEVO <i class="blue-icon fa fa-plus-square" style="margin-left: 25px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div id="p" class="desc col-md-12 col-lg-12" style="display: none"> <!-- Inicia vista Particular -->
            {!! Form::open( array( 'id' => 'particularForm' ) ) !!}
            <input name="tipoDeCliente" id="tipoDeCliente" type="radio" value="p" style="display: none;">
            <input name="tipoSerieReciboP" id="tipoSerieReciboP" style="display: none;">
            <div class="loader loader-bar is-active"></div>
                <div class="row">
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
                            <label for="nombreP" class="control-label">Nombre</label>
                            <div>
                                <input type="text" id="nombreP" name="nombreP" required class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="emailp" class="control-label">Email</label>
                        <input type="text" id="emailp" name="emailp" required class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-lg 2" id="divColegioP" style="display: block;">
                        <div class="form-group">
                            <label for="codigoP" class="control-label">Código</label>
                            <select name="codigoP" class="form-control" id="codigoP">
                                <option value="">-- Escoja --</option>
                                @foreach ($tipo as $ti)
                                        <option value="{{ $ti->id }}">{{ $ti->codigo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 col-lg-2" id="divCantidadP" style="display: block;">
                        <div class="form-group">
                            <label for="cantidadP" class="control-label">Cantidad</label>
                            <div>
                                <input id="cantidadP" type="number" min="1" class="form-control" name="cantidadP" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-lg-2" id="divprecioUP" style="display: block;">
                        <div class="form-group">
                            <label for="precioUP" class="control-label">Precio U.</label>
                            <div>
                                <input id="precioUP" disabled type="text" class="form-control" name="precioUP">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-lg-3" id="divdescTipoPagoP" style="display: block;">
                        <div class="form-group">
                            <label for="descTipoPagoP" class="control-label">Descripción</label>
                            <div>
                                <input id="descTipoPagoP" disabled type="text" class="form-control" name="descTipoPagoP">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-lg-2" id="divsubtotalP" style="display: block;">
                        <div class="form-group">
                            <label for="subtotalP" class="control-label">Subtotal</label>
                            <div>
                                <input id="subtotalP" disabled type="text" class="form-control" name="subtotalP">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1 col-lg-1" id="divcategoria_idP" style="display: none;">
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
                        <table class="table table-striped table-hover" id="tablaDetalleP"><thead><tr><th style="display: none;">Código</th><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Descripción</th><th>Subtotal</th><th style="display: none;">categoria_idP</th><th>Eliminar</th></tr></thead>
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
                                <input id="totalP" disabled type="text" class="form-control" name="totalP" style="text-align:right;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="form-group">
                            <label for="tipoDePagoP" class="control-label">TIPO DE PAGO</label>
                            <div>
                                <label class="checkbox-inline col-sm-2"><input type="checkbox" name="tipoDePagoP" id="tipoDePagoEfectivoP" onchange="comprobarCheckEfectivoP();" value="efectivoP">Efectivo</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePagoP" id="tipoDePagoChequeP" onchange="comprobarCheckChequeP();" value="chequeP">Cheque</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePagoP" id="tipoDePagoTarjetaP" onchange="comprobarCheckTarjetaP();" value="tarjetaP">Tarjeta</label>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <input type="number" id="montoefectivoP" name="montoefectivoP" class="form-control" min="0" readOnly placeholder="Monto">
                                <input name="pagoEfectivoP" id="pagoEfectivoP" value="" style="display: none;">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="number" id="montoChequeP" name="montoChequeP" class="form-control" min="0" readOnly placeholder="Monto">
                                <input name="pagoChequeP" id="pagoChequeP" value="" style="display: none;">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="number" id="montoTarjetaP" name="montoTarjetaP" class="form-control" min="0" readOnly placeholder="Monto">
                                <input name="pagoTarjetaP" id="pagoTarjetaP" value="" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="col-sm-offset-2 col-sm-3">
                            <div class="form-group">
                                <input type="number" id="chequeP" name="chequeP" class="form-control" placeholder="No. de cheque" min="0" style="display: none;">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="number" id="tarjetaP" name="tarjetaP" class="form-control" placeholder="No. de voucher" min="0" style="display: none;">
                            </div>
                        </div>
                        <div class="col-sm-3 col-lg-3">
                            <div class="form-group">
                                <select name="posP" class="form-control" id="posP" style="display: none;">
                                    <option value="">-- Escoja POS --</option>
                                    @foreach ($pos as $po)
                                        <option value="{{ $po->id }}">{{ $po->pos_cobro }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="col-md-3">
                            <a class="btn btn-success edit" style="padding: 6px 16px 6px 46px;" id="guardarReciboP" name="guardarReciboP">
                                GUARDAR <i class="green-icon fa fa-check-square" style="margin-left: 25px;"></i>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a class="btn btn-primary" style="padding: 6px 16px 6px 46px;">
                                NUEVO <i class="blue-icon fa fa-plus-square" style="margin-left: 25px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

<div class="loader loader-bar"></div>

@endsection

@push('scripts')
<script src="{{asset('js/creacionRecibo/index.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.loader').fadeOut(225);
        // $("#e").hide();
        // $("#p").hide();
        $("input[name$='tipoCliente']").click(function() {
            var test = $(this).val();
            $("div.desc").hide();
            $("#" + test).show();
            $('input[type="text"]').val('');
            $('input[type="number"]').val('');
            $('input[type="date"]').val('');
            $('select[name="codigo"]').val('');
            $('select[name="codigoE"]').val('');
            $('select[name="codigoP"]').val('');
            $("tbody").children().remove();
            $('input[name="tipoDePago"]').prop('checked', false);
            comprobarCheckEfectivo();
            comprobarCheckCheque();
            comprobarCheckTarjeta();
            $('input[name="tipoDePagoE"]').prop('checked', false);
            comprobarCheckEfectivoE();
            comprobarCheckChequeE();
            comprobarCheckTarjetaE();
            $('input[name="tipoDePagoP"]').prop('checked', false);
            comprobarCheckEfectivoP();
            comprobarCheckChequeP();
            comprobarCheckTarjetaP();
        });
    });
</script>

@endpush

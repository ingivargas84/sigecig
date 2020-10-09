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
        <input type="hidden" name="rol_user" id="rol_user" value="{{auth()->user()->id}}">
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
                <div class="col-md-offset-4 col-sm-3 col-lg-3">
                    <div class="col-md-4" id="divAspirante" style="display:none;">
                        <label for="aspirante" class="control-label">Aspirante
                            <div>
                                <input type="checkbox" id="aspirante" name="aspirante" onchange="getAspirante();" style="display: block;margin-left: auto;margin-right: auto;">
                            </div>
                        </label>
                    </div>

                    <div class="col-md-8">
                        <label for="serieRecibo" class="control-label">Serie de Recibo</label>
                        <div>
                            <label class="radio-inline" id="controlSerieA">
                                <input name="serieRecibo" type="radio" id="serieReciboA" value="a">
                                A
                            </label>
                            <label class="radio-inline" id="controlSerieB">
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
                                <input type="number" id="c_cliente" name="numeroColegiado" class="form-control" min="1">
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
                    <div class="col-sm-9 col-lg-9" id="divEmailC" style="display: block;">
                        <div class="form-group">
                            <label for="emailC" class="control-label">Email</label>
                            <div>
                                <input id="emailC" type="text" class="form-control" name="emailC">
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
                            <select name="codigo" id="codigo" class="selectpicker form-control" data-live-search="true" id="codigo">
                                <option value="">-- Escoja --</option>
                                @foreach ($tipo as $ti)
                                        <option value="{{ $ti->id }}">{{ $ti->codigo }} - <small>{{ $ti->tipo_de_pago }}</small></option>
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
                <div class="row" id="divExistencia">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="existencia" id="existencia" class="form-control" style="display:none;" readOnly>
                        </div>
                    </div>
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
                            <div class="col-md-2">
                                <label for="tipoDePago" class="control-label">TIPO DE PAGO</label>
                            </div>
                            <div class="col-md-10">
                                <div class="col-md-6 form-group" id="datoTc01" style="display: none;">
                                    <label for="tc01" class="control-label">TC01 / TIM1</label>
                                    <input id="tc01" disabled type="text" class="form-control" name="tc01" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc05" style="display: none;">
                                    <label for="tc05" class="control-label">TC05 / TIM5</label>
                                    <input id="tc05" disabled type="text" class="form-control" name="tc05" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc10" style="display: none;">
                                    <label for="tc10" class="control-label">TC10 / TIM10</label>
                                    <input id="tc10" disabled type="text" class="form-control" name="tc10" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc20" style="display: none;">
                                    <label for="tc20" class="control-label">TC20 / TIM20</label>
                                    <input id="tc20" disabled type="text" class="form-control" name="tc20" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc50" style="display: none;">
                                    <label for="tc50" class="control-label">TC50 / TIM 50</label>
                                    <input id="tc50" disabled type="text" class="form-control" name="tc50" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc100" style="display: none;">
                                    <label for="tc100" class="control-label">TC100 / TIM100</label>
                                    <input id="tc100" disabled type="text" class="form-control" name="tc100" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc200" style="display: none;">
                                    <label for="tc200" class="control-label">TC200 / TIM200</label>
                                    <input id="tc200" disabled type="text" class="form-control" name="tc200" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc500" style="display: none;">
                                    <label for="tc500" class="control-label">TC500 / TIM500</label>
                                    <input id="tc500" disabled type="text" class="form-control" name="tc500" style="text-align:left;">
                                </div>
                            </div>
                            <input id="cantidadDatosTc01" type="text" class="form-control" name="cantidadDatosTc01" style="display: none;">
                            <input id="cantidadDatosTc05" type="text" class="form-control" name="cantidadDatosTc05" style="display: none;">
                            <input id="cantidadDatosTc10" type="text" class="form-control" name="cantidadDatosTc10" style="display: none;">
                            <input id="cantidadDatosTc20" type="text" class="form-control" name="cantidadDatosTc20" style="display: none;">
                            <input id="cantidadDatosTc50" type="text" class="form-control" name="cantidadDatosTc50" style="display: none;">
                            <input id="cantidadDatosTc100" type="text" class="form-control" name="cantidadDatosTc100" style="display: none;">
                            <input id="cantidadDatosTc200" type="text" class="form-control" name="cantidadDatosTc200" style="display: none;">
                            <input id="cantidadDatosTc500" type="text" class="form-control" name="cantidadDatosTc500" style="display: none;">

                            <input id="tmCantTc01" type="text" class="form-control" name="tmCantTc01" style="display: none;">
                            <input id="tmCantTc01_2" type="text" class="form-control" name="tmCantTc01_2" style="display: none;">
                            <input id="tmCantTc01_3" type="text" class="form-control" name="tmCantTc01_3" style="display: none;">
                            <input id="tmCantTc05" type="text" class="form-control" name="tmCantTc05" style="display: none;">
                            <input id="tmCantTc05_2" type="text" class="form-control" name="tmCantTc05_2" style="display: none;">
                            <input id="tmCantTc05_3" type="text" class="form-control" name="tmCantTc05_3" style="display: none;">
                            <input id="tmCantTc10" type="text" class="form-control" name="tmCantTc10" style="display: none;">
                            <input id="tmCantTc10_2" type="text" class="form-control" name="tmCantTc10_2" style="display: none;">
                            <input id="tmCantTc10_3" type="text" class="form-control" name="tmCantTc10_3" style="display: none;">
                            <input id="tmCantTc20" type="text" class="form-control" name="tmCantTc20" style="display: none;">
                            <input id="tmCantTc20_2" type="text" class="form-control" name="tmCantTc20_2" style="display: none;">
                            <input id="tmCantTc20_3" type="text" class="form-control" name="tmCantTc20_3" style="display: none;">
                            <input id="tmCantTc50" type="text" class="form-control" name="tmCantTc50" style="display: none;">
                            <input id="tmCantTc50_2" type="text" class="form-control" name="tmCantTc50_2" style="display: none;">
                            <input id="tmCantTc50_3" type="text" class="form-control" name="tmCantTc50_3" style="display: none;">
                            <input id="tmCantTc100" type="text" class="form-control" name="tmCantTc100" style="display: none;">
                            <input id="tmCantTc100_2" type="text" class="form-control" name="tmCantTc100_2" style="display: none;">
                            <input id="tmCantTc100_3" type="text" class="form-control" name="tmCantTc100_3" style="display: none;">
                            <input id="tmCantTc200" type="text" class="form-control" name="tmCantTc200" style="display: none;">
                            <input id="tmCantTc200_2" type="text" class="form-control" name="tmCantTc200_2" style="display: none;">
                            <input id="tmCantTc200_3" type="text" class="form-control" name="tmCantTc200_3" style="display: none;">
                            <input id="tmCantTc500" type="text" class="form-control" name="tmCantTc500" style="display: none;">
                            <input id="tmCantTc500_2" type="text" class="form-control" name="tmCantTc500_2" style="display: none;">
                            <input id="tmCantTc500_3" type="text" class="form-control" name="tmCantTc500_3" style="display: none;">

                            <input id="tc01inicio" type="text" class="form-control" name="tc01inicio" style="display: none;">
                            <input id="tc05inicio" type="text" class="form-control" name="tc05inicio" style="display: none;">
                            <input id="tc10inicio" type="text" class="form-control" name="tc10inicio" style="display: none;">
                            <input id="tc20inicio" type="text" class="form-control" name="tc20inicio" style="display: none;">
                            <input id="tc50inicio" type="text" class="form-control" name="tc50inicio" style="display: none;">
                            <input id="tc100inicio" type="text" class="form-control" name="tc100inicio" style="display: none;">
                            <input id="tc200inicio" type="text" class="form-control" name="tc200inicio" style="display: none;">
                            <input id="tc500inicio" type="text" class="form-control" name="tc500inicio" style="display: none;">
                            <input id="tc01fin" type="text" class="form-control" name="tc01fin" style="display: none;">
                            <input id="tc05fin" type="text" class="form-control" name="tc05fin" style="display: none;">
                            <input id="tc10fin" type="text" class="form-control" name="tc10fin" style="display: none;">
                            <input id="tc20fin" type="text" class="form-control" name="tc20fin" style="display: none;">
                            <input id="tc50fin" type="text" class="form-control" name="tc50fin" style="display: none;">
                            <input id="tc100fin" type="text" class="form-control" name="tc100fin" style="display: none;">
                            <input id="tc200fin" type="text" class="form-control" name="tc200fin" style="display: none;">
                            <input id="tc500fin" type="text" class="form-control" name="tc500fin" style="display: none;">
                            <input id="tc01inicio2" type="text" class="form-control" name="tc01inicio2" style="display: none;">
                            <input id="tc05inicio2" type="text" class="form-control" name="tc05inicio2" style="display: none;">
                            <input id="tc10inicio2" type="text" class="form-control" name="tc10inicio2" style="display: none;">
                            <input id="tc20inicio2" type="text" class="form-control" name="tc20inicio2" style="display: none;">
                            <input id="tc50inicio2" type="text" class="form-control" name="tc50inicio2" style="display: none;">
                            <input id="tc100inicio2" type="text" class="form-control" name="tc100inicio2" style="display: none;">
                            <input id="tc200inicio2" type="text" class="form-control" name="tc200inicio2" style="display: none;">
                            <input id="tc500inicio2" type="text" class="form-control" name="tc500inicio2" style="display: none;">
                            <input id="tc01fin2" type="text" class="form-control" name="tc01fin2" style="display: none;">
                            <input id="tc05fin2" type="text" class="form-control" name="tc05fin2" style="display: none;">
                            <input id="tc10fin2" type="text" class="form-control" name="tc10fin2" style="display: none;">
                            <input id="tc20fin2" type="text" class="form-control" name="tc20fin2" style="display: none;">
                            <input id="tc50fin2" type="text" class="form-control" name="tc50fin2" style="display: none;">
                            <input id="tc100fin2" type="text" class="form-control" name="tc100fin2" style="display: none;">
                            <input id="tc200fin2" type="text" class="form-control" name="tc200fin2" style="display: none;">
                            <input id="tc500fin2" type="text" class="form-control" name="tc500fin2" style="display: none;">
                            <input id="tc01inicio3" type="text" class="form-control" name="tc01inicio3" style="display: none;">
                            <input id="tc05inicio3" type="text" class="form-control" name="tc05inicio3" style="display: none;">
                            <input id="tc10inicio3" type="text" class="form-control" name="tc10inicio3" style="display: none;">
                            <input id="tc20inicio3" type="text" class="form-control" name="tc20inicio3" style="display: none;">
                            <input id="tc50inicio3" type="text" class="form-control" name="tc50inicio3" style="display: none;">
                            <input id="tc100inicio3" type="text" class="form-control" name="tc100inicio3" style="display: none;">
                            <input id="tc200inicio3" type="text" class="form-control" name="tc200inicio3" style="display: none;">
                            <input id="tc500inicio3" type="text" class="form-control" name="tc500inicio3" style="display: none;">
                            <input id="tc01fin3" type="text" class="form-control" name="tc01fin3" style="display: none;">
                            <input id="tc05fin3" type="text" class="form-control" name="tc05fin3" style="display: none;">
                            <input id="tc10fin3" type="text" class="form-control" name="tc10fin3" style="display: none;">
                            <input id="tc20fin3" type="text" class="form-control" name="tc20fin3" style="display: none;">
                            <input id="tc50fin3" type="text" class="form-control" name="tc50fin3" style="display: none;">
                            <input id="tc100fin3" type="text" class="form-control" name="tc100fin3" style="display: none;">
                            <input id="tc200fin3" type="text" class="form-control" name="tc200fin3" style="display: none;">
                            <input id="tc500fin3" type="text" class="form-control" name="tc500fin3" style="display: none;">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div>
                                <label class="checkbox-inline col-sm-2"><input type="checkbox" name="tipoDePago" id="tipoDePagoEfectivo" onchange="comprobarCheckEfectivo();" value="efectivo">Efectivo</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePago" id="tipoDePagoCheque" onchange="comprobarCheckCheque();" value="cheque">Cheque</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePago" id="tipoDePagoTarjeta" onchange="comprobarCheckTarjeta();" value="tarjeta">Tarjeta</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePago" id="tipoDePagoDeposito" onchange="comprobarCheckDeposito();" value="deposito">Depósito</label>
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
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="number" id="montoDeposito" name="montoDeposito" class="form-control" min="0" readOnly placeholder="Monto">
                                <input name="pagoDeposito" id="pagoDeposito" value="" style="display: none;">
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
                                <input type="number" id="deposito" name="deposito" class="form-control" placeholder="No. de boleta" min="0" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="col-sm-offset-2 col-sm-3">
                            <div class="form-group">
                                <select name="banco" class="form-control" id="banco" style="display: none;">
                                    <option value="">-- Escoja Banco --</option>
                                    @foreach ($banco as $ba)
                                        <option value="{{ $ba->id }}">{{ $ba->nombre_banco }}</option>
                                    @endforeach
                                </select>
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
                        <div class="col-sm-3 col-lg-3">
                            <div class="form-group">
                                <input type="date" name="fechaDeposito" id="fechaDeposito" class="form-control" value="<?php echo date('Y-m-d');?>" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-8 col-sm-3">
                        <div class="form-group">
                            <select name="bancoDeposito" class="form-control" id="bancoDeposito" style="display: none;">
                                <option value="">-- Escoja Banco --</option>
                                @foreach ($banco as $ba)
                                    <option value="{{ $ba->id }}">{{ $ba->nombre_banco }}</option>
                                @endforeach
                            </select>
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
                            <a class="btn btn-primary" onclick="todoNuevo()" style="padding: 6px 16px 6px 46px;" id="nuevoRecibo" name="nuevoRecibo">
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
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label for="emailE" class="control-label">Empresa</label>
                            <div>
                                <input type="text" id="emailE" name="emailE" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-lg-2" id="divColegioE" style="display: block;">
                        <div class="form-group">
                            <label for="codigoE" class="control-label">Código</label>
                            <select name="codigoE" class="selectpicker form-control" data-live-search="true" id="codigoE">
                                <option value="">-- Escoja --</option>
                                @foreach ($tipo as $ti)
                                        <option value="{{ $ti->id }}">{{ $ti->codigo }} - <small>{{ $ti->tipo_de_pago }}</small></option>
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
                <div class="row" id="divExistenciaE">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="existenciaE" id="existenciaE" class="form-control" style="display:none;" readOnly>
                        </div>
                    </div>
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
                            <label for="totalE" class="control-label">Total A Pagar</label>
                            <div>
                                <input id="totalE" disabled type="text" class="form-control" name="totalE" style="text-align:right;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="tipoDePagoE" class="control-label">TIPO DE PAGO</label>
                            </div>
                            <div class="col-md-10">
                                <div class="col-md-6 form-group" id="datoTc01E" style="display: none;">
                                    <label for="tc01E" class="control-label">TE01</label>
                                    <input id="tc01E" disabled type="text" class="form-control" name="tc01E" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc05E" style="display: none;">
                                    <label for="tc05E" class="control-label">TE05</label>
                                    <input id="tc05E" disabled type="text" class="form-control" name="tc05E" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc10E" style="display: none;">
                                    <label for="tc10E" class="control-label">TE10</label>
                                    <input id="tc10E" disabled type="text" class="form-control" name="tc10E" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc20E" style="display: none;">
                                    <label for="tc20E" class="control-label">TE20</label>
                                    <input id="tc20E" disabled type="text" class="form-control" name="tc20E" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc50E" style="display: none;">
                                    <label for="tc50E" class="control-label">TE50</label>
                                    <input id="tc50E" disabled type="text" class="form-control" name="tc50E" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc100E" style="display: none;">
                                    <label for="tc100E" class="control-label">TE100</label>
                                    <input id="tc100E" disabled type="text" class="form-control" name="tc100E" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc200E" style="display: none;">
                                    <label for="tc200E" class="control-label">TE200</label>
                                    <input id="tc200E" disabled type="text" class="form-control" name="tc200E" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc500E" style="display: none;">
                                    <label for="tc500E" class="control-label">TE500</label>
                                    <input id="tc500E" disabled type="text" class="form-control" name="tc500E" style="text-align:left;">
                                </div>
                                <input id="tc01inicioE" type="text" class="form-control" name="tc01inicioE" style="display: none;">
                                <input id="tc05inicioE" type="text" class="form-control" name="tc05inicioE" style="display: none;">
                                <input id="tc10inicioE" type="text" class="form-control" name="tc10inicioE" style="display: none;">
                                <input id="tc20inicioE" type="text" class="form-control" name="tc20inicioE" style="display: none;">
                                <input id="tc50inicioE" type="text" class="form-control" name="tc50inicioE" style="display: none;">
                                <input id="tc100inicioE" type="text" class="form-control" name="tc100inicioE" style="display: none;">
                                <input id="tc200inicioE" type="text" class="form-control" name="tc200inicioE" style="display: none;">
                                <input id="tc500inicioE" type="text" class="form-control" name="tc500inicioE" style="display: none;">
                                <input id="tc01finE" type="text" class="form-control" name="tc01finE" style="display: none;">
                                <input id="tc05finE" type="text" class="form-control" name="tc05finE" style="display: none;">
                                <input id="tc10finE" type="text" class="form-control" name="tc10finE" style="display: none;">
                                <input id="tc20finE" type="text" class="form-control" name="tc20finE" style="display: none;">
                                <input id="tc50finE" type="text" class="form-control" name="tc50finE" style="display: none;">
                                <input id="tc100finE" type="text" class="form-control" name="tc100finE" style="display: none;">
                                <input id="tc200finE" type="text" class="form-control" name="tc200finE" style="display: none;">
                                <input id="tc500finE" type="text" class="form-control" name="tc500finE" style="display: none;">
                                <input id="tc01inicioE2" type="text" class="form-control" name="tc01inicioE2" style="display: none;">
                                <input id="tc05inicioE2" type="text" class="form-control" name="tc05inicioE2" style="display: none;">
                                <input id="tc10inicioE2" type="text" class="form-control" name="tc10inicioE2" style="display: none;">
                                <input id="tc20inicioE2" type="text" class="form-control" name="tc20inicioE2" style="display: none;">
                                <input id="tc50inicioE2" type="text" class="form-control" name="tc50inicioE2" style="display: none;">
                                <input id="tc100inicioE2" type="text" class="form-control" name="tc100inicioE2" style="display: none;">
                                <input id="tc200inicioE2" type="text" class="form-control" name="tc200inicioE2" style="display: none;">
                                <input id="tc500inicioE2" type="text" class="form-control" name="tc500inicioE2" style="display: none;">
                                <input id="tc01finE2" type="text" class="form-control" name="tc01finE2" style="display: none;">
                                <input id="tc05finE2" type="text" class="form-control" name="tc05finE2" style="display: none;">
                                <input id="tc10finE2" type="text" class="form-control" name="tc10finE2" style="display: none;">
                                <input id="tc20finE2" type="text" class="form-control" name="tc20finE2" style="display: none;">
                                <input id="tc50finE2" type="text" class="form-control" name="tc50finE2" style="display: none;">
                                <input id="tc100finE2" type="text" class="form-control" name="tc100finE2" style="display: none;">
                                <input id="tc200finE2" type="text" class="form-control" name="tc200finE2" style="display: none;">
                                <input id="tc500finE2" type="text" class="form-control" name="tc500finE2" style="display: none;">
                                <input id="tc01inicioE3" type="text" class="form-control" name="tc01inicioE3" style="display: none;">
                                <input id="tc05inicioE3" type="text" class="form-control" name="tc05inicioE3" style="display: none;">
                                <input id="tc10inicioE3" type="text" class="form-control" name="tc10inicioE3" style="display: none;">
                                <input id="tc20inicioE3" type="text" class="form-control" name="tc20inicioE3" style="display: none;">
                                <input id="tc50inicioE3" type="text" class="form-control" name="tc50inicioE3" style="display: none;">
                                <input id="tc100inicioE3" type="text" class="form-control" name="tc100inicioE3" style="display: none;">
                                <input id="tc200inicioE3" type="text" class="form-control" name="tc200inicioE3" style="display: none;">
                                <input id="tc500inicioE3" type="text" class="form-control" name="tc500inicioE3" style="display: none;">
                                <input id="tc01finE3" type="text" class="form-control" name="tc01finE3" style="display: none;">
                                <input id="tc05finE3" type="text" class="form-control" name="tc05finE3" style="display: none;">
                                <input id="tc10finE3" type="text" class="form-control" name="tc10finE3" style="display: none;">
                                <input id="tc20finE3" type="text" class="form-control" name="tc20finE3" style="display: none;">
                                <input id="tc50finE3" type="text" class="form-control" name="tc50finE3" style="display: none;">
                                <input id="tc100finE3" type="text" class="form-control" name="tc100finE3" style="display: none;">
                                <input id="tc200finE3" type="text" class="form-control" name="tc200finE3" style="display: none;">
                                <input id="tc500finE3" type="text" class="form-control" name="tc500finE3" style="display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div>
                                <label class="checkbox-inline col-sm-2"><input type="checkbox" name="tipoDePagoE" id="tipoDePagoEfectivoE" onchange="comprobarCheckEfectivoE();" value="efectivoE">Efectivo</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePagoE" id="tipoDePagoChequeE" onchange="comprobarCheckChequeE();" value="chequeE">Cheque</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePagoE" id="tipoDePagoTarjetaE" onchange="comprobarCheckTarjetaE();" value="tarjetaE">Tarjeta</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePagoE" id="tipoDePagoDepositoE" onchange="comprobarCheckDepositoE();" value="depositoE">Depósito</label>
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
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="number" id="montoDepositoE" name="montoDepositoE" class="form-control" min="0" readOnly placeholder="Monto">
                                <input name="pagoDepositoE" id="pagoDepositoE" value="" style="display: none;">
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
                                <input type="number" id="depositoE" name="depositoE" class="form-control" placeholder="No. de boleta" min="0" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="col-sm-offset-2 col-sm-3">
                            <div class="form-group">
                                <select name="bancoE" class="form-control" id="bancoE" style="display: none;">
                                    <option value="">-- Escoja Banco --</option>
                                    @foreach ($banco as $ba)
                                        <option value="{{ $ba->id }}">{{ $ba->nombre_banco }}</option>
                                    @endforeach
                                </select>
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
                        <div class="col-sm-3 col-lg-3">
                            <div class="form-group">
                                <input type="date" name="fechaDepositoE" id="fechaDepositoE" class="form-control" value="<?php echo date('Y-m-d');?>" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-8 col-sm-3">
                        <div class="form-group">
                            <select name="bancoDepositoE" class="form-control" id="bancoDepositoE" style="display: none;">
                                <option value="">-- Escoja Banco --</option>
                                @foreach ($banco as $ba)
                                    <option value="{{ $ba->id }}">{{ $ba->nombre_banco }}</option>
                                @endforeach
                            </select>
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
                            <a class="btn btn-primary" onclick="todoNuevo()" style="padding: 6px 16px 6px 46px;">
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
                                <input type="number" id="dpi" name="dpi" min="0" onchange="getAspirante();" required class="form-control">
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
                    <div class="col-sm-3">
                        <div class="form-group" style="display: none;" id="montotimbreDiv" name="montotimbreDiv">
                            <label for="monto_timbreP" class="control-label">Pago timbre</label>
                            <div>
                                <input type="text" id="monto_timbreP" name="monto_timbreP" readOnly class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 col-lg 2" id="divColegioP" style="display: block;">
                        <div class="form-group">
                            <label for="codigoP" class="control-label">Código</label>
                            <select name="codigoP" class="selectpicker form-control" data-live-search="true" id="codigoP">
                                <option value="">-- Escoja --</option>
                                @foreach ($tipo as $ti)
                                        <option value="{{ $ti->id }}">{{ $ti->codigo }} - <small>{{ $ti->tipo_de_pago }}</small></option>
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
                <div class="row" id="divExistenciaP">
                    <div class="col-md-3">
                        <div class="form-group">
                            <input type="text" name="existenciaP" id="existenciaP" class="form-control" style="display:none;" readOnly>
                        </div>
                    </div>
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
                            <label for="totalP" class="control-label">Total A Pagar</label>
                            <div>
                                <input id="totalP" disabled type="text" class="form-control" name="totalP" style="text-align:right;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="tipoDePagoP" class="control-label">TIPO DE PAGO</label>
                            </div>
                            <div class="col-md-10">
                                <div class="col-md-6 form-group" id="datoTc01P" style="display: none;">
                                    <label for="tc01P" class="control-label">TC01 / TIM1</label>
                                    <input id="tc01P" disabled type="text" class="form-control" name="tc01P" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc05P" style="display: none;">
                                    <label for="tc05P" class="control-label">TC05 / TIM5</label>
                                    <input id="tc05P" disabled type="text" class="form-control" name="tc05P" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc10P" style="display: none;">
                                    <label for="tc10P" class="control-label">TC10 / TIM10</label>
                                    <input id="tc10P" disabled type="text" class="form-control" name="tc10P" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc20P" style="display: none;">
                                    <label for="tc20P" class="control-label">TC20 / TIM20</label>
                                    <input id="tc20P" disabled type="text" class="form-control" name="tc20P" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc50P" style="display: none;">
                                    <label for="tc50P" class="control-label">TC50 / TIM50</label>
                                    <input id="tc50P" disabled type="text" class="form-control" name="tc50P" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc100P" style="display: none;">
                                    <label for="tc100P" class="control-label">TC100 / TIM100</label>
                                    <input id="tc100P" disabled type="text" class="form-control" name="tc100P" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc200P" style="display: none;">
                                    <label for="tc200P" class="control-label">TC200 / TIM200</label>
                                    <input id="tc200P" disabled type="text" class="form-control" name="tc200P" style="text-align:left;">
                                </div>
                                <div class="col-md-6 form-group" id="datoTc500P" style="display: none;">
                                    <label for="tc500P" class="control-label">TC500 / TIM500</label>
                                    <input id="tc500P" disabled type="text" class="form-control" name="tc500P" style="text-align:left;">
                                </div>
                                <input id="tc01inicioP" type="text" class="forsm-control" name="tc01inicioP" style="display: none;">
                                <input id="tc05inicioP" type="text" class="form-control" name="tc05inicioP" style="display: none;">
                                <input id="tc10inicioP" type="text" class="form-control" name="tc10inicioP" style="display: none;">
                                <input id="tc20inicioP" type="text" class="form-control" name="tc20inicioP" style="display: none;">
                                <input id="tc50inicioP" type="text" class="form-control" name="tc50inicioP" style="display: none;">
                                <input id="tc100inicioP" type="text" class="form-control" name="tc100inicioP" style="display: none;">
                                <input id="tc200inicioP" type="text" class="form-control" name="tc200inicioP" style="display: none;">
                                <input id="tc500inicioP" type="text" class="form-control" name="tc500inicioP" style="display: none;">
                                <input id="tc01finP" type="text" class="form-control" name="tc01finP" style="display: none;">
                                <input id="tc05finP" type="text" class="form-control" name="tc05finP" style="display: none;">
                                <input id="tc10finP" type="text" class="form-control" name="tc10finP" style="display: none;">
                                <input id="tc20finP" type="text" class="form-control" name="tc20finP" style="display: none;">
                                <input id="tc50finP" type="text" class="form-control" name="tc50finP" style="display: none;">
                                <input id="tc100finP" type="text" class="form-control" name="tc100finP" style="display: none;">
                                <input id="tc200finP" type="text" class="form-control" name="tc200finP" style="display: none;">
                                <input id="tc500finP" type="text" class="form-control" name="tc500finP" style="display: none;">
                                <input id="tc01inicioP2" type="text" class="form-control" name="tc01inicioP2" style="display: none;">
                                <input id="tc05inicioP2" type="text" class="form-control" name="tc05inicioP2" style="display: none;">
                                <input id="tc10inicioP2" type="text" class="form-control" name="tc10inicioP2" style="display: none;">
                                <input id="tc20inicioP2" type="text" class="form-control" name="tc20inicioP2" style="display: none;">
                                <input id="tc50inicioP2" type="text" class="form-control" name="tc50inicioP2" style="display: none;">
                                <input id="tc100inicioP2" type="text" class="form-control" name="tc100inicioP2" style="display: none;">
                                <input id="tc200inicioP2" type="text" class="form-control" name="tc200inicioP2" style="display: none;">
                                <input id="tc500inicioP2" type="text" class="form-control" name="tc500inicioP2" style="display: none;">
                                <input id="tc01finP2" type="text" class="form-control" name="tc01finP2" style="display: none;">
                                <input id="tc05finP2" type="text" class="form-control" name="tc05finP2" style="display: none;">
                                <input id="tc10finP2" type="text" class="form-control" name="tc10finP2" style="display: none;">
                                <input id="tc20finP2" type="text" class="form-control" name="tc20finP2" style="display: none;">
                                <input id="tc50finP2" type="text" class="form-control" name="tc50finP2" style="display: none;">
                                <input id="tc100finP2" type="text" class="form-control" name="tc100finP2" style="display: none;">
                                <input id="tc200finP2" type="text" class="form-control" name="tc200finP2" style="display: none;">
                                <input id="tc500finP2" type="text" class="form-control" name="tc500finP2" style="display: none;">
                                <input id="tc01inicioP3" type="text" class="form-control" name="tc01inicioP3" style="display: none;">
                                <input id="tc05inicioP3" type="text" class="form-control" name="tc05inicioP3" style="display: none;">
                                <input id="tc10inicioP3" type="text" class="form-control" name="tc10inicioP3" style="display: none;">
                                <input id="tc20inicioP3" type="text" class="form-control" name="tc20inicioP3" style="display: none;">
                                <input id="tc50inicioP3" type="text" class="form-control" name="tc50inicioP3" style="display: none;">
                                <input id="tc100inicioP3" type="text" class="form-control" name="tc100inicioP3" style="display: none;">
                                <input id="tc200inicioP3" type="text" class="form-control" name="tc200inicioP3" style="display: none;">
                                <input id="tc500inicioP3" type="text" class="form-control" name="tc500inicioP3" style="display: none;">
                                <input id="tc01finP3" type="text" class="form-control" name="tc01finP3" style="display: none;">
                                <input id="tc05finP3" type="text" class="form-control" name="tc05finP3" style="display: none;">
                                <input id="tc10finP3" type="text" class="form-control" name="tc10finP3" style="display: none;">
                                <input id="tc20finP3" type="text" class="form-control" name="tc20finP3" style="display: none;">
                                <input id="tc50finP3" type="text" class="form-control" name="tc50finP3" style="display: none;">
                                <input id="tc100finP3" type="text" class="form-control" name="tc100finP3" style="display: none;">
                                <input id="tc200finP3" type="text" class="form-control" name="tc200finP3" style="display: none;">
                                <input id="tc500finP3" type="text" class="form-control" name="tc500finP3" style="display: none;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div>
                                <label class="checkbox-inline col-sm-2"><input type="checkbox" name="tipoDePagoP" id="tipoDePagoEfectivoP" onchange="comprobarCheckEfectivoP();" value="efectivoP">Efectivo</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePagoP" id="tipoDePagoChequeP" onchange="comprobarCheckChequeP();" value="chequeP">Cheque</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePagoP" id="tipoDePagoTarjetaP" onchange="comprobarCheckTarjetaP();" value="tarjetaP">Tarjeta</label>
                                <label class="checkbox-inline col-sm-3"><input type="checkbox" name="tipoDePagoP" id="tipoDePagoDepositoP" onchange="comprobarCheckDepositoP();" value="depositoP">Depósito</label>
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
                        <div class="col-sm-3">
                            <div class="form-group">
                                <input type="number" id="montoDepositoP" name="montoDepositoP" class="form-control" min="0" readOnly placeholder="Monto">
                                <input name="pagoDepositoP" id="pagoDepositoP" value="" style="display: none;">
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
                                <input type="number" id="depositoP" name="depositoP" class="form-control" placeholder="No. de boleta" min="0" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="col-sm-offset-2 col-sm-3">
                            <div class="form-group">
                                <select name="bancoP" class="form-control" id="bancoP" style="display: none;">
                                    <option value="">-- Escoja Banco --</option>
                                    @foreach ($banco as $ba)
                                        <option value="{{ $ba->id }}">{{ $ba->nombre_banco }}</option>
                                    @endforeach
                                </select>
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
                        <div class="col-sm-3 col-lg-3">
                            <div class="form-group">
                                <input type="date" name="fechaDepositoP" id="fechaDepositoP" class="form-control" value="<?php echo date('Y-m-d');?>" style="display: none;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-offset-8 col-sm-3">
                        <div class="form-group">
                            <select name="bancoDepositoP" class="form-control" id="bancoDepositoP" style="display: none;">
                                <option value="">-- Escoja Banco --</option>
                                @foreach ($banco as $ba)
                                    <option value="{{ $ba->id }}">{{ $ba->nombre_banco }}</option>
                                @endforeach
                            </select>
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
                            <a class="btn btn-primary" onclick="todoNuevo()" style="padding: 6px 16px 6px 46px;">
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
<script src="{{asset('js/auxilio-postumo/bootstrap-select1.13.js')}}"></script>
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
            document.getElementById('existencia').style.display = "none";$('#existencia').val('');
            document.getElementById('existenciaE').style.display = "none";$('#existenciaE').val('');
            document.getElementById('existenciaP').style.display = "none";$('#existenciaP').val('');
            document.getElementById('montotimbreDiv').style.display = "none";;
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
            limpiarTimbres();
            cambioSerie();
            if ($('input[name=tipoCliente]:checked').val() == "p"){ document.getElementById('divAspirante').style.display = "";
            } else { document.getElementById('divAspirante').style.display = "none"; }
            if ($('input[name=tipoCliente]:checked').val() != "e"){ document.getElementById('controlSerieA').style.display = "";
            } else { document.getElementById('controlSerieA').style.display = "none"; }
            $("#aspirante").prop('checked', false);
        });
    });
</script>

@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auxilio-postumo/bootstrap-select1.13.css') }}">
@endpush

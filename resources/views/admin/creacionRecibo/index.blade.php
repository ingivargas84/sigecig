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
                            <div class="col-sm-3 col-md-offset-1">
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
                        <div id="c" class="desc">
                            <div class="row col-sm-offset-1">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="c_cliente" class="control-label">Colegiado</label>
                                        <div>
                                            <input type="text" id="c_cliente" name="c_cliente" required class="form-control">
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
                                <div class="col-sm-2" id="divPagoTimbre" style="display: block;">
                                    <div class="form-group">
                                        <label for="pagotimbre" class="control-label">Pago timbre</label>
                                        <div>
                                            <input id="pagotimbre" disabled type="text" class="form-control" name="pagotimbre">
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
                                <div class="col-sm-2" id="divColegio" style="display: block;">
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
                                <div class="col-sm-1" id="divprecioU" style="display: block;">
                                    <div class="form-group">
                                        <label for="precioU" class="control-label">Precio U.</label>
                                        <div>
                                            <input id="precioU" disabled type="text" class="form-control" name="precioU">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4" id="divdescTipoPagoColegiado" style="display: block;">
                                    <div class="form-group">
                                        <label for="descTipoPagoColegiado" class="control-label">Descripcion</label>
                                        <div>
                                            <input id="descTipoPagoColegiado" disabled type="text" class="form-control" name="descTipoPagoColegiado">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2" id="divsubtotalColegiado" style="display: block;">
                                    <div class="form-group">
                                        <label for="subtotalColegiado" class="control-label">Subtotal</label>
                                        <div>
                                            <input id="subtotalColegiado" disabled type="text" class="form-control" name="subtotalColegiado">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1" id="divButtonPlus" style="display: block;">
                                    <div class="form-group">
                                        <label for="buttonPlus" class="control-label"></label>
                                        <div>
                                            <button id="buttonPlus" class="btn btn-danger" name="buttonPlus" onclick="agregarproductof()">+</button>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <div class='container' id='detalle'>
                                    <table class="table table-striped table-hover" id="tablaDetalle"><thead><tr><th>Código</th><th>Cantidad</th><th>Precio U.</th><th>Leyenda</th><th>Subtotal</th><th>Eliminar</th></tr></thead>
                                        <tbody>
                                        @if(isset($detalle))
                                            @foreach ($detalle as $fila)
                                            <tr>
                                            <td>{!! $fila->codigo; !!}</td>
                                            <td>{!! $fila->cantidad; !!}</td>
                                            <td>{!! $fila->preciou; !!}</td>
                                            <td>{!! $fila->descripcion; !!}</td>
                                            <td align="right" class="subtotalVal">{!! $fila->subtotal; !!}</td>
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
                        <div id="e" class="desc">
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
        $("#e").hide();
        $("input[name$='tipoCliente']").click(function() {
            var test = $(this).val();
            $("div.desc").hide();
            $("#" + test).show();
    });
});
</script>

@endpush

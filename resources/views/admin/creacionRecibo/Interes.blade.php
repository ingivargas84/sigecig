@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1><center>CALCULO INTERES Y MORA CIG</center></h1>
  </section>

  @endsection

@section('content')
<form id="ReactivacionForm">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body"  id="app">
                <div class="col-md-offset-1">
                    <br>
                    <br>
                    <div class="form-group row">
                        <label for="c_cliente" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Colegiado</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="c_cliente" name="c_cliente" onChange="obtenerDatosColegiado()">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="checkbox-inline col-sm-2 col-md-offset-3"><input type="checkbox" name="exonerarInteresesTimbre" id="exonerarInteresesTimbre">Exonerar Intereses de Timbre</label>
                    </div>
                    <div class="form-group row">
                        <label for="monto_timbre" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Monto pago de Timbre</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="monto_timbre" name="monto_timbre">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="n_cliente" class="col-md-3  col-lg-3 col-form-label" style="text-align: right;">Nombre de Cliente</label>
                        <div class="col-md-7">
                            <input type="text" disabled class="form-control" id="n_cliente" name="n_cliente">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="estado" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Estado del colegiado</label>
                        <div class="col-md-7">
                            <input type="text" disabled class="form-control" id="estado" name="estado">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="f_ult_pago" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Fecha ultimo pago de Colegiado</label>
                        <div class="col-md-7">
                            <input type="text" disabled class="form-control" id="f_ult_pago" name="f_ult_pago">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="f_ult_timbre" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Fecha ultimo pago de Timbre</label>
                        <div class="col-md-7">
                            <input type="text" disabled class="form-control" id="f_ult_timbre" name="f_ult_timbre">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fecha_pago" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Fecha hasta donde paga</label>
                        <div class="col-md-7">
                            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="numeroCuotasTimbre" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Numero de Cuotas de Timbre</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="numeroCuotasTimbre" name="numeroCuotasTimbre">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="numeroCuotasColegio" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Numero de Cuotas de Colegio</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="numeroCuotasColegio" name="numeroCuotasColegio">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="capitalTimbre" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Capital Timbre</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="capitalTimbre" name="capitalTimbre">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="capitalColegio" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Capital Colegio</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="capitalColegio" name="capitalColegio">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="moraTimbre" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Mora de Timbre</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="moraTimbre" name="moraTimbre">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="interesTimbre" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Interes de Timbre</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="interesTimbre" name="interesTimbre">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="interesColegio" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Interes de Colegio</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="interesColegio" name="interesColegio">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="total" class="col-md-3 col-lg-3 col-form-label" style="text-align: right;">Total</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="total" name="total">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <a class="btn btn-primary" style="padding: 6px 16px 6px 46px;" id="generarReporte" name="generarReporte" onclick="get_monto_atrasado_timbre();">
                                Generar Reporte <i class="blue-icon fa fa-plus-square" style="margin-left: 25px;"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</form>

@endsection

<script src="{{asset('js/creacionRecibo/interes.js')}}"></script>

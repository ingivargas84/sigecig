<!-- Modal -->

<div class="modal fade" id="modalConfiguraFecha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'FormFechaAp') ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header new-modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center" id="myModalLabel">CONFIGURACION DE PAGO </h4>
            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-md-3" >
                        <label for="n_colegiado">Colegiado</label>
                        <input type="number" class="form-control" name="n_colegiado" readonly>
                    </div>
                    <div class="form-group col-md-9" >
                    <label for="Nombre1">Nombres</label>
                        <input type="text" size="50" maxlength="50" class="form-control" name="Nombre1" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Fecha de pago de transferencia:</label>
                        <input type="date" class="form-control col-sm-4" name="fecha_pago_ap">                        
                        {!! $errors->first('fecha_pago_ap', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group col-sm-8" >
                        <label for="nombre_banco">Banco</label>
                            <input type="text" class="form-control" name="nombre_banco" readonly>
                        </div>
                    <div class="form-group col-sm-4" >
                        <label for="tipo_cuenta">Tipo de Cuenta</label>
                        <input type="text" class="form-control" name="tipo_cuenta" readonly>
                        </div>
                    <div class="form-group col-sm-12" >
                        <label for="no_cuenta" >No. de cuenta</label>
                        <input type="text" class="form-control" name="no_cuenta" readonly>
                    </div>
                </div>
              <br>
              <input type="hidden" name="_token" id="equipoToken" value="{{ csrf_token() }}">
              <input type="hidden" name="idFecha">
            </div>
            <div class="modal-footer text-center">
                <button type="submit" class="btn btn-confirm" id="ButtonFechaPagoAp" >Enviar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>

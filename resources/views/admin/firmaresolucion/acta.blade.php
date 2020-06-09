<div class="modal fade" id="modalIngresoActa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'ActaForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header new-modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center" id="myModalLabel">Agregar Datos de Acta </h4>
            </div>
            <div class="modal-body">

                <div class="form-group col-sm-12">
            
                <div class="form-group col-md-9" >
                  <label for="Nombre1"> Agregar datos para el colegiado </label>
                        <input type="text" size="50" maxlength="50" class="form-control" name="Nombre1" >
                    </div>
  
                    </div>      
                <div>
                    <div class="form-group col-sm-12 {{ $errors->has('no_acta') ? 'has-error': '' }}" >
                        <label for="no_acta">No. Acta:</label>
                        <input type="number" class="form-control" placeholder="No. Acta:" name="no_acta">
                        {!! $errors->first('no_acta', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="no_punto_acta" class="col-form-label">Punto de Acta:</label>
                        <input type="number" class="form-control" placeholder="No. Punto de Acta:" name="no_punto_acta">
                    </div>
                </div>
              <br>
              <input type="hidden" name="_token" id="equipoToken" value="{{ csrf_token() }}">
              <input type="hidden" name="idSolicitud">
            </div>
            <div class="modal-footer text-center">
                <button type="submit" class="btn btn-confirm" id="ButtonActaModal" >Guardar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>

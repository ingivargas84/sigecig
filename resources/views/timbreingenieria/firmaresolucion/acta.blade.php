<div class="modal fade" id="modalIngresoActa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'ActaForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header new-modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center" id="myModalLabel">Agregar Datos de Acta </h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-sm-12 {{ $errors->has('codigo') ? 'has-error': '' }}" >
                        <label for="no_acta">No. Acta:</label>
                        <input type="text" class="form-control" placeholder="Código:" name="no_acta">
                        {!! $errors->first('no_acta', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="no_punto_acta" class="col-form-label">Punto de Acta:</label>
                        <input type="text" class="form-control" placeholder="No. Punto de Acta:" name="no_punto_acta">
                    </div>
                </div>
              <br>
              <input type="hidden" name="_token" id="equipoToken" value="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="ButtonTipoModal" >Guardar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>

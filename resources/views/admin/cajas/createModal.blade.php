<div class="modal fade" id="ingresoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'cajasForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center" id="myModalLabel">Agregar caja</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-sm-12 {{ $errors->has('cajas') ? 'has-error': '' }}" >
                        <label for="cajas">Código:</label>
                        <input type="text" class="form-control" placeholder="Cajas:" name="nombre_caja">
                        {!! $errors->first('nombre_caja', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="cajas" class="col-form-label">Nombre de Sede:</label>
                        <input type="text" class="form-control" placeholder="seleccione la sede:" name="subsede">
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="cajas">Precio para Colegiados:</label>
                        <input type="number" class="form-control" placeholder="Selecciona el Usuario:" name="cajero">
                    </div>
                </div>
              <br>
              <input type="hidden" name="_token" id="equipoToken" value="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
                <button type="submit" class="btn btn-primary" id="ButtonTipoModal" style="padding: 6px 46px">GUARDAR</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>

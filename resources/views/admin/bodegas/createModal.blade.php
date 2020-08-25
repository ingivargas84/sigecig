<div class="modal fade" id="ingresoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'BodegaForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center" id="myModalLabel">NUEVO REGISTRO</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-sm-12 {{ $errors->has('nombre_bodega') ? 'has-error': '' }}" >
                        <label for="nombre_bodega">Nombre de Bodega:</label>
                        <input type="text" class="form-control" placeholder="Ingrese bodega" name="nombre_bodega">
                        {!! $errors->first('nombre_bodega', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="descripcion">Descripción:</label>
                        <input type="text" class="form-control" placeholder="Descripción" name="descripcion">
                    </div>
                </div>
              <br>
              <input type="hidden" name="_token" id="tokenBo" value="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
                <button type="submit" class="btn btn-primary" id="ButtonTipoModal1" style="padding: 6px 46px">GUARDAR</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>

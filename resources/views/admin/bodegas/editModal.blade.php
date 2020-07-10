<!-- Modal -->

<div class="modal fade" id="editUpdateModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form method="POST" id="BodegaUpdate">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center" id="myModalLabel">Editar Caja</h4>
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
              <input type="hidden" name="_token" id="cajasToken" value="{{ csrf_token() }}">
              <input type="hidden" name="test">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary edit" id="ButtonTipoModalUpdate" >Actualizar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>

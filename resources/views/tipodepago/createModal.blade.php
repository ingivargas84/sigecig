<div class="modal fade" id="ingresoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'TipoPagoForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Tipo de Pago</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-sm-12 {{ $errors->has('codigo') ? 'has-error': '' }}" >
                        <label for="codigo">Código:</label>
                        <input type="text" class="form-control" placeholder="Código:" name="codigo">
                        {!! $errors->first('codigo', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="tipo_de_pago" class="col-form-label">Tipo De Pago:</label>
                        <input type="text" class="form-control" placeholder="Tipo de pago:" name="tipo_de_pago">
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="precio_colegiado">Precio para Colegiados:</label>
                        <input type="number" class="form-control" placeholder="Precio colegiados:" name="precio_colegiado">
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="precio_particular">Precio para Particulares:</label>
                        <input type="number" class="form-control" placeholder="Precio Particular:" name="precio_particular">
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="categoria_id">Categoría:</label>
                        <select name="categoria_id" class="form-control" id="categoria_id">
                            <option value="">-- Escoja la Categoría --</option>
                            @foreach ($cat as $cate)
                                <option value="{{ $cate->id }}">{{ $cate->categoria }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
              <br>
              <input type="hidden" name="_token" id="equipoToken" value="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="ButtonTipoModal" >Guardar</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>

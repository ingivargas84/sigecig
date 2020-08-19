<div class="modal fade" id="ingresoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'CajasForm' ) ) !!}
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center" id="myModalLabel">NUEVO REGISTRO</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-sm-12 {{ $errors->has('nombre_caja') ? 'has-error': '' }}" >
                        <label for="nombre_caja">Nombre de Caja:</label>
                        <input type="text" class="form-control" placeholder="Ingrese caja" name="nombre_caja">
                        {!! $errors->first('nombre_caja', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="subsede" class="col-form-label">Nombre de Subsede:</label>
                        <select name="subsede" class="form-control" id="subsede">
                          <option value="">-- Escoja la subsede --</option>
                          @foreach ($subsede as $su)
                              <option value="{{ $su->id }}">{{ $su->nombre_sede }}</option>
                          @endforeach
                      </select>                    
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="cajero">Cajero:</label>
                        <select name="cajero" class="form-control" id="cajero">
                          <option value="">-- Escoja el cajero --</option>
                          @foreach ($datos as $us)
                              <option value="{{ $us->id }}">{{ $us->name }}</option>
                          @endforeach
                      </select>     
                    </div>
                    <div class="form-group col-sm-12" >
                      <label for="bodega">Bodega:</label>
                      <select name="bodega" class="form-control" id="bodega">
                        <option value="">-- Escoja la bodega --</option>
                        @foreach ($datos1 as $bo)
                            <option value="{{ $bo->id }}">{{ $bo->nombre_bodega }}</option>
                        @endforeach
                    </select>     
                  </div>
                </div>
              <br>
              <input type="hidden" name="_token" id="equipoToken" value="{{ csrf_token() }}">
            </div>
            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
                <button type="submit" class="btn btn-primary" id="ButtonTipoModal1" style="padding: 6px 46px">GUARDAR</button>
            </div>
          </div>
    </div>
    {!! Form::close() !!}
</div>

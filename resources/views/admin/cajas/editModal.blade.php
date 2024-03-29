<!-- Modal -->

<div class="modal fade" id="editUpdateModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form method="POST" id="FormcajasUpdate">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center" id="myModalLabel">Editar Caja</h4>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="form-group col-sm-12 {{ $errors->has('nombre_caja') ? 'has-error': '' }}" >
                        <label for="nombre_caja">Nombre de Caja:</label>
                        <input type="text" class="form-control" name="nombre_caja">
                        {!! $errors->first('nombre_caja', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="subsede">Nombre de Subsede:</label>
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
                         {{--  <option value="{{$bds->id}}">{{$bds->nombre_bodega}}</option> --}}

                          @foreach ($datos as $us)
                              <option value="{{ $us->id }}">{{ $us->name }}</option>
                          @endforeach
                      </select>     
                    </div>
                    <div class="form-group col-sm-12" >
                        <label for="bodega">Bodega:</label>
                        <select name="bodega" class="form-control" id="bodega">
                          <option value="">-- Escoja la bodega --</option>
{{--                           <option value="{{$bodegaExiste->id}}">{{$bodegaExiste->nombre_bodega}}</option>
 --}}                          @foreach ($datos1 as $bo)
                              <option value="{{ $bo->id }}">{{ $bo->nombre_bodega }}</option>
                          @endforeach
                      </select>     
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
</form>
</div>

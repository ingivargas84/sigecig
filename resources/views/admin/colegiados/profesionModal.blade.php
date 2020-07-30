<!-- Modal -->

<div class="modal fade" id="ingresoModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form method="POST" id="ProfesionForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center" id="myModalLabel">Agregar Profesión</h4>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="form-group col-sm-12 {{ $errors->has('nombre_caja') ? 'has-error': '' }}" >
                        <label for="nombre_caja">Profesión:</label>
                        <input id="nombreProfesion" type="text" class="form-control" name="nombreProfesion">
                        <input id="idprofesion" type="hidden" class="form-control" name="idprofesion">
                        {!! $errors->first('nombre_caja', '<span class="help-block">:message</span>') !!}
                    </div>
                <hr>
                    <button type="submit" class="btn btn-primary" id="ButtonTipoModalUpdate" >Guardar Profesión</button>

                    <div class="form-group col-sm-12" >
                        <label for="subsede">Especialidad</label>
                        <input id="nombreEspecialidad" type="text" class="form-control" name="nombreEspecialidad">
                        <input id="idespecialidad" type="hidden" class="form-control" name="idespecialidad">
                    </div>
                 
                </div>
              <br>
              <input type="hidden" name="_token" id="cajasToken" value="{{ csrf_token() }}">
              <input type="hidden" name="test">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="ButtonTipoModalUpdate" >Guardar Especialidad</button>
            </div>
          </div>
    </div>
</div>
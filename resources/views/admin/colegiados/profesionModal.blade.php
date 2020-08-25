



<div class="modal fade" id="ingresoModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <form method="POST" id="ProfesionForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center" id="myModalLabel">Agregar Profesión</h4>
            </div>
                <div class="modal-body" style="z-index: -1;position:static">
                    
                    <div class="row" >
                          <div class="col-sm-5" >
                            <label for="nombre">Nombres:</label>
                            <input id="nombre" class="form-control" name="nombre" type="text" readonly>  
                          </div>
                          <div class="col-sm-5" >
                            <label for="dpi">DPI:</label>
                            <input id="dpi" class="form-control" name="dpi" type="text" readonly>  
                          </div>
                    </div>
                    <div class="row" >      
                        <div class="form-group col-sm-12" >
                            <label for="idprofesion">Profesión:</label>
                             <select class="form-control selectpicker" id="idprofesion" name="idprofesion" data-live-search="true">
                                 @foreach($resultado as $re)
                             <option value="{{$re->id}}">{{$re->nombre}}</option>
                             @endforeach  
                            </select> 
                        </div>
                        <center><button id="agregarProfesion" onclick="agregarProfesionF()" class="form-button btn btn-primary" type="button">Agregar profesión</button></center>
                        <div class="form-group col-sm-12" >
                            <label for="idespecialidad">Especialidad</label>
                            <select class="form-control selectpicker" id="idespecialidad" name="idespecialidad" data-live-search="true">
                              @foreach($esp as $es)
                          <option value="{{$es->id}}">{{$es->nombre}}</option>
                          @endforeach  
                         </select> 
                        </div>
                        <center><button id="agregarEspecialidad" onclick="agregarEspecialidadF()" class="form-button btn btn-primary" type="button">Agregar especialidad</button></center>            
                    </div>
                </div>
              <br>
              <input type="hidden" name="_token" id="tokenUser" value="{{ csrf_token() }}">
              <input type="hidden" name="test">
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
    </div>
    </form>
</div>

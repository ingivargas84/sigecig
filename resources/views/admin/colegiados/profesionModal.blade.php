<!-- Modal -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

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
                            <label for="nombre">Agregar profesión para:</label>
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
</div>
@push('scripts')
<script src="{{asset('js/colegiados/index.js')}}"></script>
<script src="{{asset('/ea/jquery-ui.min.js')}}"></script>
<script src="{{asset('/ea/jquery.mask.min.js')}}"></script>
<script src="{{asset('js/colegiados/add.js')}}"></script>

 {{--<script src="{{asset('ea/jquery.auto-complete.js')}}"></script>
<script src="{{asset('/ea/jquery.auto-complete.min.js')}}"></script> 
<script src="{{asset('/ea/bootstrap.min.js')}}"></script>--}}
@endpush
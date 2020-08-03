<!-- Modal -->

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
                            <input id="dpi" class="form-control" name="dpi" type="text" readonly>  
                          </div>
                    </div>
                    <div class="row" >      
                        <div class="form-group col-sm-12" >
                            <label for="nombreProfesion">Profesión:</label>
                            <input id="nombreProfesion" autofocus="" class="form-control nombreProfesion ui-autocomplete-input" placeholder="Licenciado en matemáticas" name="nombreProfesion" type="text" autocomplete="off"  >
                            <input id="idprofesion" type="hidden" name="idprofesion">
                        </div>
                        <center><button id="agregarProfesion" onclick="agregarProfesionF()" class="form-button btn btn-primary" type="button">Agregar profesión</button></center>
                        <div class="form-group col-sm-12" >
                            <label for="nombreEspecialidad">Especialidad</label>
                            <input id="nombreEspecialidad" autofocus="" class="form-control nombreEspecialidad ui-autocomplete-input" placeholder="Doctor en matemática" name="nombreEspecialidad" type="text" autocomplete="off" >
                            <input id="idespecialidad" type="hidden" name="idespecialidad" >
                        </div>
                        <center><button id="agregarEspecialidad" onclick="agregarEspecialidadF()" class="form-button btn btn-primary" type="button">Agregar especialidad</button></center>            
                    </div>
                </div>
              <br>
              <input type="hidden" name="_token" id="tokenUser" value="{{ csrf_token() }}">
              <input type="hidden" name="test">
            </div>
            <div class="modal-footer">
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
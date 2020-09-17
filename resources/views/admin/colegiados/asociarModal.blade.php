<!-- Modal -->

<div class="modal fade" id="ingresoModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
  <form method="POST" id="AsociarForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center" id="myModalLabel">Asociar Colegiado</h4>
            </div>
                <div class="modal-body" style="z-index: -1;position:static">
                    
                    <div class="row" >
                          <div class="col-sm-5" >
                            <label for="nombre2">Nombres:</label>
                            <input id="nombre2" class="form-control" name="nombre2" type="text" readonly>  
                          </div>
                          <div class="col-sm-5" >
                            <label for="dpi2">DPI:</label>
                            <input id="dpi2" class="form-control" name="dpi2" type="text" readonly>  
                        </div>
                    </div>
                    <div class="row" >      
                        <div class="form-group col-sm-6" >
                            <label for="colegiado" class="control-label">Numero de colegiado:</label>                            
                            <input id="colegiado" class="form-control" name="colegiado" type="text" value="{{$ult[0]->colegiado}}">
                        </div>
                        <div class="form-group col-sm-6" >
                            <label for="fechaColegiado" class="control-label">Fecha colegiado:</label>                            
                            <input id="fechaColegiado" class="form-control" name="fechaColegiado" onchange="cambiarEndDate2()" type="date">                        
                        </div>
                    </div>
                    <div class="row" >      
                      <div class="form-group col-sm-6" >
                            <label for="fechaUltimoPagoColegio" class="control-label">Colegio pagado hasta:</label>                            
                            <input id="fechaUltimoPagoColegio" class="form-control" name="fechaUltimoPagoColegio" type="text" required readonly>                    
                          </div>
                      <div class="form-group col-sm-6" >
                            <label for="fechaUltimoPagoTimbre" class="control-label">Timbre pagado hasta:</label>                            
                            <input id="fechaUltimoPagoTimbre" class="form-control" name="fechaUltimoPagoTimbre" type="text" required readonly>                      
                          </div>
                      <center><button id="ButtonAsociar" class="form-button btn btn-success" type="button">Asociar Aspirante</button> </center>                   
                  </div>
                </div>
              <br>
              <input type="hidden" name="_token" id="tokenAs" value="{{ csrf_token() }}">
              <input type="hidden" name="test">
            <div class="modal-footer">
              <center><button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
    </div>
  </form>
</div>
{{-- @push('scripts')
<script src="{{asset('js/colegiados/index.js')}}"></script>
<script src="{{asset('/ea/jquery-ui.min.js')}}"></script>
<script src="{{asset('/ea/jquery.mask.min.js')}}"></script>
<script src="{{asset('js/colegiados/asociar.js')}}"></script>
@endpush --}}
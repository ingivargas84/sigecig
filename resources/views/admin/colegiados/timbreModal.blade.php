<!-- Modal -->

<div class="modal fade" id="ingresoModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
    <form method="POST" id="TimbreForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center" id="myModalLabel">Agregar Timbre</h4>
            </div>
                <div class="modal-body" style="z-index: -1;position:static">
                    
                    <div class="row" >
                          <div class="col-sm-5" >
                            <label for="nombre">Nombres:</label>
                            <input id="nombre1" class="form-control" name="nombre1" type="text" readonly>  
                          </div>
                          <div class="col-sm-5" >
                            <label for="dpi1">DPI:</label>
                            <input id="dpi1" class="form-control" name="dpi1" type="text" readonly>  
                        </div>
                    </div>
                    <br>
                    <div class="row" >      
                        <div class="form-group col-sm-12" >
                            <label for="montoTimbre" class="control-label">Monto de timbre a pagar</label>                            
                            <input id="montoTimbre" class="form-control" value="25.00" name="montoTimbre" type="number">
                        </div>
                        <center><button id="guardarTimbre" class="btn btn-primary" type="button">Agregar monto timbre</button></center>                
                         </div>
                </div>
              <br>
              <input type="hidden" name="_token" id="tokenTim" value="{{ csrf_token() }}">
              <input type="hidden" name="test">
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
    </div>
  </form>
</div>

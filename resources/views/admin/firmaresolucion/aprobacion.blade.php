
<div class="modal fade" id="modalAprobacionJunta" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">APROBACIÓN JUNTA DIRECTIVA</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group" STYLE="text-align: center">
            <a href="" class="btn btn-success" id="aprobarSolicitud" type="button">APROVADO</a>
            <a href="" class="btn btn-danger" id="rechazarSolicitud">RECHAZADO</a>
            <div id="divmsga1" style="display: none; color:green;" class="alert alert-primary" role="alert" ></div>
          </div>
          <div style="min-height: 150px ">
          <div class="form-group" id="text-area" style="display: none " >
            <label for="">Motivo del Rechazo</label>
            <textarea class="form-control" id="mensaje" name="mensaje"style="max-width: 560px; min-height: 200px"></textarea>
            <input type="number" class="form-control" name="id_solicitud" style="display: none">
          </div>
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="enviarRechazo"  style="display: none" >ENVIAR</button >
        <div id="divmsga" style="display: none; color:green;" class="alert alert-primary" role="alert" ></div>
      </div>
    </div>
    <input type="hidden" id="no_solicitud" name="no_solicitud" value="" style="display: none">
   
  </div>
</div>

<div class="modal fade" id="modalAprobacionJunta" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius: 20px 20px 0px 0px">
      <div class="modal-header" style="text-align: center; border-radius: 15px 15px 0px 0px; ">
        <h4 class="modal-title" style="line-height: 0; " id="exampleModalLabel">Aprobación de Junta Auxilio Póstumo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: none">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group col-md-9" >
          <label for="Nombre1"> Agregar datos de acta para el colegiado: </label>
          <input type="text" size="50" maxlength="50" class="form-control" name="Nombre1" readonly>
        </div>
        <div class="form-group col-md-3" >
            <label for="no_solicitud"> Solicitud</label>
            <input type="text" size="50" maxlength="50" class="form-control" name="no_solicitud" readonly>
          </div>
        <form>
          <div class="form-group" style="text-align: center; font-weight: bold">
            <a href="" class="btn btn-success" id="aprobarSolicitud" type="button">APROBADO</a>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-secondary" id="enviarRechazo"  style="display: none; background: #858585; width: 150px" >ENVIAR</button >
        <div id="divmsga" style="display: none; color:green;" class="alert alert-primary" role="alert" ></div>
      </div>
    </div>
    <input type="hidden" id="no_solicitud" name="no_solicitud" value="" style="display: none">
   
  </div>
</div>
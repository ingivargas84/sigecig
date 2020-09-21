<div class="modal fade" id="modalReportePorRango" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form method="POST" id="AsociarForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Reporte por Rango</h4>
            </div>
            <div class="modal-body">
                <form action="{{route('timbres.reporte')}}" method="GET" role="form" id="form-timbres" name="form-timbres" target="_blank">
                    <div class="form-group col-md-12">
                        <label for="caja"> Caja: </label>
                        <select id="cajaActiva" name="cajaActiva" class="selectpicker form-control" data-live-search="true">
                            <option selected>Elija una caja</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="c_cliente"> Colegiado desde:</label>
                        <input type="number" size="50" maxlength="50" class="form-control" name="c_cliente" id="c_cliente" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="c_cliente2"> Hasta:</label>
                        <input type="number" size="50" maxlength="50" class="form-control" name="c_cliente" id="c_cliente">
                    </div>
                    <div class="form-group" style="text-align: center; font-weight: bold; margin-top: 10px">
                        <button  class="btn btn-success" id="ver-reporte-timbres" type="submit" style="margin-top: 20px">GENERAR REPORTE</button>
                        </div>
            </div>
            <div class="modal-footer">
                <center><button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
        </div>
        <input type="hidden" id="no_solicitud" name="no_solicitud" value="" style="display: none">
    </form>
    </div>



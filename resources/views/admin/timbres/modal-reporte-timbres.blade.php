<div class="modal fade" id="modalReporteTimbres" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 20px 20px 0px 0px">
            <div class="modal-header" style="text-align: center; border-radius: 15px 15px 0px 0px; ">
                <h4 class="modal-title" style="line-height: 0; " id="exampleModalLabel">Reporte de timbres</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: none">
                    <span aria-hidden="true">&times;</span>
                </button>
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
                        <label for="fecha-inicial"> Fecha Inicial:</label>
                        <input type="date" size="50" maxlength="50" class="form-control" name="fechaInicial" id="fechaInicial" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fecha-final"> Fecha Final:</label>
                        <input type="date" size="50" maxlength="50" class="form-control" name="fechaFinal" id="fechaFinal">
                    </div>
                    <div class="form-group" style="text-align: center; font-weight: bold; margin-top: 10px">
                        <button  class="btn btn-success" id="ver-reporte-timbres" type="submit" style="margin-top: 20px">GENERAR REPORTE</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <div id="divmsga" style="display: none; color:green;" class="alert alert-primary" role="alert"></div>
            </div>
        </div>
        <input type="hidden" id="no_solicitud" name="no_solicitud" value="" style="display: none">
    </div>



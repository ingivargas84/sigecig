<div class="modal fade" id="modalReporteVentasXyz" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 20px 20px 0px 0px">
            <div class="modal-header" style="text-align: center; border-radius: 15px 15px 0px 0px; ">
                <h4 class="modal-title" style="line-height: 0; " id="exampleModalLabel">Reporte de Ventas XYZ</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: none">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('ventasxyz.reporte')}}" method="GET" role="form" id="form-vetas-xyz" name="form-ventas_xyz" target="_blank">
                    <div class="form-group col-md-6">
                        <label for="fecha-inicial"> Fecha Inicial:</label>
                        <input type="date" size="50" maxlength="50" class="form-control" name="fechaInicialVenta" id="fechaInicialVenta" >
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fecha-final"> Fecha Final:</label>
                        <input type="date" size="50" maxlength="50" class="form-control" name="fechaFinalVenta" id="fechaFinalVenta">
                    </div>
                    <div class="form-group" style="text-align: center; font-weight: bold; margin-top: 10px">
                        <button  class="btn btn-success" id="ver-reporte-ventas" type="submit" style="margin-top: 20px">GENERAR REPORTE</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <div id="divmsga" style="display: none; color:green;" class="alert alert-primary" role="alert"></div>
            </div>
        </div>
        {{-- <input type="hidden" id="no_solicitud" name="no_solicitud" value="" style="display: none"> --}}
    </div>



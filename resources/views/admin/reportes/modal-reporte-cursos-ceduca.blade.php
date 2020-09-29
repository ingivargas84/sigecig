<div class="modal fade" id="modalReporteCursosCeduca" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 20px 20px 0px 0px">
            <div class="modal-header" style="text-align: center; border-radius: 15px 15px 0px 0px; ">
                <h4 class="modal-title" style="line-height: 0; " id="exampleModalLabel">Reporte de Cursos de CEDUCA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="display: none">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('cursos.ceduca')}}" method="GET" role="form" id="form-cursos-ceduca" name="form-timbres" target="_blank">
                    <div class="form-group col-md-12">
                        <label for="tipoDePago"> Curso: </label>
                        <select id="cursos" name="cursos" class="selectpicker form-control" data-live-search="true">
                            <option selected>Elija un curso</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group" style="text-align: center; font-weight: bold; margin-top: 10px">
                        <button  class="btn btn-success" id="ver-reporte-ceduca" type="submit" style="margin-top: 20px">GENERAR REPORTE</button>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <div id="divmsga" style="display: none; color:green;" class="alert alert-primary" role="alert"></div>
            </div>
        </div>
    </div>

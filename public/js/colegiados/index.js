var colegiados_table = $('#colegiados-table').DataTable({
    "ajax": "/colegiados/getJson",
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
    ],

    "buttons": [
    'pageLength',
    'excelHtml5',
    'csvHtml5'
    ],

    "paging": true,
    "language": {
        "sdecimal":        ".",
        "sthousands":      ",",
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],
    "columns": [ 
        {
            "title": "No. Colegiado",
            "data": "dpi", 
            "width" : "5%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "Nombre",
            "data": "nombre", 
            "width" : "25%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "Carrera",
            "data": "carrera", 
            "width" : "35%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        }, 
        {
            "title": "Estado",
            "data": "estado",
            "width" : "15%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
    {
        "title": "Acciones",
        "data": "c_cliente",
        "orderable": false,
        "width" : "20%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();
/*              if(data == true){  //Estado 2 de la solicitud
 */ 
                    return "<div id='" + full.dpi + "' class='text-center'>" +
                    "<div class='float-right col-lg-3'>" +
                    "<a href='"+urlActual+"/detalles/"+full.dpi+"'"+ "data-method='post' data-dpi='"+full.dpi+"' data-nit='"+full.nit+"'>" +
                    "<i class='fa fa-info-circle' title='Detalles'></i>" +
                    "</a>" + "</div>" +
                    "<div id='" + full.dpi + "' class='text-center'>" +
                    "<div class='float-right col-lg-3'>" +
                    "<a href='#' class='add-profesion' data-toggle='modal' data-target='#ingresoModal2' data-dpi='"+full.dpi+"' data-nombre='"+full.nombre+"' data-carrera_afin='"+full.carrera_afin+"' >" +
                    "<i class='fa fa-plus-square' title='Agregar Profesion'></i>" +
                    "</a>" + "</div>" +
       /*       }
            else if(data == null){    //Estado 1 de la solicitud  */

                    "<div id='" + full.dpi + "' class='text-center'>" +
                    "<div class='float-right col-lg-3'>" +
                    "<a href='#' class='add-timbre' data-toggle='modal' data-target='#ingresoModal3' data-dpi1='"+full.dpi+"' data-nombre1='"+full.nombre+"' data-carrera_afin='"+full.carrera_afin+"'>" +
                    "<i class='fa fa-info' title='Información de Timbres'></i>" +
                    "</a>" + "</div>" +
                    "<div id='" + full.dpi + "' class='text-center'>" +
                    "<div class='float-right col-lg-3'>" +
                    "<a href='#' class='add-asociar' data-toggle='modal' data-target='#ingresoModal4' data-dpi2='"+full.dpi+"' data-nombre2='"+full.nombre+"'>" +
                    "<i class='fa fa-sync' title='Asociar Colegiado'></i>" +
                    "</a>" + "</div>"
           /*   }
            else return "";  */
        },
        "responsivePriority": 1
    }]

});

//Confirmar Contraseña para borrar
$("#btnConfirmarAccion").click(function(event) {
    event.preventDefault();
    if ($('#ConfirmarAccionForm').valid()) {
        confirmarAccion();
    } else {
        validator.focusInvalid();
    }
});

var aspirantes_table = $('#aspirantes-table').DataTable({
    "ajax": "/aspirantes/getJsonAsp",
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "destroy": true,

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
            "visible": false,
            "title": "Id",
            "data": "id", 
            "width" : "1%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "DPI",
            "data": "codigo", 
            "width" : "5%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "Nombre",
            "data": "colegiado", 
            "width" : "40%",
            "responsivePriority": 2,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
         {
            "title": "Estado",
            "data": "estado",
            "width" : "20%",
            "responsivePriority": 2,
            "render": function( data, type, full, meta ) {
                return (data);},
        }, 
    {
        "title": "Acciones",
        "data": "estado",
        "orderable": false,
        "width" : "30%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();
            if (parseInt(full.activo)== 1) {
                return "<div id='" + full.codigo + "' class='text-center'>" +
                "<div class='float-right col-lg-3'>" +
                "<a href='aspirante/detalles/"+full.codigo+"'"+ "data-method='post' dallfull.codigo='"+full.codigo+"' data-nombre='"+full.colegiado+"'>" +
                "<i class='fa fa-info-circle' title='Detalles'></i>" +
                "</a>" + "</div>" +
                "<div id='" + full.codigo + "' class='text-center'>" +
                "<div class='float-right col-lg-3'>" +
                "<a href='#' class='add-profesion' data-toggle='modal' data-target='#ingresoModal2' data-dpi='"+full.codigo+"' data-nombre='"+full.colegiado+"'>" +
                "<i class='fa fa-plus-square' title='Agregar Profesion'></i>" +
                "</a>" + "</div>" +

                "<div id='" + full.codigo + "' class='text-center'>" +
                "<div class='float-right col-lg-3'>" +
                "<a href='#' class='add-timbre' data-toggle='modal' data-target='#ingresoModal3' data-dpi1='"+full.codigo+"' data-nombre1='"+full.colegiado+"'>" +
                "<i class='fa fa-info' title='Información de Timbres'></i>" +
                "</a>" + "</div>" +
                "<div id='" + full.codigo + "' class='text-center'>" +
                "<div class='float-right col-lg-3'>" +
                "<a href='#' class='add-asociar' data-toggle='modal' data-target='#ingresoModal4' data-dpi2='"+full.codigo+"' data-nombre2='"+full.colegiado+"'>" +
                "<i class='fa fa-check-square' title='Asociar Colegiado'></i>" +
                "</a>" + "</div>";
            }else{
                return "<div id='" + full.codigo + "' class='text-center'>" +
                "<div class='float-right col-lg-3'>" +
                "<a href='aspirante/detalles/"+full.codigo+"'"+ "data-method='post' dallfull.codigo='"+full.codigo+"' data-nombre='"+full.colegiado+"'>" +
                "<i class='fa fa-info-circle' title='Detalles'></i>" +
                "</a>" + "</div>" +
                "<div id='" + full.codigo + "' class='text-center'>" +
                "<div class='float-right col-lg-3'>" +
                "<a href='aspirante/edit/"+full.codigo+"'"+ "data-method='post' data.codigo='"+full.codigo+"' data-nombre='"+full.colegiado+"'>" +
                "<i class='fa fa-edit' title='Editar'></i>" +
                "</a>" + "</div>" +
                "<div id='" + full.codigo + "' class='text-center'>" +
                "<div class='float-right col-lg-3'>" +
                "<a href='#' class='add-profesion' data-toggle='modal' data-target='#ingresoModal2' data-dpi='"+full.codigo+"' data-nombre='"+full.colegiado+"'>" +
                "<i class='fa fa-plus-square' title='Agregar Profesion'></i>" +
                "</a>" + "</div>" +

                "<div id='" + full.codigo + "' class='text-center'>" +
                "<div class='float-right col-lg-3'>" +
                "<a href='#' class='add-timbre' data-toggle='modal' data-target='#ingresoModal3' data-dpi1='"+full.codigo+"' data-nombre1='"+full.colegiado+"'>" +
                "<i class='fa fa-info' title='Información de Timbres'></i>" +
                "</a>" + "</div>";
            }

        },
        "responsivePriority": 1
    }]
});

var cortedecaja_table = $('#cortedecaja-table').DataTable({
  //  "ajax": "/bodegas/getJson",
    "responsive": true,
    "processing": true,
    "searching": false,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
    ],

    "buttons": [
  /*   'pageLength',
    'excelHtml5',
    'csvHtml5' */
    ],

    "paging": false,
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
            "title": "ID",
            "data": "id",
            "width" : "2%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "No. Recibo",
            "data": "numero_recibo",
            "width" : "25%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "Total",
            "data": "monto_total",
            "width" : "25%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return('Q.'+data.toFixed(2));},
        },
        {
            "title": "Serie",
            "data": "serie_recibo_id",
            "width" : "25%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "25%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();

                return "<div id='" + full.id + "' class='text-center'>" +
                "<div class='float-center'>" +
                "<a href='/creacionRecibo/pdf/"+full.numero_recibo+ "/' target='_blank' data-numero_recibo='"+full.numero_recibo+"' data-monto_total='"+full.monto_total+"'>" +
                "<i class='fa fa-info-circle' title='Ver Detalles'></i>" +
                "</a>" + "</div>";
                
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

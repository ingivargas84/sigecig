var resolucion_table = $('#resolucion-table').DataTable({
    "ajax": "/estadocuenta/getJson",
    "responsive": true,
    "retrieve": true,
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
    'csvHtml5',
    'pdfHtml5'
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
    "columns": [ {
        "visible": false,
        "title": "No.",
        "data": "id",
        "width" : "0%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
        },
        {
            "visible": false,
            "title": "id",
            "data": "id",
            "width" : "0%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
            },



            {
                "title": "Colegiado",
                "data": "cliente",
                "width" : "10%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
                }, 
                
                
   

                    {
                        "title": "Nombre",
                        "data": "n_cliente",
                        "width" : "40%",
                        "responsivePriority": 1,
                        "render": function( data, type, full, meta ) {
                            return (data);},
                        }, 

                        {
                            "title": "Estado",
                            "data": "estado",
                            "width" : "15%",
                            "responsivePriority": 2,
                            "render": function( data, type, full, meta ) {
                                return (data);},
                            }, 
                            {
                                "title": "Saldo",
                                "data": "registro",
                                "width" : "15%",
                                "responsivePriority": 2,
                                "render": function( data, type, full, meta ) {
                                    return (data);},
                                }, 
                       

                            {
                                "title": "Acciones",
                                "data": "estado_solicitud_ap",
                                "orderable": false,
                                "width" : "15%",
                                "render": function(data, type, full, meta) {
                                    var urlActual = $("input[name='urlActual']").val();
                                    var rol = $("input[name='rol_user']").val();

                return "<div class='text-center'>" + 
                "<div class='float-center '>" +
                "<a href='/estadocuenta/detallado/" + full.id + "' class='asap' >" + 
                "<i class='fa fa-info' title='Ver Detalles'></i>" + 
                "</a>" + "</div>";
            
        },
        "responsivePriority": 4
    }

                            ]
});






    

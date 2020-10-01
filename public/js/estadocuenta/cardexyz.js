var resolucion_table = $('#resolucion-table').DataTable({
    "ajax": "/estadocuenta/getxyz/$id",
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
    {
        extend: 'pdfHtml5',
        filename: function(){
           
            let numeroColegiado = $('#noColegiado').val();
            return 'Kardex-'+numeroColegiado;
            },
            exportOptions: {
                columns: [ 1, 2, 3, 4, 5, 6 ]}
    }
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
        "data": "c_cliente",
        "width" : "0%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
        },
        {
            "visible": false,
            "title": "id",
            "data": "c_cliente",
            "width" : "0%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
            },



            {
                "title": "Tipo de Pago",
                "data": "descripcion",
                "width" : "15%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
                }, 
                
                {
                    "title": "Cantidad",
                    "data": "cantidad",
                    "width" : "7%",
                    "responsivePriority": 1,
                    "render": function( data, type, full, meta ) {
                        return "<div class='text-right' >" + 
                                "<div class='float-left col-lg-1'>Q." + "</div>" +
                                "<div class='float-right col-lg-8' style='color:black; float:right;'>" + (data)+
                                "</div>";},
                    },

                        {
                            "title": "Precio",
                            "data": "precio_u",
                            "width" : "7%",
                            "responsivePriority": 1,
                            "render": function( data, type, full, meta ) {
                                return "<div class='text-right' >" + 
                                        "<div class='float-left col-lg-1'>Q." + "</div>" +
                                        "<div class='float-right col-lg-8' style='color:black; float:right;'>" + (data)+
                                        "</div>";},
                            },
                            {
                                "title": "Total",
                                "data": "importe",
                                "width" : "7%",
                                "responsivePriority": 1,
                                "render": function( data, type, full, meta ) {
                                    return "<div class='text-right' >" + 
                                            "<div class='float-left col-lg-1'>Q." + "</div>" +
                                            "<div class='float-right col-lg-8' style='color:black; float:right;'>" + (data)+
                                            "</div>";},
                                },
                                {
                                    "title": "No. Factura",
                                    "data": "num_fac",
                                    "width" : "5%",
                                    "responsivePriority": 2,
                                    "render": function( data, type, full, meta ) {
                                        return (data);},
                                    }, 
                                    {
                                        "title": "Fecha",
                                        "data": "fecha",
                                        "width" : "5%",
                                        "responsivePriority": 2,
                                        "render": function( data, type, full, meta ) {
                                            return (data);},
                                        }, 


                            ]
});
var resolucion_table = $('#resolucion-table').DataTable({
    "ajax": "/resolucion/getJson",
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
        "title": "No. Colegiado",
        "data": "n_colegiado",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Nombre",
        "data": "Nombre1",
        "width" : "50%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Estado Solicitud",
        "data": "estado_solicitud_ap",
        "width" : "30%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Acciones",
        "data": "estado_solicitud_ap",
        "orderable": false,
        "width" : "10%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual =  $("input[name='urlActual']").val();
            if(rol_user == 'Timbre' && data == 'AprobadaJunta'){

                return "<div class='text-center'>" + 
                "<div class='float-center'>" + 
                "<a href='/pdf'>" +
                "<i class='fas fa-print' title='Imprimir'></i>" + 
                "</a>" + "</div>";
            }
            else if(rol_user == 'Timbre' && data == 'ResolucionFirmada'){

                return "<div id='" + full.id + "' class='text-center'>" + 
                "<div class='float-center'>" + 
                "<a href='#' class='edit-user' data-toggle='modal' data-target='#modalUpdateUser' data-id='"+full.id+"' data-email='"+full.email+"' data-username='"+full.username+"' data-rol='"+full.rol+"' data-name_user='"+full.name+"'>" + 
                "<i class='fas fa-flag' title='Cambiar estado'></i>" + 
                "</a>" + "</div>";
            }
           
            
        },
        "responsivePriority": 4
    }]

});



/*function confirmar() {
    var txt;
    if (confirm("Press a button!")) {
      txt = "You pressed OK!";
    } else {
      txt = "You pressed Cancel!";
    }
    document.getElementById("demo").innerHTML = txt;
  }*/
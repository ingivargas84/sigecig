var historial_table = $('#historial-table').DataTable({
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
        //  "sSearch":         "Buscar:",
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
                "title": "ID",
                "data": "id",
                "width" : "5%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
          },
          {
                "title": "Monto Total",
                "data": "monto_total",
                "width" : "8%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
          },
          {
                "title": "Efectivo",
                "data": "total_efectivo",
                "width" : "8%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
        },
          {
                "title": "Cheque",
                "data": "total_cheque",
                "width" : "8%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
        },
            {
                "title": "Tarjeta",
                "data": "total_tarjeta",
                "width" : "8%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
        },
            {
                "title": "Depósito",
                "data": "total_deposito",
                "width" : "8%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
        },
            {
                "title": "Usuario",
                "data": "name",
                "width" : "8%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
        },
            {
                "title": "Caja",
                "data": "nombre_caja",
                "width" : "8%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
        },
             {
                "title": "Fecha de Corte",
                "data": "fecha_corte",
                "width" : "8%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
        }, 
        {
            "title": "Acciones",
            "orderable": false,
            "width" : "5%",
            "render": function(data, type, full, meta) {
                var rol_user = $("input[name='rol_user']").val();
                var urlActual = $("input[name='urlActual']").val();
    
                    return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-center'>" +
                    "<a href='"+urlActual+"/pdf/"+full.id+"/' target='_blank'>" +
                    "<i class='fa fa-print' title='Imprimir'></i>" +
                    "</a>" + "</div>";
                    
            },
            "responsivePriority": 0,

        }]
  });
  
var totales_table = $('#totales-table').DataTable({
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
                "title": "Total Efectivo",
                "data": "monto_efectivo",
                "width" : "25%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
          },
          {
                "title": "Total Cheque",
                "data": "montocheque",
                "width" : "25%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
          },
          {
                "title": "Total Deposito",
                "data": "montodep",
                "width" : "25%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
        },


          {
                "title": "Total Tarjeta",
                "data": "montotarjeta",
                "width" : "25%",
                "responsivePriority": 1,
                "render": function( data, type, full, meta ) {
                    return (data);},
        },
        {
            "visible": false,
            "title": "Acciones",
            "orderable": false,
            "width" : "25%",
            "render": function(data, type, full, meta) {
                var rol_user = $("input[name='rol_user']").val();
                var urlActual = $("input[name='urlActual']").val();
    
                    return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-center'>" +
                    "<a href='/estadocuenta/detallado/"+full.id+"/' class='detalle' data-monto_total='"+full.monto_total+"'>" +
                    "<i class='fa fa-info-circle' title='Ver Detalles'></i>" +
                    "</a>" + "</div>";
                    
            },
            "responsivePriority": 0,

        }]
  });
  
$(document).on('click', 'a.corte-caja', function(e) {
    e.preventDefault(); // does not go through with the link.
    alertify.defaults.theme.ok = "btn btn-confirm";
    var button = $(e.currentTarget);
    var monto_total = button[0].dataset.monto_total;
    var caja = button[0].dataset.caja;
   // var combo = document.getElementById("monto_total");
    var today = new Date().toLocaleDateString();    
    var $this = $(this);

    alertify.confirm('Corte de Caja', 'Está seguro de realizar el corte de caja con un monto de Q.' + monto_total + ' correspondientes a la fecha ' + today + ' asignados a la caja X?',
    function(){
        $('.loader').fadeIn();
        $.post({
            type: $this.data('method'),
            url: $this.attr('href')
        }).done(function (data) {
            $('.loader').fadeOut(225);
            totales_table.ajax.reload();
                alertify.set('notifier','position', 'top-center');
                alertify.success('Corte de caja ingresado con exito');
        });
        }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancelar')
        });
});
  
  
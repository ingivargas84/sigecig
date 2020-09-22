var cajas_table = $('#cajas-table').DataTable({
    "ajax": "/cajas/getJson",
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
            "title": "Id",
            "data": "id",
            "width" : "10%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "Nombre Caja",
            "data": "nombre_caja",
            "width" : "20%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "Subsede",
            "data": "nombre_sede",
            "width" : "20%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "Cajero",
            "data": "name",
            "width" : "20%",
            "responsivePriority": 2,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "Bodega",
            "data": "nombre_bodega",
            "width" : "20%",
            "responsivePriority": 2,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "10%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();

            if(full.estado == 1){
                return "<div id='" + full.id + "' class='text-center'>" +
                "<div class='float-left col-lg-4'>" +
                "<a href='#' class='edit-cajas' data-toggle='modal' data-method='post' data-target='#editUpdateModal1' data-id='" + full.id + "' data-nombre_caja='" + full.nombre_caja + "' data-subsede='"+full.subsede+"' data-cajero='"+full.cajero+"' data-bodega='"+full.bodega+"'>" +
                "<i class='fa fa-btn fa-edit' title='Editar Registro'></i>" +
                "</a>" + "</div>" +
                "<div id='" + full.id + "' class='text-center'>" +
                "<div class='float-right col-lg-4'>" +
                "<a href='"+urlActual+"/"+full.id+"/destroy' class='destroy-cajas'"+ "data-method='post' data-id='"+full.id+"' >" +
                "<i class='fa fa-thumbs-down' title='Desactivar Caja'></i>" +
                "</a>" + "</div>";
                }else{
                    return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-right col-lg-6'>" +
                    "<a href='"+urlActual+"/"+full.id+"/activar' class='activar-cajas'"+ "data-method='post' data-id='"+full.id+"' >" +
                    "<i class='fa fa-thumbs-up' title='Activar Caja'></i>" +
                    "</a>" + "</div>" 
                }
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

$(document).on('click', 'a.destroy-cajas', function(e) {
    e.preventDefault(); // does not go through with the link.
    alertify.defaults.theme.ok = "btn btn-error";
    var button = $(e.currentTarget);
    var $this = $(this);
    alertify.confirm('Desactivar Caja', 'Esta seguro de desactivar la caja?',
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                cajas_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Caja desactivada con Éxito!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancelar')
        });
});

$(document).on('click', 'a.activar-cajas', function(e) {
    e.preventDefault(); // does not go through with the link.
    alertify.defaults.theme.ok = "btn btn-confirm";
    var button = $(e.currentTarget);
    var $this = $(this);
    alertify.confirm('Activar caja', 'Esta seguro de activar la caja?',
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                cajas_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Caja activada con Éxito!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancelar')
        });
});

$(document).on('click', 'a.delete-Cajas', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    alertify.confirm('Eliminar Cajas', 'Esta seguro de eliminar la Boleta',
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                cajas_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Boleta Cajas con Éxito!!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancelar')
        });
});


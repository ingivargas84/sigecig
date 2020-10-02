var anulacion_table = $('#anulacion-table').DataTable({
    //"ajax": "/boletas/getJson",
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

    "columns": [ {
        "title": "Recibo",
        "data": "recibo",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Colegiado",
        "data": "colegiado",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Nombre Colegiado",
        "data": "nombre",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Cajero",
        "data": "cajero",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Fecha De Anulación",
        "data": "fecha_respuesta",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Estado",
        "data": "estado",
        "width" : "10%",
        "responsivePriority": 4,
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

                return "<div id='" + full.id + "' class='text-center'>" +
                "<div class='float-left col-lg-4'>" +
                "<a href='"+urlActual+"/edit/"+full.id+"' class='edit-boleta' >" +
                "<i class='fa fa-btn fa-edit' title='Editar boleta'></i>" +
                "</a>" + "</div>" +
                "<div class='float-right col-lg-4'>" +
                "<a href='"+urlActual+"/"+full.id+"/destroy' class='destroy-boleta'"+ "data-method='post' data-id='"+full.id+"' >" +
                "<i class='fa fa-thumbs-down' title='Rechazar Boleta'></i>" +
                "</a>" + "</div>" +
                "<div class='float-right col-lg-4'>" +
                "<a href='"+urlActual+"/"+full.id+"/delete' class='delete-boleta'"+ "data-method='post' data-id='"+full.id+"' >" +
                "<i class='fa fa-trash' title='Eliminar Boleta'></i>" +
                "</a>" + "</div>";

        },
        "responsivePriority": 5
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

$(document).on('click', 'a.destroy-boleta', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    alertify.confirm('Desactivar boleta', 'Esta seguro de Rechazar la boleta',
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                boletas_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Boleta desactivada con Éxito!!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancelar')
        });
});

$(document).on('click', 'a.activar-boleta', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    alertify.confirm('Aprobar boleta', 'Esta seguro de aprobar la Boleta',
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                boletas_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Boleta aprobada con Éxito!!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancelar')
        });
});

$(document).on('click', 'a.delete-boleta', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    alertify.confirm('Eliminar Boleta', 'Esta seguro de eliminar la Boleta',
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                boletas_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Boleta eliminada con Éxito!!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancelar')
        });
});


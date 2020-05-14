var subsedes_table = $('#subsedes-table').DataTable({
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
        {
            extend: 'excelHtml5',
            filename: 'Cig_Subsdes_fecha',
        },
        {
            extend: 'csvHtml5',
            filename: 'Cig_Subsdes_fecha',
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
        "title": "Nombre de Sede",
        "data": "nombre_sede",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Dirección",
        "data": "direccion",
        "width" : "30%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Teléfono",
        "data": "telefono",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Teléfono 2",
        "data": "telefono_2",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Correo Electrónico",
        "data": "correo_electronico",
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
                "<a href='"+urlActual+"/edit/"+full.id+"' class='edit-sede' >" +
                "<i class='fa fa-btn fa-edit' title='Editar sede'></i>" +
                "</a>" + "</div>" +
                "<div class='float-right col-lg-4'>" +
                "<a href='"+urlActual+"/"+full.id+"/destroy' class='destroy-sede'"+ "data-method='post' data-id='"+full.id+"' >" +
                "<i class='fa fa-thumbs-down' title='Desactivar Sede'></i>" +
                "</a>" + "</div>";

            } else{
                if(rol_user == 'Super-Administrador' || rol_user == 'Administrador'){
                    return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-right col-lg-6'>" +
                    "<a href='"+urlActual+"/"+full.id+"/activar' class='activar-sede'"+ "data-method='post' data-id='"+full.id+"' >" +
                    "<i class='fa fa-thumbs-up' title='Activar Sede'></i>" +
                    "</a>" + "</div>";
                }else{
                    return "<div id='" + full.id + "' class='text-center'>" + "</div>";
                }

            }


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

$(document).on('click', 'a.destroy-sede', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    alertify.confirm('Desactivar Sede', 'Esta seguro en desactivar la sede',
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                subsedes_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Sede desactivada con Éxito!!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancelar')
        });
});

$(document).on('click', 'a.activar-sede', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    alertify.confirm('Activar Sede', 'Esta seguro de activar la Sede',
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                subsedes_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success(' la sede ha sido activada con Éxito!!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancelar')
        });
});


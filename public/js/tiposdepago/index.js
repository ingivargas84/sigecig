var tipodepago_table = $('#tipodepago-table').DataTable({
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [10, 25, 50, -1],
        ['10 filas', '25 filas', '50 filas', 'Mostrar todo']
    ],
    "buttons": [
        'pageLength',
        {
            extend: 'excelHtml5',
            filename: function(){
                        var D = new Date()
                        var d = D.getDate();
                        var m = D.getMonth()+1;
                        var y = D.getFullYear();
                        var h = D.getHours();
                        var min = D.getMinutes();
                        var seg = D.getSeconds();
                        return 'sigecig_tipos_de_pagos_'+d+'-'+m+'-'+y+'  '+h+'.'+min+'.'+seg;
                        },
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5 ]}
        },
        {
            extend: 'csvHtml5',
            filename: function(){
                        var D = new Date()
                        var d = D.getDate();
                        var m = D.getMonth()+1;
                        var y = D.getFullYear();
                        var h = D.getHours();
                        var min = D.getMinutes();
                        var seg = D.getSeconds();
                        return 'sigecig_tipos_de_pagos_'+d+'-'+m+'-'+y+'  '+h+'.'+min+'.'+seg;
                        },
            exportOptions: {
                columns: [ 0, 1, 2, 3, 4, 5 ]}
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
        "title": "ID",
        "data": "id",
        "width" : "3%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Código",
        "data": "codigo",
        "width" : "8%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Tipo de Pago",
        "data": "tipo_de_pago",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return (data );},
    },

    {
        "title": "Precio de Colegiados",
        "data": "precio_colegiado",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return ('Q.'+data.toFixed(2) );},
    },

    {
        "title": "Precio Particular",
        "data": "precio_particular",
        "width" : "10%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return ('Q.'+data.toFixed(2) );},
    },

    {
        "title": "Categoría",
        "data": "categoria",
        "width" : "10%",
        "responsivePriority": 6,
        "render": function( data, type, full, meta ) {
            return (data );},
    },

    {
        "title": "Acciones",
        "orderable": false,
        "width" : "10%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();

            if(full.estado == 0){
                return "<div id='" + full.id + "' class='text-center'>" +
                "<div class='float-left col-lg-4'>" +
                "<a href='#' class='edit-tipodepago' data-toggle='modal' data-target='#editUpdateModal' data-id='" + full.id + "' data-codigo='" + full.codigo + "' data-tipo_de_pago='"+full.tipo_de_pago+"' data-precio_colegiado='"+full.precio_colegiado+"' data-precio_particular='"+full.precio_particular+"' data-categoria_id='"+full.categoria_id+"'>" +
                "<i class='fa fa-btn fa-edit' title='Editar Registro'></i>" +
                "</a>" + "</div>" +
                "<div class='float-right col-lg-4'>" +
                "<a href='"+urlActual+"/"+full.id+"/destroy' class='destroy-tipodepago'"+ "data-method='post' data-id='"+full.id + "'  data-codigo='" + full.codigo +"'>" +
                "<i class='fa fa-thumbs-down' title='Rechazar Registro'></i>" +
                "</a>" + "</div>" ;
                // "<div class='float-right col-lg-4'>" +
                // "<a href='"+urlActual+"/"+full.id+"/delete' class='delete-tipodepago'"+ "data-method='post' data-id='"+full.id+"' >" +
                // "<i class='fa fa-trash' title='Eliminar Registro'></i>" +
                // "</a>" + "</div>";

            } else{
                if(rol_user == 'Super-Administrador' || rol_user == 'Administrador'){
                    return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-right col-lg-6'>" +
                    "<a href='"+urlActual+"/"+full.id+"/activar' class='activar-tipodepago'"+ "data-method='post' data-id='"+full.id+"' data-codigo='" + full.codigo +"'>" +
                    "<i class='fa fa-thumbs-up' title='Aprobar Resgitro'></i>" +
                    "</a>" + "</div>";
                }else{
                    return "<div id='" + full.id + "' class='text-center'>" + "</div>";
                }

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

$(document).on('click', 'a.destroy-tipodepago', function(e) {
    e.preventDefault(); // does not go through with the link.
    alertify.defaults.theme.ok = "btn btn-error";
    var button = $(e.currentTarget);
    var idTipoPago = button[0].dataset.id;
    var codigo = button[0].dataset.codigo;
    var $this = $(this);
    alertify.confirm('Desactivar tipo de pago', 'Esta seguro de Desactivar el tipo de pago con código: <strong>' +codigo + "</strong>",
    //.set('labels', {ok:'Desactivar'},
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                alertify.confirm().destroy();
                tipodepago_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Registro desactivado con Éxito!!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center', 'error');
            // alertify.error('Cancelar')
        });
});

$(document).on('click', 'a.activar-tipodepago', function(e) {
    e.preventDefault(); // does not go through with the link.
    alertify.defaults.theme.ok = "btn btn-confirm";
    var button = $(e.currentTarget);
    var idTipoPago = button[0].dataset.id;
    var codigo = button[0].dataset.codigo;
    var $this = $(this);
    alertify.confirm('Aprobar Registro', 'Esta seguro de aprobar el registro: <strong>' +codigo + "</strong>",
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                tipodepago_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Registro activado con Éxito!!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            //alertify.error('Cancelar')
        });
});

$(document).on('click', 'a.delete-tipodepago', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    alertify.confirm('Eliminar Registro', 'Esta seguro de eliminar la Registro',
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                tipodepago_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Registro eliminada con Éxito!!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancelar')
        });
});


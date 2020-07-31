var colegiados_table = $('#colegiados-table').DataTable({
    "ajax": "/colegiados/getJson",
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
            "title": "No. Colegiado",
            "data": "dpi",
            "width" : "5%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "Nombre",
            "data": "nombre",
            "width" : "35%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "Carrera",
            "data": "carrera_afin",
            "width" : "25%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
        {
            "title": "Estado",
            "data": "descripcion",
            "width" : "15%",
            "responsivePriority": 1,
            "render": function( data, type, full, meta ) {
                return (data);},
        },
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "20%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();

                    return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-right col-lg-3'>" +
                    "<a href='"+urlActual+"/detalles/"+full.dpi+"'"+ "data-method='post' data-dpi='"+full.dpi+"' data-nit='"+full.nit+"'>" +
                    "<i class='fa fa-info-circle' title='Detalles'></i>" +
                    "</a>" + "</div>" +
                    "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-right col-lg-3'>" +
                    "<a href='#'"+ "data-toggle='modal' data-target='#ingresoModal2' data-dpi='"+full.dpi+"' >" +
                    "<i class='fa fa-plus-square' title='Agregar Profesion'></i>" +
                    "</a>" + "</div>" +
                    "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-right col-lg-3'>" +
                    "<a href='"+urlActual+"/"+full.id+"/destroy' class='destroy-bodegas'"+ "data-method='post' data-id='"+full.id+"' >" +
                    "<i class='fa fa-info' title='Información de Timbres'></i>" +
                    "</a>" + "</div>" +
                    "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-right col-lg-3'>" +
                    "<a href='"+urlActual+"/"+full.id+"/destroy' class='destroy-bodegas'"+ "data-method='post' data-id='"+full.id+"' >" +
                    "<i class='fa fa-sync' title='Asociar Colegiado'></i>" +
                    "</a>" + "</div>"
                
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

$(document).on('click', 'a.destroy-bodegas', function(e) {
    e.preventDefault(); // does not go through with the link.
    alertify.defaults.theme.ok = "btn btn-error";
    var $this = $(this);
    alertify.confirm('Eliminar Bodega', 'Esta seguro de eliminar la Bodega?',
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                bodegas_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Bodega eliminada con Éxito!!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancelar')
        });
});



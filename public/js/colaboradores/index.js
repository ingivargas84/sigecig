var solicitudes_table = $('#colaboradores-table').DataTable({
    //"ajax": "/solicitudes/getJson",
    "responsive": true,
    "processing": true,
    "retrieve": true,
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
        "title": "Nombre Colaborador",
        "data": "nombre",
        "width" : "30%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "DPI",
        "data": "dpi",
        "width" : "30%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },


    {
        "title": "Puesto",
        "data": "puesto",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            if (data == 1){return ('Gerente')}
            else if (data == 2){return ('Presidente')}
            else if (data == 3){return ('Sala de Juntas')}
            else if (data == 4){return ('Sub Gerente')}
            else if (data == 5){return ('Secretaria de Gerente ')}
            else if (data == 6){return ('Secretaria de Junta Directiva')}
            else if (data == 7){return ('Compras')}
            else if (data == 8){return ('Nuevos Colegiados')}
            else if (data == 9){return ('Tribunal de Honor')}
            else if (data == 10){return ('Tribunal Electoral')}
            else if (data == 11){return ('Cajas')}
            else if (data == 12){return ('Soporte Tecnico')}
            else if (data == 13){return ('Desarrollo')}
            else if (data == 14){return ('Jefe de Computo')}
            else if (data == 15){return ('Auxiliar de Timbre')}
            else if (data == 16){return ('Administrador de Timbre')}
            else if (data == 17){return ('Macro Seguros')}
            else if (data == 18){return ('Jefe de CEDUCA')}
            else if (data == 19){return ('Secretaria de CEDUCA')}
            else if (data == 20){return ('Asistente de comisiones')}
            else if (data == 21){return ('ASIJUGUA')}
            else if (data == 22){return ('Contador General')}
            else if (data == 23){return ('Auditor Interno')}
            else if (data == 24){return ('Contador de Timbre')}
            else if (data == 25){return ('Auxiliar de Contabilidad')}
        },
    },

    {
        "title": "Departamento",
        "data": "departamento",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            if (data == 1){return ('Gerencia')}
            else if(data == 2){return ('Informatica')}
            else if(data == 3){return ('Timbre')}
            else if(data == 4){return ('Secretaria')}
            else if(data == 5){return ('CEDUCA')}
            else if(data == 6){return ('Contabilidad')}
            else if(data == 7){return ('Cajeros')}
            else if(data == 8){return ('Mensajeria')}
            else if(data == 8){return ('Mantenimiento')}
        },
    },

    {
        "title": "Telefono",
        "data": "telefono",
        "width" : "10%",
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
                if(rol_user == 'Super-Administrador' || rol_user == 'Administrador'){
                    return "<div id='" + full.id + "' class='text-center'>" +
                    "<div class='float-right col-lg-6'>" +
                    "<a href='"+urlActual+"/edit/"+full.id+"' class='edit-colaborador' >" +
                    "<i class='fa fa-btn fa-edit' title='Editar Registro'></i>" +
                    "</a>" + "</div>"+
                    "<div class='float-right col-lg-4'>" +
                    "<a href='"+urlActual+"/"+full.id+"/destroy' class='destroy-colaborador'"+ "data-method='post' data-id='"+full.id+"' >" +
                    "<i class='fa fa-trash' title='Eliminar Registro'></i>" +
                    "</a>" + "</div>";
                }else{
                    return "<div id='" + full.id + "' class='text-center'>" + "</div>";
                }
        },
        "responsivePriority": 5
    }]

});

$(document).on('click', 'a.destroy-colaborador', function(e) {
    e.preventDefault(); // does not go through with the link.
    alertify.defaults.theme.ok = "btn btn-error";
    var $this = $(this);
    alertify.confirm('Eliminar Resgistro', 'Esta seguro de Eliminar el registro del  Colaborador',
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                solicitudes_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Registro Eliminado con Éxito!!');
            });
         }
        , function(){
            alertify.set('notifier','position', 'top-center');
            alertify.error('Cancelar')
        });
});

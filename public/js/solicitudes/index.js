var solicitudes_table = $('#solicitudes-table').DataTable({
    //"ajax": "/solicitudes/getJson",
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
        "title": "Fecha solicitud",
        "data": "fecha",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    
    {
        "title": "Departamento",
        "data": "departamento_id",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Descripcion",
        "data": "descripcion_boleta",
        "width" : "25%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Responsable",
        "data": "responsable",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Quien la usará",
        "data": "quien_la_usara",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Estado",
        "data": "estado_solicitud",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            if(data == 1){
                return ('Creado')
            }else if(data == 2){
                return ('Rechazado')
            }else if(data ==3){
                return ('Aprobado')
            }else if(data == 4){
                return ('Eliminado')
            }
        
        },
    },

    {
        "title": "Fecha de Creación",
        "data": "created_at",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);
        },
    },
     
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "25%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            var urlActual = $("input[name='urlActual']").val();

            if(full.estado_solicitud == 1 || full.estado_solicitud == 3){
                return "<div id='" + full.id + "' class='text-center'>" + 
                "<div class='float-left col-lg-4'>" + 
                "<a href='"+urlActual+"/edit/"+full.id+"' class='edit-solicitud' >" + 
                "<i class='fa fa-btn fa-edit' title='Editar Solicitud'></i>" + 
                "</a>" + "</div>" +
                "<div class='float-right col-lg-4'>" + 
                "<a href='"+urlActual+"/"+full.id+"/destroy' class='destroy-solicitud'"+ "data-method='post' data-id='"+full.id+"' >" + 
                "<i class='fa fa-thumbs-down' title='Desactivar Solicitud'></i>" + 
                "</a>" + "</div>" +
                "<div class='float-right col-lg-4'>" + 
                "<a href='"+urlActual+"/"+full.id+"/delete' class='delete-solicitud'"+ "data-method='post' data-id='"+full.id+"' >" + 
                "<i class='fa fa-trash' title='Eliminar Solicitud'></i>" + 
                "</a>" + "</div>";
    
            }else{
                if(rol_user == 'Super-Administrador' || rol_user == 'Administrador'){
                    return "<div id='" + full.id + "' class='text-center'>" + 
                    "<div class='float-right col-lg-6'>" + 
                    "<a href='"+urlActual+"/"+full.id+"/activar' class='activar-solicitud'"+ "data-method='post' data-id='"+full.id+"' >" + 
                    "<i class='fa fa-thumbs-up' title='Aprobar Solicitud'></i>" + 
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

$(document).on('click', 'a.destroy-solicitud', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);    
    alertify.confirm('Desactivar solicitud', 'Esta seguro de Descativar la solicitud', 
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                solicitudes_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Solicitud desactivada con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancelar')
        });   
});

$(document).on('click', 'a.activar-solicitud', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);    
    alertify.confirm('Aprobar solicitud', 'Esta seguro de aprobar la solicitud', 
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                solicitudes_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Solicitud aprobada con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancelar')
        });   
});

$(document).on('click', 'a.delete-solicitud', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);    
    alertify.confirm('Eliminar solicitud', 'Esta seguro de eliminar la solicitud', 
        function(){
            $('.loader').fadeIn();
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                $('.loader').fadeOut(225);
                solicitudes_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Solicitud eliminada con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancelar')
        });   
});

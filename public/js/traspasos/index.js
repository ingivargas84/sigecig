var traspasos_table = $('#traspasos-table').DataTable({
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
        filename: function(){
                    var D = new Date()
                    var d = D.getDate();
                    var m = D.getMonth()+1;
                    var y = D.getFullYear();
                    var h = D.getHours();
                    var min = D.getMinutes();
                    var seg = D.getSeconds();
                    return 'sigecig_Traspasos_'+d+'-'+m+'-'+y+'  '+h+'.'+min+'.'+seg;
                    },
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4 ]}
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
                    return 'sigecig_Traspasos_'+d+'-'+m+'-'+y+'  '+h+'.'+min+'.'+seg;
                    },
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4 ]}
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
        "width" : "5%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Bodega Origen",
        "data": "bodega_origen",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Bodega Destino",
        "data": "bodega_destino",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Cantidad de Timbres",
        "data": "cantidad_de_timbres",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return(data);},
    },

    {
        "title": "Total",
        "data": "total_en_timbres",
        "width" : "10%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return('Q.'+data.toFixed(2));},
    },

    {
        "title": "Acciones",
        "orderable": false,
        "width" : "10%",
        "render": function(data, type, full, meta) {
            var urlActual = $("input[name='urlActual']").val();

            return  "<div class='float-rigth col-lg-4'>" +
                    "<a href='#' class='detalles-remesa' >" +
                    "<i class='fa fa-btn fa-edit' title='detalles remesa'></i>" +
                    "</a>" + "</div>";
        },
        "responsivePriority": 5
    }]

});

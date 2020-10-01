$('#pdfSolicitud').click(function (e) { 
    e.preventDefault();
    $('#solicitudpdf').toggle();
 
});

$('#pdfDpi').click(function (e) { 
    e.preventDefault();
    $('#dpipdf').toggle();
   
});

$('#pdfResolucion').click(function (e) { 
    e.preventDefault();
    $('#resolucionpdf').toggle();
   
});
$(document).ready(function () {
    // var image_src = $("#iframeSolicitud").attr('src');
    // var image = new Image();

    // var src = image_src; //Esta es la variable que contiene la url de una imagen ejemplo, luego puedes poner la que quieras
    // image.src = src;

    // $('#image').append(image);

});
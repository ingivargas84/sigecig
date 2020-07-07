
function validarSolciditud(){
    var archivoInput = document.getElementById('solicitud').files;
    var archivoRuta = solicitud.value;
    var extPermitidas = /(.pdf|.png|.jpg|.PNG|.JPG)$/i;
    if(!extPermitidas.exec(archivoRuta)){
        alertify.error("Asegurate de subir un documento en Formato 'PDF,PNG o JPG'");
        alertify.set('notifier','position','top-center');
        $('#solicitud').val('');
        $('#msj1').html('');
        return false;
    }else{
            $('#msj1').html(archivoInput[0].name);
    }
}

function validarDpi(){
    var archivoInput = document.getElementById('dpi').files;
    var archivoRuta = dpi.value;
    var extPermitidas = /(.pdf|.png|.jpg|.PNG|.JPG)$/i;
    if(!extPermitidas.exec(archivoRuta)){
        alertify.error("Asegurate de subir un documento en Formato 'PDF,PNG o JPG'");
        alertify.set('notifier','position','top-center');
        $('#dpi').val('');
        $('#msj2').html('');
        return false;
    }else{
        $('#msj2').html(archivoInput[0].name);
    }
}       
    function validate(formData, jqForm, options) {
        var form = jqForm[0];
        if (!form.solicitud.value) {
            alertify.error("No se cargo la Solicitud");
            alertify.set('notifier','position','bottom-center');
            return false;
        }else{
            var solicitud = document.getElementById('solicitud');
            var archivoRuta = solicitud.value;
            var extPermitida = /(.pdf|.png|.jpg|.PNG|.JPG)$/i;
            if(!extPermitida.exec(archivoRuta)){
                alertify.error("Subir la solicitud en formato PDF");
                alertify.set('notifier','position','bottom-center');
                
                return false;
            }else{
                var solicitud = document.getElementById('solicitud').files;
                if(solicitud[0].size>1024*1024*5)
                {
                    alertify.error("Subir solicitud en un maximo de 5MB");
                    alertify.set('notifier','position','bottom-center');
                    return false;
                }
            }
        }

        if (!form.dpi.value) {
            alertify.error("No se adjunto la copia de DPI");
            alertify.set('notifier','position','bottom-center');
            return false;
        }else{
            var dpi = document.getElementById('dpi');
            var archivoRuta = dpi.value;
            var extPermitida = /(.pdf|.png|.jpg|.PNG|.JPG)$/i;
            if(!extPermitida.exec(archivoRuta)){
                alertify.error("Subir DPI en formato PDF");
                
                return false;
            }else{
                var dpi = document.getElementById('dpi').files;
                if(dpi[0].size>1024*1024*5)
                {
                    alertify.error("Subir  DPI en tamaño maximo de 5MB");
                    return false;
                }
            }
        }
        if (form.dpi.value) {
           
        }
    }


    (function() {

    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');
    
 
    $('form').ajaxForm({
        
        beforeSubmit: validate,
        beforeSend: function() {
            status.empty();
            var percentVal = '0%';
            var posterValue = $('input[name=file]').fieldValue();
            bar.width(percentVal)
            percent.html(percentVal);
            $('.loader').show();
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
            
        },
        success: function() {
           
            var percentVal = 'Wait, Saving';
            bar.width(percentVal)
            percent.html(percentVal);
            
        },
        complete: function(xhr) {
            status.html(xhr.responseText);
            alertify.set('notifier','position','bottom-center');
            alertify.success("Archivos enviados exitosamente");
            window.location.href = "/resolucion";
        }
        
    });

    })();

    $


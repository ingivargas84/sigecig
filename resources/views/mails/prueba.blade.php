<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        .baner{ background:#03306d; text-align: center; height: 175px; padding-top:30px; }
        .datos{font-weight: 700; margin-left: 20%;}
        .alinear{float: right;margin-right: 300px}
    </style>
    <title ></title>
</head>
<body>
   
<div class="baner">
    <img src="/images/logo.png" alt="picsum" width="150" /> 
    <img style="margin-left: 100px" src="/images/timbres.png" alt="picsum" width="120" />
</div><br>

    @if ($solicitudAP['id_estado_solicitud']=='4')
        <h3><center>Estimado agremiado, le informamos que sus documentos han sido revisados</center></h3>
        <h3><center>y aprobados satisfactoriamente</center></h3> <br><br>
        <h3> <center>A continuacion se detalla el proceso de su solicitud </center> </h3> <br><br>
        <div class="datos" ><label class=""  for="">INTERESADO: {{$colegiado->n_cliente}}</label> <label class="alinear" style="margin-right: 310px" for="">FECHA: {{$fecha_actual}}</label></div><br><br>
        <div class="datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label> <label class="alinear"  for="">STATUS: PASO 03/08</label></div><br><br>
        <div style="text-align: center"><img src="/images/paso4.png" alt="picsum" width="" /></div>

     @elseif($solicitudAP['id_estado_solicitud']=='5')
        <h3><center>Estimado agremiado, le informamos que sus solicitud han sido revisada</center></h3>
        <h3><center>y aprobados satisfactoriamente por Junta Directiva</center></h3> <br><br>
        <h3> <center>A continuacion se detalla el proceso de su solicitud </center> </h3> <br><br> 
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> <label class="alinear" style="margin-right: 310px"  for="">FECHA: {{$fecha_actual}}</label></div><br><br>
        <div class=" datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label> <label  class="alinear" for="">STATUS: PASO 05/08</label></div><br><br>
        <div style="text-align: center"><img src="/images/paso5.png" alt="picsum" width="" /></div>  

    @elseif($solicitudAP['id_estado_solicitud']=='10')
        <h3><center>Estimado agremiado, lamentamos informarle que su solicitud a sido rechazada por Junta Directiva</center></h3>
        <h3> <center>A continuacion se detalla la razon del rechazo</center> </h3> <br><br> 
        <div class=" datos" style="margin-left: 400px; margin-right: 100px;"><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> <label class="alinear"  for="">FECHA: {{$fecha_actual}}</label></div> <br><br><br>  
        <div  style=" color:red;"><h3><center> MOTIVO DEL RECHAZO</center></h3></div>
        <div style=""><p style="margin-right: 400px; margin-left: 400px; font-size: 20px; text-align: justify; ">{{$solicitudAP['solicitud_rechazo_junta']}}</p></div> <br><br>    
        <h3><center>Puede iniciar una nueva solicitud en cualquier momento</center></h3>

    @elseif($solicitudAP['id_estado_solicitud']=='3')
        <h3><center>Estimado agremiado, lamentamos informarle que sus documentos han sido rechazadas por la Junta Directiva</center></h3>
        <h3> <center>A continuacion se detalla la razon del rechazo</center> </h3> <br><br> 
        <div class=" datos" style="margin-left: 350px"><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> <label class="alinear"  for="">FECHA: {{$fecha_actual}}</label></div> <br><br><br>  
        <div  style=" color:red;"><h3><center> MOTIVO DEL RECHAZO</center></h3></div>
        <div style=""><p style="margin-right: 350px; margin-left: 350px; font-size: 20px; text-align: justify;">{{$solicitudAP['solicitud_rechazo_ap']}}</p></div> <br><br>  
        <h3><center>Puede iniciar una nueva solicitud en cualquier momento</center></h3>
    @endif <br><br><br><br>  
</body>

</html>
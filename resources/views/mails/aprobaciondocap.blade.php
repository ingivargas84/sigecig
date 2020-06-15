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
    <img src="{{ $message->embed(public_path().'/images/logo.png') }}" alt="picsum" width="150" /> 
    <img style="margin-left: 100px" src="{{ $message->embed(public_path().'/images/timbres.png') }}" alt="picsum" width="120" />
</div><br>

    @if ($solicitudAP['id_estado_solicitud']=='4')
        <h3><center>Estimado agremiado, le informamos que sus documentos han sido revisados</center></h3>
        <h3><center>y aprobados satisfactoriamente</center></h3> <br><br>
        <h3> <center>A continuación se detalla el proceso de su solicitud </center> </h3> <br><br>
        <div class="datos" ><label class=""  for="">INTERESADO: {{$colegiado->n_cliente}}</label> <label class="alinear" style="margin-right: 310px" for="">FECHA: {{$fecha_actual}}</label></div><br><br>
        <div class="datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label> <label class="alinear"  for="">STATUS: PASO 03/08</label></div><br><br>
        <div style="text-align: center"><img src="{{ $message->embed(public_path().'/images/paso4.png') }}" alt="picsum" width="" /></div>
        <h3><center>La aprobación por Junta Directiva se estará llevando a cabo en los próximos 7 días hábiles.</center></h3>
     @elseif($solicitudAP['id_estado_solicitud']=='5')
        <h3><center>Estimado agremiado, le informamos que su solicitud han sido revisada</center></h3>
        <h3><center>y aprobados satisfactoriamente por la Junta de Auxilio Póstumo</center></h3> <br><br>
        <h3> <center>A continuación se detalla el proceso de su solicitud </center> </h3> <br><br> 
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> <label class="alinear" style="margin-right: 310px"  for="">FECHA: {{$fecha_actual}}</label></div><br><br>
        <div class=" datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label> <label  class="alinear" for="">STATUS: PASO 05/08</label></div><br><br>
        <div style="text-align: center"><img src="{{ $message->embed(public_path().'/images/paso5.png') }}" alt="picsum" width="" /></div>
        <h3><center>Se le solicita presentarse a las instalaciones del CIG para proceder a la firma de su resolución de pago. </center></h3>
        <h3><center>Horarios habilitados: Lunes a Viernes de 8:00 a 15:00 horas. </center></h3><br><br>

    @elseif($solicitudAP['id_estado_solicitud']=='10')
        <h3><center>Estimado agremiado, lamentamos informarle que su solicitud ha sido rechazada por Junta Directiva</center></h3>
        <h3> <center>A continuación se detalla la razon del rechazo</center> </h3> <br><br> 
        <div class=" datos" style="margin-left: 200px; margin-right: 100px;"><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> <label class="alinear" style="margin-right: 120px" for="">FECHA: {{$fecha_actual}}</label></div> <br><br><br>  
        <div  style=" color:red;"><h3><center> MOTIVO DEL RECHAZO</center></h3></div>
        <div style=""><p style="margin-right: 200px; margin-left: 200px; font-size: 15px; text-align: justify; ">{{$solicitudAP['solicitud_rechazo_junta']}}</p></div> <br><br>    
        <h3><center>Puede iniciar una nueva solicitud en cualquier momento</center></h3>

        @elseif($solicitudAP['id_estado_solicitud']=='8')
        <h3><center>Estimado agremiado, le enviamos una actualización de su solicitud de Auxilio Póstumo </center></h3><br><br>
        <h3> <center>A continuación se detalla el proceso de su solicitud </center> </h3> <br><br> 
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> <label class="alinear" style="margin-right: 310px"  for="">FECHA: {{$fecha_actual}}</label></div><br><br>
        <div class=" datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label> <label  class="alinear" for="">STATUS: PASO 06/08</label></div><br><br>
        <div style="text-align: center"><img src="{{ $message->embed(public_path().'/images/paso6.png') }}" alt="picsum" width="" /></div>

    @elseif($solicitudAP['id_estado_solicitud']=='11')
        <h3><center>Estimado agremiado, le informamos que su solicitud ha sido finalizada exitosamente</center></h3>
        <h3> <center>La transacción se encuentra en proceso y será efectuada en los próximos 7 días hábiles </center> </h3> <br><br> 
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> <label class="alinear" style="margin-right: 310px"  for="">FECHA: {{$fecha_actual}}</label></div><br><br>
        <div class=" datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label> <label  class="alinear" for="">STATUS: PASO 07/08</label></div><br><br>
        <div style="text-align: center"><img src="{{ $message->embed(public_path().'/images/paso7.png') }}" alt="picsum" width="" /></div>

    @elseif($solicitudAP['id_estado_solicitud']=='3')
        <h3><center>Estimado agremiado, lamentamos informarle que su documentación ha sido rechazadas por la Junta Directiva</center></h3>
        <h3> <center>A continuación se detalla la razón del rechazo</center> </h3> <br><br> 
        <div class=" datos" style="margin-left: 200px"><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> <label class="alinear" style="margin-right: 200px" for="">FECHA: {{$fecha_actual}}</label></div> <br><br><br>  
        <div  style=" color:red;"><h3><center> MOTIVO DEL RECHAZO</center></h3></div>
        <div style=""><p style="margin-right: 200px; margin-left: 200px; font-size: 15px; text-align: justify;">{{$solicitudAP['solicitud_rechazo_ap']}}</p></div> <br><br>  
        <div style="text-align: center"><img src="{{ $message->embed(public_path().'/images/paso1.png') }}" alt="picsum" width="" /></div>
        <h3><center>Puede enviar nuevamente sus documentos en cualquier momento</center></h3>
    @endif <br><br><br><br>  

    <div>
        <h4 style="margin-left: 200px">Puede revisar el proceso de su solicitud en : <a href="http://localhost:8000/postumo/">http://localhost:8000/postumo/</a> </h4>
        <h3><center style="font-weight: bold; font-style: italic">Por un gremio moderno, innovador y competitivo</center></h3>
    </div><br><br>
</body>

</html>
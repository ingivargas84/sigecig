<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        .baner{ background:#03306d; text-align: center; height: 200px; align-items: center;}
        .datos{font-weight: 700;}
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
        <h3> <center>A continuacion se detalla el proceso de su solicitud </center> </h3> <br><br>
        <div class=" datos" ><center><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> <label style="margin-left: 150px" for="">FECHA: {{$fecha_actual}}</label></center></div>
        <br><br>
        <div class=" datos"><center><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label> <label  style="margin-left: 180px" for="">STATUS: PASO 03/08</label></center></div><br><br>
        <div style="text-align: center"><img src="{{ $message->embed(public_path().'/images/paso4.png') }}" alt="picsum" width="" /></div>
     @elseif($solicitudAP['id_estado_solicitud']=='5')
        <h3><center>Estimado agremiado, le informamos que sus solicitud han sido revisada</center></h3>
        <h3><center>y aprobados satisfactoriamente por Junta Directiva</center></h3> <br><br>
        <h3> <center>A continuacion se detalla el proceso de su solicitud </center> </h3> <br><br> 
        <div class=" datos" ><center><label for="">INTERESADO:{{$colegiado->n_cliente}}</label> <label style="margin-left: 150px" for="">FECHA: {{$fecha_actual}}</label></center></div>
        <div class=" datos"><center><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label> <label  style="margin-left: 180px" for="">STATUS: PASO 05/08</label></center></div><br><br>
        <div style="text-align: center"><img src="{{ $message->embed(public_path().'/images/paso5.png') }}" alt="picsum" width="" /></div>   
    @elseif($solicitudAP['id_estado_solicitud']=='10')
        <h3><center>Estimado agremiado, lamentamos informarle que su solicitud a sido rechazada por Junta Directiva</center></h3>
        <h3> <center>A continuacion se detalla la razon del rechazo</center> </h3> <br><br> 
        <div class=" datos" ><center><label for="">INTERESADO:{{$colegiado->n_cliente}}</label> <label style="margin-left: 150px" for="">FECHA: {{$fecha_actual}}</label></center></div>
        <div style="text-align: center"><h3>MOTIVO DEL RECHAZO</h3></div>
        <div style="text-align: center"><p>{{$solicitudAP['solicitud_rechazo_junta']}}</p></div> <br><br>    
        <h4>Puede iniciar una nueva solicitud en cualquier momento</h4>
    @elseif($solicitudAP['id_estado_solicitud']=='3')
        <h3><center>Estimado agremiado, lamentamos informarle que sus documentos han sido rechazadas por la Junta Directiva</center></h3>
        <h3> <center>A continuacion se detalla la razon del rechazo</center> </h3> <br><br> 
        <div class=" datos" ><center><label for="">INTERESADO:{{$colegiado->n_cliente}}</label> <label style="margin-left: 150px" for="">FECHA: {{$fecha_actual}}</label></center></div>   
        <div style="text-align: center"><h3>MOTIVO DEL RECHAZO</h3></div>
        <div style="text-align: center"><p>{{$solicitudAP['solicitud_rechazo_ap']}}</p></div> <br><br>  
        <h4>Puede iniciar una nueva solicitud en cualquier momento</h4>
    @endif   
</body>

</html>
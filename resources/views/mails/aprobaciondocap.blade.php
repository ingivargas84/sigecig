<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        .baner{ background:#03306d; text-align: center; height: 175px; padding-top:30px; }
        .datos{font-weight: 700; margin-left: 20%;}
        .alinear{float: right;}
        .rechazo{font-size: 20px;margin-left: 20%; margin-right: 20%;  text-align: justify; }
        .img1{width: 80%; margin-left: 10%}
        .pie{margin-left: 20%}
        @media (max-width: 800px) {
                .datos{margin-left: 5%;}
                .rechazo{margin-left: 5%; margin-right: 5%}
                .pie{margin-left: 5%;}
                .img1{width: 90%; margin-left: 5%}
            }
    </style>
    <title ></title>
</head>
<body>
   
<div class="baner">
    <img src="{{ $message->embed(public_path().'/images/logo.png') }}" alt="picsum" width="150" /> 
    <img style="margin-left: 5%" src="{{ $message->embed(public_path().'/images/timbres.png') }}" alt="picsum" width="120" />
</div><br>

    @if ($solicitudAP['id_estado_solicitud']=='4')
        <h3><center>Estimado agremiado, le informamos que sus documentos han sido revisados</center></h3>
        <h3><center>y aprobados satisfactoriamente</center></h3> <br><br>
        <h3> <center>A continuación se detalla el proceso de su solicitud </center> </h3> <br><br>
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> </div> 
        <div class=" datos"><label class=""  for="">FECHA: {{$fecha_actual}}</label></div> 
        <div class="datos"> <label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label></div>
        <div class="datos"> <label  for="">STATUS: PASO 03/08</label></div><br><br>
        <div  ><img class="img1" src="{{ $message->embed(public_path().'/images/paso4.png') }}" alt="picsum"  /></div>
        <h4 class="pie" >Puede revisar el proceso de su solicitud en : <a href="https://www2.cig.org.gt/postumo/">https://www2.cig.org.gt/postumo/</a> </h4>


     @elseif($solicitudAP['id_estado_solicitud']=='5')
        <h3><center>Estimado agremiado, le informamos que su solicitud ha sido revisada</center></h3>
        <h3><center>y aprobada satisfactoriamente por Junta de Auxilio Póstumo</center></h3> <br><br>
        <h3> <center>A continuación se detalla el proceso de su solicitud </center> </h3> <br><br> 
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> </div> 
        <div  class=" datos"><label   for="">FECHA: {{$fecha_actual}}</label></div>
        <div class=" datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label></div>
        <div class="datos"> <label  >STATUS: PASO 05/08</label></div><br><br><br>
        <div  ><img class="img1" src="{{ $message->embed(public_path().'/images/paso5.png') }}" alt="picsum"  /></div>
        <h3><center>Se le solicita presentarse a las instalaciones del CIG para proceder a la firma de su resolución de pago. </center></h3>
        <h3><center>Horarios habilitados: Lunes a Viernes de 8:00 a 15:00 horas. </center></h3><br><br> 
        <h4 class="pie" >Puede revisar el proceso de su solicitud en : <a href="https://www2.cig.org.gt/postumo/">https://www2.cig.org.gt/postumo/</a> </h4>
 

    @elseif($solicitudAP['id_estado_solicitud']=='8')
        <h3><center>Estimado agremiado, le enviamos una actualización de su solicitud de Auxilio Póstumo </center></h3><br><br>
        <h3> <center>A continuación se detalla el proceso de su solicitud </center> </h3> <br><br> 
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> </div> 
        <div  class=" datos"><label   for="">FECHA: {{$fecha_actual}}</label></div>
        <div class=" datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label></div>
        <div class="datos"> <label  >STATUS: PASO 06/08</label></div><br><br><br>
        <div ><img  class="img1" src="{{ $message->embed(public_path().'/images/paso6.png') }}" alt="picsum"  /></div>
        <h4 class="pie" >Puede revisar el proceso de su solicitud en : <a href="https://www2.cig.org.gt/postumo/">https://www2.cig.org.gt/postumo/</a> </h4>


    @elseif($solicitudAP['id_estado_solicitud']=='6')
        <h3><center>Estimado agremiado, lamentamos informarle que su solicitud a sido rechazada por Junta de Auxilio Póstumo</center></h3>
        <h3> <center>A continuación se detalla la razón del rechazo</center> </h3> <br><br> 
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> </div> 
        <div  class=" datos"><label   for="">FECHA: {{$fecha_actual}}</label></div>
        <div  style=" color:red;"><h3><center> MOTIVO DEL RECHAZO</center></h3></div>
        <div style=" "><p class=" rechazo">{{$solicitudAP['solicitud_rechazo_junta']}}</p></div> <br><br>    
        <h3><center>Puede iniciar una nueva solicitud en cualquier momento</center></h3>
        <h4 class="pie" >Puede revisar el proceso de su solicitud en : <a href="https://www2.cig.org.gt/postumo/">https://www2.cig.org.gt/postumo/</a> </h4>


    @elseif($solicitudAP['id_estado_solicitud']=='9')
        <h3><center>Estimado agremiado, le enviamos una actualización de su solicitud de Auxilio Póstumo</center></h3><br><br>
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> </div> 
        <div  class=" datos"><label   for="">FECHA: {{$fecha_actual}}</label></div>
        <div class=" datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label> </div>
        <div class="datos"><label    for="">STATUS: PASO 07/08</label></div><br><br>
        <div  ><img class="img1" src="{{ $message->embed(public_path().'/images/paso7.png') }}" alt="picsum" /></div>
        <h3> <center>El deposito se encuentra programado para el día:  {{ \Carbon\Carbon::parse($solicitudAP['fecha_pago_ap'])->format('d-m-Y')}} </center> </h3> <br><br>
        <h4 class="pie" >Puede revisar el proceso de su solicitud en : <a href="https://www2.cig.org.gt/postumo/">https://www2.cig.org.gt/postumo/</a> </h4>
 


        @elseif($solicitudAP['id_estado_solicitud']=='10')
        <h3><center>Estimado agremiado, le informamos que su solicitud ha sido finalizada exitosamente</center></h3><br><br>
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> </div> 
        <div  class=" datos"><label   for="">FECHA: {{$fecha_actual}}</label></div>
        <div class=" datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label> </div>
        <div class="datos"><label    for="">STATUS: PASO 08/08</label></div><br><br>
        <div  ><img class="img1" src="{{ $message->embed(public_path().'/images/paso8.png') }}" alt="picsum" /></div><br>
        <h4 class="pie" >Gracias por utilizar nuestros servicios en línea </h4>

    @elseif($solicitudAP['id_estado_solicitud']=='3')
        <h3><center>Estimado agremiado, lamentamos informarle que sus documentos han sido rechazadas por la Junta de Auxilio Póstumo</center></h3>
        <h3> <center>A continuación se detalla la razon del rechazo</center> </h3> <br><br> 
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> </div> 
        <div class=" datos"><label class=""  for="">FECHA: {{$fecha_actual}}</label></div> <br><br>
        <div  style=" color:red;"><h3><center> MOTIVO DEL RECHAZO</center></h3></div>
        <div style=""><p class="rechazo" >{{$solicitudAP['solicitud_rechazo_ap']}}</p></div> <br><br>  
        <h3><center>Puede iniciar una nueva solicitud en cualquier momento</center></h3>
        <h4 class="pie" >Puede revisar el proceso de su solicitud en : <a href="https://www2.cig.org.gt/postumo/">https://www2.cig.org.gt/postumo/</a> </h4>


        @elseif($solicitudAP['id_estado_solicitud']=='2')
        <h3><center>Estimado agremiado, le informamos que sus documentos han sido recibidos</center></h3>
        <h3><center>y fueron trasladados a revisión  por Junta de Auxilio Póstumo</center></h3> <br>
        <h3> <center>A continuación se detalla el proceso de su solicitud </center> </h3> <br>
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> </div> 
        <div  class=" datos"><label   for="">FECHA: {{$fecha_actual}}</label></div>        
        <div class="datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label></div>
        <div class="datos"> <label for="">STATUS: PASO 02/08</label></div><br><br>
        <div ><img class="img1" src='{{ $message->embed(public_path().'/images/paso2.png') }}' alt="picsum" /></div>
        <h3><center>Tiempo estimado de 7 días hábiles. </center></h3>
        <h4 class="pie" >Puede revisar el proceso de su solicitud en : <a href="https://www2.cig.org.gt/postumo/">https://www2.cig.org.gt/postumo/</a> </h4>

 
    @endif <br><br>

    <div>
        
        <h3><center style="font-weight: bold; font-style: italic">Por un gremio moderno, innovador y competitivo</center></h3>
    </div><br><br>

</body>

</html>
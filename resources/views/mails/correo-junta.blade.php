<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        .baner{ background:#03306d; text-align: center; height: 175px; padding-top:30px; }
        .datos{font-weight: 700; margin-left: 0%;}
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
        <img style="margin-left: 100px" src="{{ $message->embed(public_path().'/images/timbres.png') }}" alt="picsum" width="120" />
    </div><br>

    @if($solicitudAP['id_estado_solicitud']=='8')
        <h3><center>Hemos aprobado y trasladado a Contabilidad una nueva solicitud de Auxilio Póstumo </center></h3><br><br>
        <h3> <center>A continuación se detalla el proceso de la solicitud </center> </h3> <br><br>
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> </div>
        <div  class=" datos"><label   for="">FECHA: {{$fecha_actual}}</label></div>
        <div class=" datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label></div>
        <div class="datos"> <label  >STATUS: PASO 06/08</label></div><br><br><br>
        <div ><img  class="img1" src="{{ $message->embed(public_path().'/images/paso6.png') }}" alt="picsum"  /></div>


        @elseif($solicitudAP['id_estado_solicitud']=='2')
        <h3><center>Se ha creado una nueva solicitud de Auxilio Póstumo</center></h3>
        <h3><center>Los documentos fueron trasladados a revisión  por Junta de Auxilio Póstumo</center></h3> <br>
        <h3> <center>A continuación se detalla el proceso de la solicitud </center> </h3> <br>
        <div class=" datos" ><label for="">INTERESADO: {{$colegiado->n_cliente}}</label> </div>
        <div  class=" datos"><label   for="">FECHA: {{$fecha_actual}}</label></div>
        <div class="datos"><label for="">SOLICITUD: {{$solicitudAP['no_solicitud']}}</label></div>
        <div class="datos"> <label for="">STATUS: PASO 02/08</label></div><br><br>
        <div ><img class="img1" src='{{ $message->embed(public_path().'/images/paso2.png') }}' alt="picsum" /></div>
      

    @endif <br><br>

    <div>

        <h3><center style="font-weight: bold; font-style: italic">Por un gremio moderno, innovador y competitivo</center></h3>
    </div><br><br>

</body>

</html>
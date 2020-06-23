<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        .baner{ background:#03306d; text-align: center; height: 175px; padding-top:30px; }
        .justificar{margin-left: 20%}
    </style>
    <title ></title>
</head>
<body>
   
<div class="baner">
    <img src="/images/logo.png" alt="picsum" width="150" /> 
    <img style="margin-left: 5%" src="/images/timbres.png" alt="picsum" width="120" />
</div><br>

    @if ($tipoDeCliente==1)
    <h3 class="justificar">Estimado agremiado: {{$datos_colegiado[0]->n_cliente}}</h3>
    <h3 class="justificar">Adjunto su recibo No. {{$reciboMaestro['numero_recibo']}} </h3>
    @elseif($tipoDeCliente==2)
    <h3 class="justificar">Estimado cliente: {{$datos_colegiado[0]->n_cliente}}</h3>
    <h3 class="justificar">Adjunto su recibo No. {{$reciboMaestro['numero_recibo']}} </h3>  
    @elseif($tipoDeCliente==3)
    <h3 class="justificar">Estimado cliente: {{$datos_colegiado[0]->EMPRESA}}</h3>
    <h3 class="justificar">Adjunto su recibo No. {{$reciboMaestro['numero_recibo']}} </h3> 
    @endif

<br><br>
<footer>
<h3 class="justificar">Gracias por utilizar nuestros servicios en línea</h3>
</footer>
</body>

</html>
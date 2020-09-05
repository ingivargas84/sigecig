<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        .baner{ background:#03306d; text-align: center; height: 175px; padding-top:30px; }

    </style>
    <title ></title>
</head>
<body>
   
<div class="baner">
    {{-- <img src="{{ $message->embed(public_path().'/images/logo.png') }}" alt="picsum" width="150" />  --}}
</div><br>

    @if ($tipo==1)
    <h3 class="">Estimado agremiado: {{$reciboMaestro['nombre']}}</h3>
    <h3 class="">Adjunto su recibo No. {{$reciboMaestro['numero_recibo']}} </h3>
    @elseif($tipo==2)
    <h3 class="">Estimado cliente: {{$reciboMaestro->nombre}}</h3>
    <h3 class="">Adjunto su recibo No. {{$reciboMaestro['numero_recibo']}} </h3>  
    @elseif($tipo==3)
    <h3 class="">Estimado cliente: {{$reciboMaestro->nombre}}</h3>
    <h3 class="">Adjunto su recibo No. {{$reciboMaestro['numero_recibo']}} </h3> 
    @endif

<br><br>
<footer>
<h3 class="">Gracias por utilizar nuestros servicios en línea</h3>
</footer>
</body>

</html>
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
    <img src="{{ $message->embed(public_path().'/images/logo.png') }}" alt="picsum" width="150" />
</div><br>

    @if ($tipo=='solicitud')
    <h2>SOLICITUD DE ANULACIÓN DE RECIBO</h2>
    <h3 class="">Cajero que Solicita Anulación: {{$cajero}}</h3>
    <h3 class="">No. de recibo: {{$reciboMaestro}} </h3>
    <h3 class="">Enlace: {{$link}}</h3>
    @elseif($tipo=='respuesta')
    <h1>RESPUESTA DE ANULACIÓN DE RECIBO</h1>
    <br><br>
    <h3>Su solicitud de anulación del recibo <b>{{$reciboMaestro}}</b> fue: <b>{{$cajero}}</b></h3>
    @endif

<br><br>
<footer>
<h3 class="">Por un gremio moderno, competitivo</h3>
</footer>
</body>

</html>

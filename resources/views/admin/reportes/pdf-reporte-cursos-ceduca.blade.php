<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=w, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte De Cursos CEDUCA</title>
    <style>
        p {
            font-family: "sans-serif";
            text-align: left;
            margin-left: 4rem;
            margin-right: 4rem;
        }
        label {
            font-family: "sans-serif";
        }
        tr:nth-child(even){
            background-color: #eee;
        }
        .contenedor1{
            font-family: "sans-serif";
            background: repeating-linear-gradient(-45deg,
            #03306d 0,
            #03306d 55%,
            #858585 0,
            #858585 );
            margin-bottom:3rem;
        }
        .logo{
            text-indent: 20%;
        }
        .lg{
            margin-left: 4rem;
            margin-top: 1rem;
            /* margin-bottom: 1rem; */
        }
        .texto{
            display: inline-block;
            vertical-align: top;
            /* margin-top: 0rem; */
        }
        .texto1 {
            font-size:20px;
            font-weight: bold;
            color:black;
            height: 10px;
            display: inline-block;
            vertical-align: top;
        }
        .texto3 {
            background: #D2D2D2;
        }
        .baner{
            text-align: right;
            font-size: 35px;
            margin-top: 1rem;
            font-weight: bold;
            height: 190px;
            margin-right: 4rem;
        }
        .baner1{
            height: 50px;
        }
        .colegiado{
            font-family: "sans-serif";
            font-size:1rem;
            /* font-weight: bold; */
            margin-left: 4rem;
            float:left;
        }
        .colegiado2{
            font-family: "sans-serif";
            font-size:1rem;
            font-weight: bold;
            margin-right: 15rem;
            float:right;
        }
        .colegiado3{
            font-family: "sans-serif";
            font-size:1rem;
            font-weight: bold;
            margin-right: 5rem;
            float:right;
        }
        .img1{
            display: flex;
            height: 60px;
            width: 50px;
            background:#03306d;
            align-items: center;
        }
        .img{
            height: 25px;
            width: 25px;
        }
        .imagen{
            margin-left:  auto;
            margin-right: auto;
            margin-bottom: auto;
            margin-top: auto;
        }
        .href{
            color: white !important;
        }
        a:link, a:visited, a:active,a:hover  {
            text-decoration:none;
            cursor:pointer;
            color: white;
        }
        a {
            color: white;
            text-decoration: none;
        }
        .mr{
            margin-top: 3%;
        }
        table {
            width: 90%;
            margin: 20 auto;
            font-family: "sans-serif";
            border-collapse: collapse;
            font-size: 12px;
        }
        .odd th, .odd td {
            background: #eee;
        }
        #qr{
            position:center; /* absolute pin! */
            left:820px;
        }
    </style>
</head>
<body>
    <div class="container body" style="margin-bottom: 35px; border-bottom: 4px solid #03306d; height: 22%;">
            <div class="row" style="font-family: sans-serif; height: 190px; margin-left: 1rem;">
                <img class="lg" src="images/logocig.png"  height="90"  alt="">
                <div class="texto" style="margin-top: 3rem;">
                <p><small>COLEGIO DE INGENIEROS DE GUATEMALA<br>
                        7a. Avenida 39-60, Zona 8 Guatemala, Guatemala <br>
                        PBX: 2218-2600 / www.cig.org.gt <br>
                        NIT: 299329-5</small></p>
            </div>
            <div class="texto1" style="color: #03306d; background: white;height: 20px;width: 38%; margin-right: 3rem;">
                @if ($trayecto == 'UnCurso')
                    <h3 style="margin-top: 2rem; "><b> CURSO: </b>{{$curso->descripcion}}</h3></div>
                @else
                    <h3 style="margin-top: 4rem; font-size: 35px;"><b> CURSOS GENERALES</b></h3></div>
                @endif
            </div>
        </div>
    </div>
    <div class="row colegiado">
        <div class="" >
          <label class=""><b>FECHA DE CREACIÓN: </b>{{$newDate}} </label>
        </div>
        <br>
        <div class="">
          <label class="" ><b>USUARIO: </b>{{$user->name}}</label>
        </div>
        <br>
    </div>
    <br>
    <table style="margin-top: 4rem;">
        <thead >
            <tr>
                <th width="7%" style="background: #D2D2D2;text-align:center;">FECHA</th>
                <th width="7%" style="background: #D2D2D2;text-align:center;">SERIE</th>
                <th width="7%" style="background: #D2D2D2;text-align:center;">RECIBO </th>
                <th width="7%" style="background: #D2D2D2;text-align:center;">COLEGIADO</th>
                <th width="27%" style="background: #D2D2D2;text-align:center;">NOMBRE</th>
                <th width="8%" style="background: #D2D2D2;text-align:center;">TELÉFONO</th>
                <th width="15%" style="background: #D2D2D2;text-align:center;">CORREO</th>
                @if ($trayecto == 'todos')
                <th width="20%" style="background: #D2D2D2;text-align:center;">CURSO</th>
                @endif
                <th width="14%" style="background: #D2D2D2;text-align:center;">MONTO</th>
            </tr>
        </thead>
        @foreach ($arrayDetalles as $key => $detalles)
            @foreach ($detalles as $detalle)
                <tr>
                    <td style="background:eee;text-align:center;padding: 7px;">{{\Carbon\Carbon::parse($detalle->fecha1)->format('d/m/Y')}}</td>
                    <td style="background:eee;text-align:center;">{{$detalle->serie_f}}</td>
                    <td style="background:eee;text-align:center;">{{$detalle->control}}</td>
                    <td style="background:eee;text-align:center;">{{$detalle->c_cliente}}</td>
                    <td style="background:eee;text-align:center;">{{$detalle->n_cliente}}</td>
                    <td style="background:eee;text-align:center;">{{$detalle->telefono}}</td>
                    <td style="background:eee;text-align:center;">{{$detalle->e_mail}}</td>
                    @if ($trayecto == 'todos')
                    <td style="background:eee;text-align:center;">{{$detalle->descripcion}}</td>
                    @endif
                    <td style="background:eee;text-align:center;">Q.{{number_format($detalle->total_fac, 2)}}</td>
                </tr>
            @endforeach
        @endforeach
    </table>
</body>
</html>

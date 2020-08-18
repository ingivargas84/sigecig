<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=w, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte De Remesa</title>
    <style>
        p {
            font-family: "sans-serif";
            text-align: left;
            margin-left: 4rem;
            margin-right: 4rem;
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
            font-size:35px;
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
            <div class="texto1" style="color: #03306d; background: white;height: 20px; width: 38%; margin-right: 3rem;">
                <h3 style="margin-top: 4rem; "> Reporte De Remesa {{$id->id}}</h3></div>
            </div>
        </div>
    </div>
    <div class="row colegiado">
        <div class="" >
          <label class=""><b>FECHA DE CREACIÓN: </b>{{$newDate}} </label>
        </div>
        <br>
        <div class="">
          <label class="" ><b>GENERÓ LA REMESA: </b>{{$nombre->name}}</label>
        </div>
        <br>
    </div>
    <br>
    <br>
        <table style="margin-top: 4rem; ">
            <thead >
                <tr>
                    <th width="38%" style="background: #D2D2D2;text-align:center;">CÓDIGO</th>
                    <th width="9%" style="background: #D2D2D2;text-align:center;">PLANCHAS</th>
                    <th width="10%" style="background: #D2D2D2;text-align:center;">UNIDAD POR PLANCHA </th>
                    <th width="8%" style="background: #D2D2D2;text-align:center;">CANTIDAD</th>
                    <th width="10%" style="background: #D2D2D2;text-align:center;">NÚMERO INICIAL</th>
                    <th width="10%" style="background: #D2D2D2;text-align:center;">NÚMERO FINAL</th>
                    <th width="15%" style="background: #D2D2D2;text-align:center;">SUBTOTAL</th>
                </tr>
            </thead>
            @foreach($datos as $co)
            <tr >
                <td style="background:eee;text-align:center;padding: 7px;">{{$co->descripcion}}</td>
                <td style="background:eee;text-align:center;">{{$co->planchas}}</td>
                <td style="background:eee;text-align:center;">{{$co->unidad_por_plancha}}</td>
                <td style="background:eee;text-align:center;">{{$co->cantidad}}</td>
                <td style="background:eee;text-align:center;">{{$co->numeracion_inicial}}</td>
                <td style="background:eee;text-align:center;">{{$co->numeracion_final}}</td>
                <td style="background:eee;text-align:center;">Q.{{number_format($co->total, 2)}}</td>
            </tr>
            @endforeach
        </table>
        <table>
            <thead>
                <tr>
                    <th width="85%" style="border-top: 5px solid #03306D;background: #D2D2D2;text-align:center;">TOTAL </th>
                    <th width="15%" style="border-top: 5px solid #03306D;background: repeating-linear-gradient(-45deg,#03306D 0, #03306D 83%, #d2d2d2 0, #d2d2d2);color: black;text-align:center;">Q.{{number_format($total, 2)}}</th>
                </tr>
            </thead>
        </table>
</body>
</html>

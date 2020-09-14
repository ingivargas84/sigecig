<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=w, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de ventas de timbre </title>
    <style>
        p {
            font-family: "sans-serif";
            text-align: left;
            margin-left: 2rem;
            margin-right: 4rem;
        }
        label {
            font-family: "sans-serif";
        }
        tr:nth-child(even){
            background-color: #eee;
        }


        .colegiado{
            font-family: "sans-serif";
            font-size:1rem;
            /* font-weight: bold; */
            float:left;
        }
        .colegiado2{
            font-family: "sans-serif";
            font-size:1rem;
            font-weight: bold;
            margin-right: 15rem;
            float:right;
        }
  
        .img{
            height: 25px;
            width: 25px;
        }

        .odd th, .odd td {
            background: #eee;
        }
        table {
        font-family: "sans-serif";
        width: 100%;
        border-collapse: separate;
        }

    </style>
</head>
<body>
    
    <div class="row" style="font-family: sans-serif; height: 100px; ">
        <img style="float: left;" class="lg" src="images/logocig.png"  height="90"  alt="">
        <div class="" style="float: left; font-size: 12px; margin-top: 10px; margin-right: 100px;">
            <p><small>COLEGIO DE INGENIEROS DE GUATEMALA<br>
                    7a. Avenida 39-60, Zona 8 Guatemala, Guatemala <br>
                    PBX: 2218-2600 / www.cig.org.gt <br>
                    NIT: 299329-5</small></p>
         </div>
         <h1 style=" color: #03306d; ">Reporte de ventas de timbre </h1>
    </div>
    <hr style="height: 1px; background:#67a8ff">
  
    <div class="row colegiado">
        <div  class="">
            <label class="" ><b>Cajero: </b></label>
       <b>{{$cajero->name}}</b>
        </div>
        <div  class="">
            <label class="" ><b>Sede: </b></label>
            <b>{{$subsede->nombre_sede}} </b> 
        </div>
        <div class="" >
        <label class=""><b>Fecha: </b> </label>
        <b>        {{ \Carbon\Carbon::parse($fechaInicial)->format('d/m/Y')}} - {{ \Carbon\Carbon::parse($fechaFinal)->format('d/m/Y')}}
        </b> 
        </div><br><br>
        <br>
        <br>
    </div>
    <br>
        <table style="margin-top: 4rem; ">
            <thead >
                <tr>
                    <th colspan="9" style="background: white;text-align:center;">REPORTE RESUMIDO</th>
                </tr>
                <tr>
                    <th style="background: #D2D2D2;text-align:center;"></th>
                    <th colspan="2" style="background: #D2D2D2;text-align:center;">Saldo Anterior</th>
                    <th colspan="2" style="background: #D2D2D2;text-align:center;">Remesas </th>
                    <th colspan="2" style="background: #D2D2D2;text-align:center;">Ventas</th>
                    <th colspan="2" style="background: #D2D2D2;text-align:center;">Saldo Actual</th>
                </tr>
                <tr>
                    <th style="background: #D2D2D2;text-align:center; padding: 4px;">Denominación</th>
                    <th style="background: #D2D2D2;text-align:center;">Cantidad</th>
                    <th style="background: #D2D2D2;text-align:center;">Valor</th>
                    <th style="background: #D2D2D2;text-align:center;">Cantidad</th>
                    <th style="background: #D2D2D2;text-align:center;">Valor</th>
                    <th style="background: #D2D2D2;text-align:center;">Cantidad</th>
                    <th style="background: #D2D2D2;text-align:center;">Valor</th>
                    <th style="background: #D2D2D2;text-align:center;">Cantidad</th>
                    <th style="background: #D2D2D2;text-align:center;">Valor</th>
                </tr>
            </thead>
            @foreach($arrayDatos as $co)
            <tr >
                <td style="background:eee;">{{$co->descripcion}}</td>
                <td style="background:eee;text-align:right;">{{$co->existenciaAnterior}}</td>
                <td style="background:eee;text-align:right;"> Q. {{number_format($co->valorExistenciaAnterior,2,".","")}}</td>
                <td style="background:eee;text-align:right;">{{$co->remesas}}</td>
                <td style="background:eee;text-align:right;">Q. {{number_format($co->valorRemesa,2,".","")}}</td>
                <td style="background:eee;text-align:right;">{{$co->ventaActual}}</td>
                <td style="background:eee;text-align:right;">Q. {{number_format($co->valorVentaActual,2,".","")}}</td>
                <td style="background:eee;text-align:right;">{{$co->saldoActual}}</td>
                <td style="background:eee;text-align:right;">Q. {{number_format($co->valorSaldoActual,2,".","")}}</td>
            </tr>
            @endforeach
            <tr>
                <th style="background: #D2D2D2;">Total General</th>
                <th style="background: #D2D2D2;text-align:right;">{{$arrayTotales['totalGeneralExistenciaAnterior']}}</th>
                <th style="background: #D2D2D2;text-align:right;">Q. {{number_format($arrayTotales['totalGeneralValorExistenciaAnterior'],2,".","")}}</th>
                <th style="background: #D2D2D2;text-align:right;">{{$arrayTotales['totalGeneralRemesa']}}</th>
                <th style="background: #D2D2D2;text-align:right;">Q. {{number_format($arrayTotales['totalGeneralValorRemesa'],2,".","")}}</th>
                <th style="background: #D2D2D2;text-align:right;">{{$arrayTotales['totalGeneralVentaActual']}}</th>
                <th style="background: #D2D2D2;text-align:right;">Q. {{number_format($arrayTotales['totalGeneralValorVentaActual'],2,".","")}}</th>
                <th style="background: #D2D2D2;text-align:right;">{{$arrayTotales['totalGeneralSaldoActual']}}</th>
                <th style="background: #D2D2D2;text-align:right;">Q. {{number_format($arrayTotales['totalGeneralValorSaldoActual'],2,".","")}}</th>
            </tr>
        </table>

        {{--  --}}
       <br>
        <table >
            <thead >
                <tr>
                    <th colspan="6" style="background: white;text-align:center;">REPORTE DETALLADO</th>
                </tr>
                <tr>
                    <th width="7%" style="background: #D2D2D2;text-align:center;">Colegiado</th>
                    <th width="33%" style="background: #D2D2D2;text-align:center;">Nombre</th>
                    <th width="5%" style="background: #D2D2D2;text-align:center;">Cantidad</th>
                    <th width="33%" style="background: #D2D2D2;text-align:center;">Timbre</th>
                    <th width="15%" style="background: #D2D2D2;text-align:center;">Numeración Asignada</th>
                    <th width="8%" style="background: #D2D2D2;text-align:center;">Total</th>
                </tr>
            </thead>
            @foreach($datos as $co)
            <tr >
                <td style="background:eee;">{{$co->numero_de_identificacion}}</td>
                <td style="background:eee;">{{$co->nombre}}</td>
                <td style="background:eee;text-align:center;">{{$co->cantidad}}</td>
                <td style="background:eee;">{{$co->tipo_de_pago}}</td>
                <td style="background:eee;text-align:left;">
                    @if ($co->cantidad == 1)
                    {{$co->numeracion_inicial}}
                    @else
                    {{$co->numeracion_inicial}} - {{$co->numeracion_final}}
                    @endif
                    </td>
                <td style="background:eee;text-align:right;">Q. {{number_format($co->total,2,".","")}} </td>
            </tr>
            @endforeach
        </table>
        <br>
        {{--  --}}
        <div >
          <label><b>REPORTE CREADO POR: {{$user->name}}</b> <?php echo date("d/m/Y H:i:s");?></label>
        </div>
</body>
</html>

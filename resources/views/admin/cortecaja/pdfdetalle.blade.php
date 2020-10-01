<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalle de Corte de Caja</title>
    <style>
        tr:nth-child(even){
            background-color: #eee;
        }
       table {
            width: 90%;
            margin: 20 auto;
            font-family: "sans-serif";
            border-collapse: collapse;
        }
        .texto{
            display: inline-block;
            vertical-align: top;
            margin-left: 0.5rem;
            font-size:13px;
            margin-top: 1.5rem;
            width: 42%;
        }
        .texto1 {
            font-size:20px;
            font-weight: bold;
            color:black;
            height: 10px;
            display: inline-block;
            vertical-align: top;
            margin-bottom: 0.2rem;
            margin-left: 0.5rem;
            margin-top: 1.5rem;

        }
        .lg{
            margin-left: 2rem;
            margin-top: 1rem;
            margin-bottom: 0.2rem;
        }
        .colegiado{
            font-family: "sans-serif";
            font-size:1rem;
            margin-left: 2rem;
            float:left;
        }
    </style>   
</head>
<body>
    <div class="container body" style="margin-bottom: 25px; border-bottom: 4px solid #03306d; height: 12%;">
        <div class="row" style="font-family: sans-serif; height: 190px; margin-left: 1rem;">
            <img class="lg" src="images/logocig.png"  height="60"  alt="">
            <div class="texto">
            <p><small>COLEGIO DE INGENIEROS DE GUATEMALA<br>
                    7a. Avenida 39-60, Zona 8 Guatemala, Guatemala <br>
                    PBX: 2218-2600 / www.cig.org.gt <br>
                    NIT: 299329-5</small></p>
        </div>
            <div class="texto1" style="color: #03306d; background: white;height: 20px; width: 22%; margin-right: 0.5rem;">
            <h3 > Corte de Caja</h3>
        </div>
        </div>
    </div>
   
    <br>
     <h3 style="color: #03306d;text-align: center; font-family: sans-serif;"> Detalles </h3>
    <table style="width: 90%; margin: 20 auto; font-family: sans-serif; ">
        <thead>
            <tr>
                <th width="33%" style="background: #D2D2D2;text-align:center;">No. Recibo</th>
                <th width="34%" style="background: #D2D2D2;text-align:center;">Total</th>
                <th width="33%" style="background: #D2D2D2;text-align:center;">Serie</th>
            </tr>
        </thead>
             @foreach ($rec as $rp)
            <tr>
                <td>{{$rp->numero_recibo}}</td>
                <td style="text-align:right">Q. {{number_format($rp->monto_total,2)}}</td>
                <td style="text-align:right">{{\App\SerieRecibo::find($rp->serie_recibo_id)->serie_recibo}}</td>
            </tr>
            @endforeach 
    </table>
<br>
<h3 style="color: #03306d;text-align: center; font-family: sans-serif;"> Total Recibido </h3>
    <table style="width: 90%; margin: 20 auto; font-family: sans-serif;">
        <thead>
            <tr>
                <th width="25%" style="background: #D2D2D2;text-align:center;">Total Efectivo</th>
                <th width="25%" style="background: #D2D2D2;text-align:center;">Total Cheque</th>
                <th width="25%" style="background: #D2D2D2;text-align:center;">Total Tarjeta</th>
                <th width="25%" style="background: #D2D2D2;text-align:center;">Total Depósito</th>
            </tr>
        </thead>
            <tr>
                <td style="text-align:right">Q. {{number_format($id->total_efectivo,2)}}</td>
                <td style="text-align:right">Q. {{number_format($id->total_cheque,2)}}</td>
                <td style="text-align:right">Q. {{number_format($id->total_tarjeta,2)}}</td>
                <td style="text-align:right">Q. {{number_format($id->total_deposito,2)}}</td>
            </tr>
    </table>
    <div class="row colegiado">
        <div class="" >
          <label class="" style="margin: 20 auto; margin-left: 2rem;"><b>FECHA DE CREACIÓN: </b> {{$id->fecha_corte}}</label>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
        <p style="text-align: center">__________________________
        <p style="text-align: center; font-family: sans-serif;">Firma de Cajero
        <p style="text-align: center; font-family: sans-serif;"> {{$user->name}}
</body>
</html>
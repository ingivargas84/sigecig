<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=w, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo Electrónico</title>
    <style>
        p {
            font-family: "sans-serif";
            text-align: left;

        }
        tr:nth-child(even){
            background-color: #eee;
        }

        .texto{
            display: inline-block;
            vertical-align: top;
            margin-top: 2rem;
        }
 
        .texto3 {
            background: #D2D2D2;
        }

        .colegiado{
            font-family: "sans-serif";
            font-size:1rem;
            font-weight: bold;
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
            width: 100%;
            margin: 20 auto;
            font-family: "sans-serif";
        }
      /*   table, td, th {
            border-collapse: collapse;
            border: 1px solid black;
            margin: 20 auto;
            text-align: center;
            width: 90%;
            font-family: "sans-serif";
            height: 30px;
        }*/
        .odd th, .odd td {
            background: #eee;
        }
        #qr{

        }
    </style>
</head>
<body>
  
        <div class="row" style="font-family: sans-serif; height: 100px; ">
            <img style="float: left;"  src="images/logocig.png"  height="90"  alt="">
            <div class="" style="float: left; font-size: 12px; margin-right: 150px; margin-left: 30px;">
                <p><small>COLEGIO DE INGENIEROS DE GUATEMALA<br>
                        7a. Avenida 39-60, Zona 8 Guatemala, Guatemala <br>
                        PBX: 2218-2600 / www.cig.org.gt <br>
                        NIT: 299329-5</small></p>
             </div>
                 <div class="texto1" style="float: right; color: white; background: #03306d;height: 95px; width: 10%; align-items: center ">
                    <img id="qr" style="height: 80%; margin-right: 10px; margin-top: 10px" src="data:image/png;base64,{!! base64_encode($codigoQR) !!}">
                </div>
                <div style="float: right; background: #03306d;height: 95px; color: white; width: 20%; font-size: 20px; text-indent: 20%">
                    <h1>RECIBO</h1>
                 </div>
            </div>
        <hr style="height: 1px; background:#67a8ff">


 
    <div class="row colegiado ">
        <div class="">
          <label for="" class="interesado">RECIBIMOS DE: {{$reciboMaestro->nombre}} </label>
        </div>
        <div class="">
          <label for="" class="" >FECHA:  {{ \Carbon\Carbon::parse($reciboMaestro->created_at)->format('d/m/Y H:m:s')}}</label>
        </div>
    </div>
    <div class="row colegiado3">
        <div class="">
          <label for="" class=" ">No. {{$reciboMaestro->numero_recibo}}  </label>
        </div>
    </div>
    <div class="row colegiado2">
        @if ($tipo == 1 )
        <div class="">
          <label for="" class=" ">COLEGIADO NO: {{$reciboMaestro->numero_de_identificacion}} </label>
        </div>
        @endif
        @if ($tipo == 3)
        <div class="">
            <label for="" >NIT: {{$reciboMaestro->numero_de_identificacion}}</label>
          </div>
        @endif
   
    </div>
      <br>
        <table>
            <thead>
                <tr>
                    <th width="20%" style="background: #D2D2D2;text-align:center;">CODIGO</th>
                    <th width="50%" style="background: #D2D2D2;text-align:center;">DESCRIPCION</th>
                    <th width="15%" style="background: #D2D2D2;text-align:center;">CANTIDAD </th>
                    <th width="15%" style="background: #D2D2D2;text-align:center;">TOTAL</th>
                </tr>
            </thead>
            @foreach($datos as $co)
            <tr >
                <td style="background:eee;text-align:left;padding: 4px;" >{{$co->codigo_compra}}</td>
                <td style="background:eee;text-align:left;">{{$co->tipo_de_pago}}</td>
                <td style="background:eee;text-align:center;">{{$co->cantidad}}</td>
                <td style="background:eee;text-align:center;">Q.{{number_format($co->total, 2)}}</td>
            </tr>
            @endforeach
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="2" style="border-top: 5px solid #03306D;text-align:left;background: repeating-linear-gradient(-45deg,#d2d2d2 0, #d2d2d2 7%, white 0, white); font-weight:normal;padding: 7px" >TOTAL EN LETRAS: {{$letras}}</th>
                    <th width="15%" style="border-top: 5px solid #03306D;background: #D2D2D2;text-align:center;">TOTAL </th>
                    <th width="15%" style="border-top: 5px solid #03306D;background: repeating-linear-gradient(-45deg,#03306D 0, #03306D 83%, #d2d2d2 0, #d2d2d2);color: black;text-align:center;">Q.{{number_format($reciboMaestro->monto_total, 2)}}</th>
                </tr>
            </thead>
                 <tr class="odd">
                    <th colspan="4" style="border-bottom: 5px solid #03306D;text-align:left;font-weight:normal;padding: 7px">CONCEPTO:
                        @if ($reciboMaestro->monto_tarjeta==true) TARJETA DE CREDITO O DEBITO
                        @endif
                        @if ($reciboMaestro->monto_efecectivo==true) EFECTIVO
                        @endif
                    </th>
            </tr>
        </table>
        <p class="texto3"><small>Exento ISR según Numeral 1, Artículo 11, Decreto 10-2012, Ley de Actualización Tributaria, Exento IVA
            según Numeral 10, Artículo 7, Decreto 27-92, Ley del Impuesto al Valor Agregado. Los cheques se reciben bajo reserva usual de cobro, si el cheque
            es devuelto, la operación que amparó este comprobante no tendrá validez de conformidad con el Artículo 1394 del Código Civil. Por cada cheque rechazado el colegio cobrará Q100.00 por gastos
            administrativos y quedará anulado el cobro. Los pagos de cuotas ordinaria, incluyen auxilio póstumo, colegios profesionales y cuota universitaria.</small></p>
</body>
</html>

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
            margin-left: 4rem;
            margin-right: 4rem;
        }
        tr:nth-child(even){
            background-color: #eee;
        }
       /*  .body{
            background: rgb(125, 178, 228);
            width: 90%;
            margin-left: 4rem;
            height: 190px;
        } */
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
            margin-bottom: 1rem;
        }
        .texto{
            display: inline-block;
            vertical-align: top;
            margin-top: 2rem;
        }
        .texto1 {
            font-size:35px;
            font-weight: bold;
            color:black;
            height: 50px;
            display: inline-block;
            vertical-align: top;
            margin-top: 1rem;
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
        }
      /*   table, td, th {
            border-collapse: collapse;
            border: 1px solid black;
            margin: 20 auto;
            text-align: center;
            width: 90%;
            font-family: "sans-serif";
            height: 30px; */
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
<div class="container body" style="margin-bottom: 15px;">
    <div class="row" style="font-family: sans-serif; margin-bottom:3rem; height: 190px; margin-left: 4rem;">
            <img class="lg" src="images/logo.png"  height="190"  alt="">
            <div class="texto">
            <p><small>COLEGIO DE INGENIEROS DE GUATEMALA<br>
                            7a. Avenida 39-60, Zona 8 Guatemala, Guatemala <br>
                            PBX: 2218-2600 / www.cig.org.gt <br>
                            NIT: 299329-5</small></p>
            </div>
            <div class="texto1" style="color: white; background: #03306d;height: 160px; width: 35%; margin-right: 4rem;"><h1> RECIBO <img id="qr" src="data:image/png;base64,{!! base64_encode($codigoQR) !!}"></h1></div>
        </div>
    </div>
</div>
    <div class="row colegiado ">
        <div class="">
          <label for="" class="interesado">RECIBIMOS DE: {{$id->nombre}} </label>
        </div>
        <div class="">
          <label for="" class="" >FECHA: {{$id->created_at}} </label>
        </div>
    </div>
    <div class="row colegiado3">
        <div class="">
          <label for="" class=" ">No. {{$id->numero_recibo}}  </label>
        </div>
    </div>
    <div class="row colegiado2">
        <div class="">
          <label for="" class=" ">COLEGIADO NO: {{$id->numero_de_identificacion}} </label>
        </div>
        <div class="">
          <label for="" >NIT: {{$nit_->nit}}</label>
        </div>
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
            @if($co->id%2==0)
            <tr>
                <td style="background:white;text-align:center;padding: 7px;">{{$co->codigo_compra}}</td>
                <td style="background:white;text-align:center;">{{$co->tipo_de_pago}}</td>
                <td style="background:white;text-align:center;">{{$co->cantidad}}</td>
                <td style="background:white;text-align:center;">Q.{{number_format($co->total, 2)}}</td>
            </tr>
            @else
            <tr>
                <td style="background:#eee;text-align:center;padding: 7px;">{{$co->codigo_compra}}</td>
                <td style="background:#eee;text-align:center;">{{$co->tipo_de_pago}}</td>
                <td style="background:#eee;text-align:center;">{{$co->cantidad}}</td>
                <td style="background:#eee;text-align:center;">Q.{{number_format($co->total, 2)}}</td>
            </tr>
            @endif
            @endforeach
        </table>
        <table>
            <thead>
                <tr>
                    <th colspan="2" style="border-top: 5px solid #03306D;text-align:left;background: repeating-linear-gradient(-45deg,#d2d2d2 0, #d2d2d2 7%, white 0, white); font-weight:normal;padding: 7px" >TOTAL EN LETRAS: {{$letras}}</th>
                    <th width="15%" style="border-top: 5px solid #03306D;background: #D2D2D2;text-align:center;">TOTAL </th>
                    <th width="15%" style="border-top: 5px solid #03306D;background: repeating-linear-gradient(-45deg,#03306D 0, #03306D 83%, #d2d2d2 0, #d2d2d2);color: black;text-align:center;">Q.{{number_format($id->monto_total, 2)}}</th>
                </tr>
            </thead>
                 <tr class="odd">
                    <th colspan="4" style="border-bottom: 5px solid #03306D;text-align:left;font-weight:normal;padding: 7px">CONCEPTO: 
                        @if ($id->monto_efecectivo==true) EFECTIVO                       
                        @endif
                        @if ($id->monto_cheque==true) CHEQUE
                        @endif
                        @if ($id->monto_tarjeta==true) TARJETA DE CREDITO
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
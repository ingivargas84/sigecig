<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=w, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de envíos de timbre </title>
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
        td {
        border:1px solid black;
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
         <h1 style=" color: #03306d; ">Reporte de envíos de XYZ </h1>
    </div>
    <hr style="height: 1px; background:#67a8ff">
  
    <div class="row colegiado">

        <div class="" >
        <label class=""><b>Fecha de Reporte: </b> </label>
        <b>        {{ \Carbon\Carbon::parse($fechaInicial)->format('d/m/Y')}} - {{ \Carbon\Carbon::parse($fechaFinal)->format('d/m/Y')}}
        </b> 
        </div>
        <div class="" >
            <label class=""><b>Total: </b> </label>
            <b>Q. {{number_format($total,2,".","")}}
            </b> 
            </div>
    </div>
    <br><br>

            @foreach ($arrayDetalles as $key => $detalles)
                @foreach ($detalles as $detalle)
                @if ($loop->first)
                 <table>
                    <thead >
                
                        <tr>
                            <th width style="background: #D2D2D2;text-align:left;">Colegiado:</th>
                            <th width="" colspan="2" style="background: #D2D2D2;text-align:left;">Nombre:</th>
                            <th width="" colspan="2" style="background: #D2D2D2;text-align:left;">Bodega:</th>
                            <th width="" colspan="2" style="background: #D2D2D2;text-align:left;">Vendedor:</th>
                        </tr>
                        <tr>
                            <th  style="background: #edecec;text-align:center;">{{$detalle->c_cliente}}</th>
                            <th colspan="2"  style="background: #edecec;text-align:center;">{{$detalle->n_cliente}}</th>
                            <th colspan="2" style="background: #edecec;text-align:center;">{{$detalle->n_bodega}}</th>
                            <th colspan="2"  style="background: #edecec;text-align:center;">{{$detalle->n_vendedor}}</th>
                        </tr>
                    </thead>
                    <thead >
                
                        <tr>
                            <th width="" style="background: #D2D2D2;text-align:left;">Serie:</th>
                            <th width="" style="background: #D2D2D2;text-align:left;">No. Factura:</th>
                            <th width="" style="background: #D2D2D2;text-align:left;">Efectivo:</th>
                            <th width="" style="background: #D2D2D2;text-align:left;">Tarjeta:</th>
                            <th width="" style="background: #D2D2D2;text-align:left;">Cheque:</th>
                            <th width="" style="background: #D2D2D2;text-align:left;">Total Facturado:</th>
                            <th width="" style="background: #D2D2D2;text-align:left;">Fecha:</th>
                        </tr>
                        <tr>
                            <th  style="background: #edecec;text-align:center;">{{$detalle->serie_f}}</th>
                            <th  style="background: #edecec;text-align:center;">{{$detalle->num_fac}}</th>
                            <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->efectivo,2,".","")}}</th>
                            <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->tarjeta,2,".","")}}</th>
                            <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->cheque,2,".","")}}</th>
                            <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->total_fac,2,".","")}}</th>
                            <th  style="background: #edecec;text-align:center;">{{ \Carbon\Carbon::parse($detalle->fecha1)->format('d/m/Y H:i:s')}}</th>

                        </tr>
                    </thead>
                 </table><br>
                 <table>
                    <thead >
                        <tr>
                            <th width="15%" style="background: #D2D2D2;text-align:center;">Codigo</th>
                            <th width="50%" style="background: #D2D2D2;text-align:center;">Tipo de Pago</th>
                            <th width="15%" style="background: #D2D2D2;text-align:center;">Cantidad</th>
                            <th width="10%" style="background: #D2D2D2;text-align:center;">Precio Unitario</th>
                            <th width="10%" style="background: #D2D2D2;text-align:center;">Total</th>
                        </tr>
                    </thead>
                 </table>
                @endif
                <table >
                    <tr >
                        <td width="15%" style="background:edecec;text-align:left;">{{$detalle->codigo}}</td>
                        <td width="50%" style="background:edecec;text-align:left;">{{$detalle->descripcion}}</td>
                        <td width="15%" style="background:edecec;text-align:right;">{{$detalle->cantidad}}</td>
                        <td  width="10%" style="background:edecec;text-align:right;">Q. {{$detalle->precio_u}}</td>
                        <td width="10%" style="background:edecec;text-align:right;">Q. {{$detalle->importe}}</td>
                    </tr>
                </table>
                @endforeach
                <br><br>

            @endforeach

        <br>
        {{--  --}}
        <div >
          <label><b>REPORTE CREADO POR: {{$user->name}}</b> <?php echo date("d/m/Y H:i:s");?></label>
        </div>
</body>
</html>

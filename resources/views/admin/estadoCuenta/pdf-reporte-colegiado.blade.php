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
         <h1 style=" color: #03306d; ">Reporte estado de cuenta colegiado </h1>
    </div>
    <hr style="height: 1px; background:#67a8ff">

    <table>
        <thead >
            <tr>
                <th width=""   style="background: #D2D2D2;text-align:left;">No. Colegiado:</th>
                <th width="35%"  style="background: #D2D2D2;text-align:left;">Colegiado:</th>
                <th width=""  style="background: #D2D2D2;text-align:left;">Telefono:</th>
                <th width="25%"  style="background: #D2D2D2;text-align:left;">Correo:</th>
                <th width=""  style="background: #D2D2D2;text-align:left;">DPI:</th>
                <th width=""  style="background: #D2D2D2;text-align:left;">Estado:</th>

            </tr>
            
            <tr>
                <th  style="background: #edecec;text-align:center;">{{$colegiado->c_cliente}}</th>
                <th   style="background: #edecec;text-align:center;">{{$colegiado->n_cliente}}</th>
                <th   style="background: #edecec;text-align:center;">{{$colegiado->telefono}}</th>
                <th   style="background: #edecec;text-align:center;">{{$colegiado->e_mail}}</th>
                <th   style="background: #edecec;text-align:center;">{{$colegiado->registro}}</th>
                <th  style="background: #edecec;text-align:center;">{{$colegiado->estado}}</th>

            </tr>
        </thead>
     </table>
     <h3>SALDOS</h3>
    
         @if ($diffTimbre != 0)
            @if ($diffTimbre  < 0)
            <h4>CUOTAS DE TIMBRE A FAVOR</h4>
            @endif
            @if ($diffTimbre  > 0)
            <h4>CUOTAS DE TIMBRE PENDIENTES</h4>
            @endif
            <table>
            <thead >
                <tr>
                    <th width="12%"   style="background: #D2D2D2;text-align:left;">Codigo:</th>
                    <th width="41%"  style="background: #D2D2D2;text-align:left;">Descripción:</th>
                    <th width="20%"  style="background: #D2D2D2;text-align:left;">Periodo:</th>
                    <th width="9%"  style="background: #D2D2D2;text-align:left;">Cantidad:</th>
                    <th width="9%"  style="background: #D2D2D2;text-align:left;">Precio:</th>
                    <th width="9%"  style="background: #D2D2D2;text-align:left;">Total:</th>
                </tr>
            </thead>

                @foreach($arrayTimbre as $timbre)
                <tr>
                    <td  style="background: #edecec;text-align:left;">{{$timbre->codigo}}</td>
                    <td   style="background: #edecec;text-align:left;">{{$timbre->tipoPago}}</td>
                    <td   style="background: #edecec;text-align:left;">{{$timbre->fechaTimbre}}</td>
                    <td   style="background: #edecec;text-align:center;">{{$timbre->cantidad}}</td>
                    <td   style="background: #edecec;text-align:right;">Q. {{number_format($timbre->precio,2,".","")}}</td>
                    <td   style="background: #edecec;text-align:right;">Q. {{number_format($timbre->total,2,".","")}}</td>
    
                </tr>
                @endforeach
                    <tr>
                        <th width=""  colspan="5"  style="background: #D2D2D2;text-align:left;">Total:</th>
                        <th width=""  style="background: #D2D2D2;text-align:right;">Q. {{number_format($totalTimbre,2,".","")}}</th>
                    </tr>
              
         
                   
                
        </table>
         @endif
         @if ($diffColegio != 0)
         @if ($diffColegio  < 0)
         <h4>CUOTAS DE COLEGIATURA A FAVOR</h4>
         @endif
         @if ($diffColegio  > 0)
         <h4>CUOTAS DE COLEGIATURA PENDIENTES</h4>
         @endif
         <table>
         <thead >
             <tr>
                 <th width="12%"   style="background: #D2D2D2;text-align:left;">Codigo:</th>
                 <th width="41%"  style="background: #D2D2D2;text-align:left;">Descripción:</th>
                 <th width="20%"  style="background: #D2D2D2;text-align:left;">Periodo:</th>
                 <th width="9%"  style="background: #D2D2D2;text-align:left;">Cantidad:</th>
                 <th width="9%"  style="background: #D2D2D2;text-align:left;">Precio:</th>
                 <th width="9%"  style="background: #D2D2D2;text-align:left;">Total:</th>
 
             </tr>
            </thead>

             @foreach($arrayColegiatura as $colegiatura)
             <tr>
                <td  style="background: #edecec;text-align:left;">{{$colegiatura->codigo}}</td>
                <td   style="background: #edecec;text-align:left;">{{$colegiatura->tipoPago}}</td>
                <td   style="background: #edecec;text-align:left;">{{$colegiatura->fechaPago}}</td>
                <td   style="background: #edecec;text-align:center;">{{$colegiatura->cantidad}}</td>
                <td   style="background: #edecec;text-align:right;">Q. {{number_format($colegiatura->precio,2,".","")}}</td>
                <td   style="background: #edecec;text-align:right;">Q. {{number_format($colegiatura->total,2,".","")}}</td>
            </tr>
             @endforeach
             <tr>
                <th width=""  colspan="5"  style="background: #D2D2D2;text-align:left;">Total:</th>
                <th width=""  style="background: #D2D2D2;text-align:right;">Q. {{number_format($totalColegiatura,2,".","")}}</th>
         
    
            </tr>
        </table>
        @endif

    

  
    <h3>DETALLE DE VENTAS</h3>
    <h3>VENTAS SIGECIG</h3>
    @foreach ($arrayDetallesSigecig as $key => $detalles)
        @foreach ($detalles as $detalle)
        @if ($loop->first)
         {{-- <table>
            <thead >
        
                <tr>
                    <th width="" colspan="2" style="background: #D2D2D2;text-align:left;">Bodega:</th>
                    <th width="" colspan="2" style="background: #D2D2D2;text-align:left;">Vendedor:</th>
                    <th width="" colspan="2" style="background: #D2D2D2;text-align:left;">Sede:</th>
                    <th width="" colspan="1" style="background: #D2D2D2;text-align:left;">Fecha:</th>

                </tr>
                <tr>
                    <th colspan="2" style="background: #edecec;text-align:center;">{{$detalle->nombre_bodega}}</th>
                    <th colspan="2"  style="background: #edecec;text-align:center;">{{$detalle->name}}</th>
                    <th colspan="2"  style="background: #edecec;text-align:center;">{{$detalle->nombre_sede}}</th>
                    <th colspan="1" style="background: #edecec;text-align:center;">{{ \Carbon\Carbon::parse($detalle->created_at)->format('d/m/Y H:i:s')}}</th>

                </tr>
            </thead>
            <thead >
        
                <tr>
                    <th width="" style="background: #D2D2D2;text-align:left;">Serie:</th>
                    <th width="" style="background: #D2D2D2;text-align:left;">No. Factura:</th>
                    <th width="" style="background: #D2D2D2;text-align:left;">Efectivo:</th>
                    <th width="" style="background: #D2D2D2;text-align:left;">Tarjeta:</th>
                    <th width="" style="background: #D2D2D2;text-align:left;">Cheque:</th>
                    <th width="" style="background: #D2D2D2;text-align:left;">Depósito:</th>
                    <th width="" style="background: #D2D2D2;text-align:left;">Total Facturado:</th>
                </tr>
                <tr>
                    <th  style="background: #edecec;text-align:center;">{{$detalle->serie_recibo}}</th>
                    <th  style="background: #edecec;text-align:center;">{{$detalle->numero_recibo}}</th>
                    <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->monto_efecectivo,2,".","")}}</th>
                    <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->monto_tarjeta,2,".","")}}</th>
                    <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->monto_cheque,2,".","")}}</th>
                    <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->monto_deposito,2,".","")}}</th>
                    <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->monto_total,2,".","")}}</th>

                </tr>
            </thead>
         </table><br> --}}
         <table>
            <thead >
                <tr>
                    <th width="4%" style="background: #D2D2D2;text-align:center;">Serie</th>
                    <th width="8%" style="background: #D2D2D2;text-align:center;">No. Recibo</th>
                    <th width="13%" style="background: #D2D2D2;text-align:center;">Fecha</th>
                    <th width="10%" style="background: #D2D2D2;text-align:center;">Codigo</th>
                    <th width="45%" style="background: #D2D2D2;text-align:center;">Tipo de Pago</th>
                    <th width="7%" style="background: #D2D2D2;text-align:center;">Cantidad</th>
                    <th width="7%" style="background: #D2D2D2;text-align:center;">Precio</th>
                    <th width="8%" style="background: #D2D2D2;text-align:center;">Total</th>
                </tr>
            </thead>
         </table>
        @endif
        <table >
            <tr >
                <td width="4%" style="background:edecec;text-align:left;">{{$detalle->serie_recibo}}</td>
                <td width="8%" style="background:edecec;text-align:left;">{{$detalle->numero_recibo}}</td>
                <td width="13%" style="background:edecec;text-align:left;">{{ \Carbon\Carbon::parse($detalle->created_at)->format('d/m/Y H:i:s')}}</td>
                <td width="10%" style="background:edecec;text-align:left;">{{$detalle->codigo}}</td>
                <td width="45%" style="background:edecec;text-align:left;">{{$detalle->tipo_de_pago}}</td>
                <td width="7%" style="background:edecec;text-align:right;">{{$detalle->cantidad}}</td>
                <td  width="7%" style="background:edecec;text-align:right;">Q. {{number_format($detalle->precio_unitario,2,".","")}}</td>
                <td width="8%" style="background:edecec;text-align:right;">Q. {{number_format($detalle->total,2,".","")}}</td>
            </tr>
        </table>
        @endforeach
        <table>
            <thead >
                <tr>
                    <th width="92%" style="background: #D2D2D2;text-align:left;">Total</th>
                    <th  width="8%" style="background: #D2D2D2;text-align:right;">Q. {{number_format($detalle->monto_total,2,".","")}}</th>
              
                </tr>
            </thead>
         </table>
        <br><br>

    @endforeach
  
    <h3>VENTAS XYZ</h3>
            @foreach ($arrayDetalles as $key => $detalles)
                @foreach ($detalles as $detalle)
                @if ($loop->first)
                 {{-- <table>
                    <thead >
                
                        <tr>
                            <th width="" colspan="2" style="background: #D2D2D2;text-align:left;">Bodega:</th>
                            <th width="" colspan="2" style="background: #D2D2D2;text-align:left;">Vendedor:</th>
                            <th width="" colspan="2" style="background: #D2D2D2;text-align:left;">Fecha:</th>

                        </tr>
                        <tr>
                            <th colspan="2" style="background: #edecec;text-align:center;">{{$detalle->n_bodega}}</th>
                            <th colspan="2"  style="background: #edecec;text-align:center;">{{$detalle->n_vendedor}}</th>
                            <th colspan="2" style="background: #edecec;text-align:center;">{{ \Carbon\Carbon::parse($detalle->fecha1)->format('d/m/Y H:i:s')}}</th>

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
                        </tr>
                        <tr>
                            <th  style="background: #edecec;text-align:center;">{{$detalle->serie_f}}</th>
                            <th  style="background: #edecec;text-align:center;">{{$detalle->num_fac}}</th>
                            <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->efectivo,2,".","")}}</th>
                            <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->tarjeta,2,".","")}}</th>
                            <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->cheque,2,".","")}}</th>
                            <th  style="background: #edecec;text-align:center;">Q. {{number_format($detalle->total_fac,2,".","")}}</th>

                        </tr>
                    </thead>
                 </table><br> --}}
                 <table>
                    <thead >
                        <tr>
                            <th width="4%" style="background: #D2D2D2;text-align:center;">Serie</th>
                            <th width="8%" style="background: #D2D2D2;text-align:center;">No. Factura</th>
                            <th width="13%" style="background: #D2D2D2;text-align:center;">Fecha</th>
                            <th width="10%" style="background: #D2D2D2;text-align:center;">Codigo</th>
                            <th width="45%" style="background: #D2D2D2;text-align:center;">Tipo de Pago</th>
                            <th width="7%" style="background: #D2D2D2;text-align:center;">Cantidad</th>
                            <th width="7%" style="background: #D2D2D2;text-align:center;">Precio</th>
                            <th width="8%" style="background: #D2D2D2;text-align:center;">Total</th>
                        </tr>
                    </thead>
                 </table>
                @endif
                <table >
                    <tr >
                        <td width="4%" style="background:edecec;text-align:left;">{{$detalle->serie_f}}</td>
                        <td width="8%" style="background:edecec;text-align:left;">{{$detalle->num_fac}}</td>
                        <td width="13%" style="background:edecec;text-align:right;">{{ \Carbon\Carbon::parse($detalle->fecha1)->format('d/m/Y H:i:s')}}</td>
                        <td width="10%" style="background:edecec;text-align:left;">{{$detalle->codigo}}</td>
                        <td width="45%" style="background:edecec;text-align:left;">{{$detalle->descripcion}}</td>
                        <td width="7%" style="background:edecec;text-align:right;">{{number_format($detalle->cantidad,2,".","")}}</td>
                        <td  width="7%" style="background:edecec;text-align:right;">Q. {{number_format($detalle->precio_u,2,".","")}}</td>
                        <td width="8%" style="background:edecec;text-align:right;">Q. {{number_format($detalle->importe,2,".","")}}</td>
                    </tr>
                </table>
                @endforeach
                <table>
                    <thead >
                        <tr>
                            <th width="92%" style="background: #D2D2D2;text-align:left;">Total</th>
                            <th  width="8%" style="background: #D2D2D2;text-align:right;">Q. {{number_format($detalle->total_fac,2,".","")}}</th>
                      
                        </tr>
                    </thead>
                 </table>
                
                <br><br>

            @endforeach

        <br>
        {{--  --}}
        <div >
          <label><b>REPORTE CREADO POR: {{$user->name}}</b> <?php echo date("d/m/Y H:i:s");?></label>
        </div>
</body>
</html>

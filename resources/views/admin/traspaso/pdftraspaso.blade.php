<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=w, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte De Remesa</title>
    <style>
        /* p {
            font-family: "sans-serif";
            text-align: left;
            margin-left: 4rem;
            margin-right: 4rem;
        } */
        tr:nth-child(even){
            background-color: #eee;
        }
        .logo {
            text-indent: 20%;
        }
        .texto{
            display: inline-block;
            vertical-align: top;
            margin-left: 4rem;
        }
        .elements {
            padding: 10px;
            border-bottom: solid;
            border-bottom-color: black;
            padding-left:0;
        }
        .datos {
            font-size: 13px;
        }
        input {
            border: 0px solid;
            border-bottom: 0.4px solid ;
            text-align: center;
        }
        table {
            width: 98%;
            font-size: 13px;
        }
        table, tbody, tr, td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        th {
            /* border: 6px double black; */
            border: 1px solid black;
        }
        .derecha {
            text-align:right;
        }
        /* .izquierda {
            border-left: 6px double black;
        } */
        /* .abajo {
            border-bottom: 6px double black;
        } */
        .textZ {
            text-align:left;
        }
        .none {
            border: none;
        }
    </style>
</head>
<body>
    <div>
        <label>COLEGIO DE INGENIEROS DE GUATEMALA</label>
    </div>
    <div>
        <label>TIMBRE DE INGENIERIA</label>
    </div>
    <div>
        <label>GUATEMALA C.A.</label>
        <label style="margin-left: 24rem;text-align:right;">REMESA No. </label>
        <input type="text" size="5" name="NoRemesa" id="NoRemesa" value="{{$id->id}}">
    </div>
    <div class="container body" style="margin-top: 30px;">
        <span class="elements">
            <div class="row" style="font-family: sans-serif; margin-bottom:0rem; height: 90px; margin-left: 1rem;">
                <img class="logo" src="images/timbre.png"  height="110"  alt="">
                <div class="texto">
                    <h2>REMESA DE TIMBRES DE INGENIERIA</h2>
                </div>
            </div>
        </span>
    </div>
    <br>
    <div class="datos">

        <div>
            <label>El infrascrito Contador del Timbre de Ingeniería, por este medio remite para la venta al EXPENDEDOR</label>
            <input type="text" size="16" name="expendedorEspace" id="expendedorEspace">
        </div>
        <br>
        <div>
            <input type="text" size="36" name="expemdedor" id="expendedor" value="{{$nombreUsuarioDestino}}">,
            <label> quien se identifica con CUI No. </label>
            <input type="text" size="19" name="CUI" id="CUI" value="{{$cui}}">
        </div>
        <div style="margin-left: 8rem;">
            <label><small>Nombre y Apellidos</small></label>
        </div>
        <br>
        <div>
            <label>extendida en, </label>
            <input type="text" size="16" name="departamento" id="departamento" value="{{$ciudadOrigen}}">
            <input type="text" size="16" name="municipio" id="municipio" value="{{$ciudadOrigen}}">
            <label>ubicado en la Regional de</label>
            <input type="text" size="14" name="nombreLugar" id="nombreLugar" value="{{$ciudadDestino->descripcion}}">
        </div>
        <div style="margin-left: 9rem;">
            <label><small>Ciudad</small> <small style="margin-left: 8rem;">Municipio</small><small style="margin-left: 15rem;">Nombre del Lugar</small></label>
        </div>
        <br>
        <div>
            <input type="text" size="46" name="direccion" id="direccion" value="{{$sedeDestino->direccion}}">
            <input type="text" size="13" name="telefono" id="telefono" value="{{$sedeDestino->telefono}}">
            <input type="text" size="13" name="fax" id="fax" value="{{$sedeDestino->telefono_2}}">
        </div>
        <div style="margin-left: 9rem;">
            <label><small>Dirección</small> <small style="margin-left: 18rem;">Teléfono</small><small style="margin-left: 8rem;">Fax</small></label>
        </div>
        <br>
        <br>
        <span class="elements"><div></div></span>
    </div>
    <br>
    <br>
    <div style="margin-left: 1rem;">
        <table>
            <thead>
                <tr>
                    <th width="25%">DENOMINACION DE LA ESPECIE</th>
                    <th width="20%" colspan="2">NUMERACION DE LA SERIE DE TIMBRES</th>
                    <th width="12%">CANTIDAD UNIDADES</th>
                    <th width="13%">CANTIDAD TOTAL</th>
                    <th width="15%">VALOR EN QUETZALES</th>
                </tr>
            </thead>
            <br>
            <br>
            <tbody>
                @foreach($datos as $co)
                <tr>
                    <td height="17"><b>{{$co->descripcion}}</b></td>
                    <td class="derecha"><input type="number" name="iniciaTc01" id="iniciaTc01">{{$co->numeracion_inicial}}</td>
                    <td class="derecha"><input type="number" name="finTc01" id="finTc01">{{$co->numeracion_final}}</td>
                    <td class="derecha"><input type="number" name="unidadesTc01" id="unidadesTc01">{{$co->cantidad_a_traspasar}}</td>
                    <td class="derecha"><input type="number" name="totalTc01" id="totalTc01">
                        @if ($co->descripcion=='Timbres de precio de Q1.00') {{$co->cantidad_a_traspasar * 1}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q5.00') {{$co->cantidad_a_traspasar * 5}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q10.00') {{$co->cantidad_a_traspasar * 10}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q20.00') {{$co->cantidad_a_traspasar * 20}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q50.00') {{$co->cantidad_a_traspasar * 50}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q100.00') {{$co->cantidad_a_traspasar * 100}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q200.00') {{$co->cantidad_a_traspasar * 200}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q500.00') {{$co->cantidad_a_traspasar * 500}} @endif
                    </td>
                    <td class="derecha">Q.<input type="number" name="precioTc01" id="precioTc01">
                        @if ($co->descripcion=='Timbres de precio de Q1.00') Q.{{number_format($co->cantidad_a_traspasar * 1, 2)}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q5.00') {{number_format($co->cantidad_a_traspasar * 5, 2)}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q10.00') {{number_format($co->cantidad_a_traspasar * 10, 2)}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q20.00') {{number_format($co->cantidad_a_traspasar * 20, 2)}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q50.00') {{number_format($co->cantidad_a_traspasar * 50, 2)}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q100.00') {{number_format($co->cantidad_a_traspasar * 100, 2)}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q200.00') {{number_format($co->cantidad_a_traspasar * 200, 2)}} @endif
                        @if ($co->descripcion=='Timbres de precio de Q500.00') {{number_format($co->cantidad_a_traspasar * 500, 2)}} @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tr>
                <th colspan="5" style="background: #D2D2D2;text-align:center;" height="17">TOTAL </th>
                <th style="color: black;text-align:center;" class="derecha">Q.{{number_format($total, 2)}}</th>
            </tr>
        </table>
    </div>
    <br>
    <span class="elements"><div></div></span>
    <br><br><br><br>
    <div style="margin-left: 18rem;">
        <label width="100%"><input type="text" style="border: 0px solid;" name="fechaHoy" id="fechaHoy" value="{{$newDate}}"></label>
    </div>
    <br><br><br><br><br>
    <div style="margin-left: 2rem;">
        <table style="border: hidden">
            <tr>
                <td style="border: hidden">
                    <label>ENTREGA</label>
                    <input type="text" size="28" name="personaEntrega" id="personaEntrega" value="YIRLY PAREDES">
                    <div style="margin-left: 8rem;">
                        <label style="margin-left: 6rem;"><small>AUXILIAR DE CONTABILIDAD</small></label>
                        <label style="margin-left: 5rem;"> </label>
                    </div>
                </td>
                <td style="border: hidden">
                    <label>RECIBE</label>
                    <input type="text" size="28" name="personaRecibe" id="personaRecibe" value="{{$nombreUsuarioDestino}}">
                    <div style="margin-left: 2rem;">
                        <label style="margin-left: 4rem;">Expendedor/a de <input type="text" style="border: 0px solid;text-align:left;" id="nombreLugar" value="{{$ciudadDestino->descripcion}}"></label>
                        <label style="margin-left: 7rem;">Bodega: <input type="text" style="border: 0px solid;text-align:left;" name="noBodega" id="noBodega" value="{{$id->bodega_destino_id}}"></label>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <br><br><br><br>
    <div>
        <div style="margin-left: 11rem;">
            <label >_________________________________________________</label>
        </div>
        <div style="margin-left: 2rem;">
            <label>  Vo. Bo.</label>
            <label style="margin-left: 13rem;">INGA. MONICA PINTO</label>
        </div>
        <div style="margin-left: 1rem;">
            <label>c.c.</label>
            <label>Archivo</label>
            <label style="margin-left: 7rem;">ADMINISTRADOR TIMBRE DE INGENIERIA</label>
        </div>
    </div>

</body>
</html>

<p></p>

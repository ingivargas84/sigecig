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
            border: 0.4px solid;
        }
        table {
            width: 98%;
            font-size: 13px;
        }
        table, tbody, tr, td{
            border: 1px solid ;
            border-collapse: collapse;
        }
        th {
            border: 6px double black;
        }
        .derecha {
            border-right: 6px double black;
        }
        .izquierda {
            border-left: 6px double black;
        }
        .abajo {
            border-bottom: 6px double black;
        }
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
        <input type="text" size="5" name="NoRemesa" id="NoRemesa">
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
            <input type="text" size="36" name="NoRemesa" id="NoRemesa">,
            <label> quien se identifica con CUI No. </label>
            <input type="text" size="19" name="NoRemesa" id="NoRemesa">
        </div>
        <div style="margin-left: 8rem;">
            <label><small>Nombre y Apellidos</small></label>
        </div>
        <br>
        <div>
            <label>extendida en, </label>
            <input type="text" size="16" name="departamento" id="departamento">
            <input type="text" size="16" name="municipio" id="municipio">
            <label>ubicado en la Regional de</label>
            <input type="text" size="14" name="nombreLugar" id="nombreLugar">
        </div>
        <div style="margin-left: 9rem;">
            <label><small>Ciudad</small> <small style="margin-left: 8rem;">Municipio</small><small style="margin-left: 15rem;">Nombre del Lugar</small></label>
        </div>
        <br>
        <div>
            <input type="text" size="46" name="direccion" id="direccion">
            <input type="text" size="13" name="telefono" id="telefono">
            <input type="text" size="13" name="fax" id="fax">
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
                    <th>DENOMINACION DE LA ESPECIE</th>
                    <th colspan="2">NUMERACION DE LA SERIE DE TIMBRES</th>
                    <th>CANTIDAD UNIDADES</th>
                    <th>CANTIDAD TOTAL</th>
                    <th>VALOR EN QUETZALES</th>
                </tr>
            </thead>
            <br>
            <br>
            <tbody>
                <tr>
                    <td class="derecha izquierda" height="17"><b>1,00</b></td>
                    <td><input type="number" name="iniciaTc01" id="iniciaTc01"></td>
                    <td class="derecha"><input type="number" name="finTc01" id="finTc01"></td>
                    <td class="derecha"><input type="number" name="unidadesTc01" id="unidadesTc01"></td>
                    <td class="derecha"><input type="number" name="totalTc01" id="totalTc01"></td>
                    <td class="derecha">Q.<input type="number" name="precioTc01" id="precioTc01">.00</td>
                </tr>
            </tbody>
            <tr>
                <th colspan="5" style="background: #D2D2D2;text-align:center;" height="17">TOTAL </th>
                <th style="color: black;text-align:center;">Q.</th>
            </tr>
        </table>
    </div>
    <br>
    <span class="elements"><div></div></span>
    <br><br><br><br><br>
    <div style="margin-left: 8rem;">
        <label width="100%"><input type="text" style="border: 0px solid;" name="fechaHoy" id="fechaHoy">Octubre 5, 2020</label>
    </div>
    <br><br><br><br><br><br><br>
    <div style="margin-left: 2rem;">
        <table style="border: hidden">
            <tr>
                <td style="border: hidden">
                    <label>ENTREGA</label>
                    <input type="text" size="28" name="personaEntrega" id="personaEntrega">
                    <div style="margin-left: 8rem;">
                        <label style="margin-left: 6rem;"><small>AUXILIAR DE CONTABILIDAD</small></label>
                        <label style="margin-left: 5rem;"> </label>
                    </div>
                </td>
                <td style="border: hidden">
                    <label>RECIBE</label>
                    <input type="text" size="28" name="personaRecibe" id="personaRecibe">
                    <div style="margin-left: 2rem;">
                        <label style="margin-left: 4rem;">Expendedor/a de <input type="text" style="border: 0px solid;" id="nombreLugar"></label>
                        <label style="margin-left: 7rem;">Bodega: <input type="text" style="border: 0px solid;" name="noBodega" id="noBodega"></label>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <br><br><br><br><br>
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

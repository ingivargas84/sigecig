<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=w, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Colegiados por Rango</title>
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
        td{font-size: 13px;}
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
         <h1 style=" color: #03306d; ">Reporte de Colegiados por Rango </h1>
    </div>
    <hr style="height: 1px; background:#67a8ff">
    <br>
    <div class="" style="font-family: sans-serif;">
        <label class="">Rango del colegiado:</label>
        <b> {{$dato}}</b> al <b>{{$dato1}}</b>
    </div>
    <br>
        <table style="margin-top: 1rem; ">
            <thead >
                <tr>
                    <th style="background: #D2D2D2;text-align:center; padding: 4px;">Colegiado</th>
                    <th style="background: #D2D2D2;text-align:center;">Nombres</th>
                    <th style="background: #D2D2D2;text-align:center;">Carrera</th>
                    <th style="background: #D2D2D2;text-align:center;">Mun. Casa</th>
                    <th style="background: #D2D2D2;text-align:center;">Dep. Casa</th>
                    <th style="background: #D2D2D2;text-align:center;">Mun. Trab.</th>
                    <th style="background: #D2D2D2;text-align:center;">Dep. Trab.</th>
                    <th style="background: #D2D2D2;text-align:center;">Teléfono</th>
                    <th style="background: #D2D2D2;text-align:center;">E-mail</th>  
                    <th style="background: #D2D2D2;text-align:center;">Fecha Colegiación</th>               
                </tr>
            </thead>
            @foreach($datos as $da)
            <tr >
                <td style="background:eee;">{{$da->cliente}}</td>
                <td style="background:eee;text-align:left;">{{$da->n_cliente}}</td>
                <td style="background:eee;text-align:left;">{{$da->carrera}}</td>
                <td style="background:eee;text-align:left;">{{$da->municasa}}</td>
                <td style="background:eee;text-align:left;">{{$da->depcasa}}</td>
                <td style="background:eee;text-align:left;">{{$da->munitrab}}</td>
                <td style="background:eee;text-align:left;">{{$da->n_depto}}</td>
                <td style="background:eee;text-align:left;">{{$da->telefono}}</td>
                <td style="background:eee;text-align:left;">{{$da->e_mail}}</td>
                <td style="background:eee;text-align:left;">{{ \Carbon\Carbon::parse($da->fecha_col)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </table>
        <br>
        <div >
          <label><b>REPORTE CREADO POR:</b> {{$user->name}} </label>
          <br>
          <label><b>FECHA Y HORA:</b> <?php echo date("d/m/Y H:i:s");?> </label>
        </div>
</body>
</html>

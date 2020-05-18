<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Archivo Imprimible</title>
    <link rel="stylesheet" href="css/cartapdf.css" />
</head>

@section('content')
<script>
    var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    var f=new Date();
    document.write("Guatemala, " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear());
</script>
@endsection

<body>
    <div class="principal">
        <div class="fecha">
            <p> Ref. AP 013-2019/2021
        </div>
        <div class="datos">
            <p> Ingeniero Civil<br>
                Miguel José Licona Jiménez<br>
                Colegiado NO. 734<br>
                Presente<br>
        </div>
    </div>
         <div class="texto1">
            <p>  Con relación a la solicitud por el Seguro de Vida del colegiado, por instrucciones de la Junta de Administración del Auxilio Póstumo; a continuación se transcribe el punto 6.2 de Acta 011-2019/2021, de fecha diez de febrero del dos mil veinte: 
            “6.2	Conocer el informe administrativo del Ingeniero Civil, MIGUEL JOSÉ LICONA JIMENEZ, colegiado 734; quien solicita anticipo del seguro de vida por un monto de Q. 10,000.00; por lo que  la Junta de Administración ACUERDA:

            <p> Con base al informe administrativo y a la revisión de la documentación presentada, para la solicitud de subsidio del Auxilio Póstumo, proceder con los trámites correspondientes para el pago de anticipo del Seguro de Vida del Ingeniero de conformidad con el artículo 16 numeral 2) del Reglamento del Auxilio Póstumo.
        </div>
        <br>
        <table>
            <thead>
                <tr>
                    <th>BENEFICIARIO</th>
                    <th>MONTO A PAGAR</th>
                </tr>
            </thead>
                <tr>
                    <td>lkkl</td>
                    <td>33</td>
                </tr>
        </table>
        <br>
        <br>
        <br>
        <div class="datos">
            <p> Atentamente,
        </div>
        <br>
        <br>
        <br>
        <div class="datos1">
            <p>Ing. Mónica Pinto Martínez<br>
            ADMINISTRADORA<br>
            Timbre de Ingeniería y Auxilio Póstumo<br>
            Colegio de Ingenieros de Guatemala<br>
        </div>
        <p><small>LFHA/aesr<br>
            C.C. Expediente
        </small></p>
    </div>
</body>
</html>
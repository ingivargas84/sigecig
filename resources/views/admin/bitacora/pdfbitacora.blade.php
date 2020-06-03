<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Historial de Transacción</title>
</head>
<body>
            <h3><center> Bitácora Solicitud <b>#{{$id->no_solicitud}}</b> </center></h3>
            <p> Colegiado: <b>{{$id->n_colegiado}}</b> <br>
                Nombres: <b>{{$adm_persona->Nombre1}}</b> <br>
                Fecha de Nacimiento: <b>{{$fecha_Nac->fecha_nac}}</b> <br>
                Profesión: <b>{{$profesion->n_profesion}}</b> <br>     
                Teléfono: <b>{{$tel->telefono}}</b>  <br>
                DPI: <b>{{$reg->registro}}</b>     
                
            <div class="texto1">
                <h4> 1. Ingreso de Información  </h4>
                <p> Fecha de Configuración  Configurado por: {{$adm_persona->Nombre1}}
            </div>
            <div class="texto1">
                <h4> 2. Adjuntar Documentación  </h4>
                <p> Fecha de Configuración  Configurado por: {{$adm_persona->Nombre1}}
            </div>   
            <div class="texto1">
                <h4> 3. Autorización de Documentos  </h4>
                <p> Fecha de Configuración  Configurado por:
            </div>   
            <div class="texto1">
                <h4> 4. Solicitud de Aprobación a Junta Directiva  </h4>
                <p> Fecha de Configuración  Configurado por:
            </div>   
            <div class="texto1">
                <h4> 5. Aprobación de Junta Directiva  </h4>
                <p> Fecha de Configuración  Configurado por:
            </div>   
            <div class="texto1">
                <h4> 6. Firma de Resolución </h4>
                <p> Fecha de Configuración  Configurado por:
            </div>      
            <div class="texto1">
                <h4> 7. Gestión de depósito - Configuración de Pago </h4>
                <p> Fecha de Configuración  Configurado por:
                <p> Banco: <b>{{$banco->nombre_banco}} </b> 
                    Tipo de cuenta: <b>{{$tipocuenta->tipo_cuenta}} </b> 
                    No. de cuenta: <b>{{$id->no_cuenta}} </b> 
            </div>    
            <div class="texto1">
                <h4> 8. Pago al Agremiado </h4>
                <p> Fecha de Configuración  Configurado por:
            </div>    
</body>
</html>
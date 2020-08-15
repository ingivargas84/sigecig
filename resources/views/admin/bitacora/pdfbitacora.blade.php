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
                Fecha de Nacimiento: <b>{{date('d/m/Y', strtotime($fecha_Nac->fecha_nac))}}</b> <br>
                Profesión: <b>{{$profesion->n_profesion}}</b> <br>     
                Teléfono: <b>{{$tel->telefono}}</b>  <br>
                DPI: <b>{{$reg->registro}}</b>     

                @foreach($usuario_cambio as $cambio)
                @if($cambio ["estado_solicitud"] == 1)   
            <div class="texto1">
                <h4> 1. Ingreso de Información  </h4>
                <p> Fecha de Configuración <b> {{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}</b> 
                    Configurado por: 
                    @if ($cambio->id_creacion == 1)
                    <b>{{$adm_persona->Nombre1}}</b>
                    @else
                    <b>{{\App\User::find($cambio->usuario)->name}}</b>
                    @endif
                </div>
                @endif 
            
            @if($cambio ["estado_solicitud"] == 2)
            <div class="texto1">
                <h4> 2. Adjuntar Documentación  </h4>
                <p> Fecha de Configuración <b> {{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}</b> 
                    Configurado por: 
                    @if ($cambio->id_creacion == 1)
                    <b>{{$adm_persona->Nombre1}}</b>
                    @else
                    <b>{{\App\User::find($cambio->usuario)->name}}</b>
                    @endif
                </div>   
                @endif 

                @if($cambio ["estado_solicitud"] == 3)
                <div class="texto1">
                    <h4> 3. Documentación Rechazada </h4>
                    <p> Fecha de Configuración <b> {{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}</b> Configurado por: <b>{{\App\User::find($cambio->usuario)->name}}</b>
                </div>     
                        <div class="row">
                            <div class="form-group col-md-12" >
                                <label><b>Motivo del rechazo:</b></label>
                                <p>{{$id->solicitud_rechazo_ap}}
                            </div>

                        </div>
                @endif
                
                @if($cambio ["estado_solicitud"] == 4)
                <div class="texto1">
                    <h4> 4. Autorización de Documentos </h4>
                    <p> Fecha de Configuración <b> {{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}</b> Configurado por: <b>{{\App\User::find($cambio->usuario)->name}}</b>
                </div>   
                @endif 
              

                @if($cambio ["estado_solicitud"] == 5)
            <div class="texto1">
                <h4> 5. Aprobación de Junta Auxilio Póstumo  </h4>
                <p> Fecha de Configuración: <b> {{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}</b>  Configurado por: <b>{{\App\User::find($cambio->usuario)->name}}</b>
               </div>   
                @endif 

                @if($cambio ["estado_solicitud"] == 6)
                <div class="texto1">
                    <h4> 6. Rechazado por Junta </h4>
                    <p> Fecha de Configuración <b> {{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}</b> Configurado por: <b>{{\App\User::find($cambio->usuario)->name}}</b>
                </div>     
                        <div class="row">
                            <div class="form-group col-md-12" >
                                <label><b>Motivo del rechazo:</b></label>
                                <p>{{$id->solicitud_rechazo_junta}}
                            </div>

                        </div>
                @endif
                @if($cambio ["estado_solicitud"] == 7)
                <div class="texto1">
                 <h4> 7. Ingreso de Acta </h4>
                    <p> Fecha de Configuración:<b> {{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}} </b>  Configurado por: <b>{{\App\User::find($cambio->usuario)->name}}</b>
                    </div>      
                 @endif 

            @if($cambio ["estado_solicitud"] == 8)
            <div class="texto1">
                <h4> 8. Firma de Resolución </h4>
                <p> Fecha de Configuración:<b> {{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}} </b>  Configurado por: <b>{{\App\User::find($cambio->usuario)->name}}</b>
                </div>      
             @endif 

            @if($cambio ["estado_solicitud"] == 9)
            <div class="texto1">
                <h4> 9. Gestión de depósito - Configuración de Pago </h4>
                <p> Fecha de Configuración: <b>{{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}</b>  Configurado por: <b>{{\App\User::find($cambio->usuario)->name}}</b>
                <p> Banco: <b>{{$banco->nombre_banco}} </b> 
                    Tipo de cuenta: <b>{{$tipocuenta->tipo_cuenta}} </b> 
                    No. de cuenta: <b>{{$id->no_cuenta}} </b> 
                </div>    
                @endif 

            @if($cambio ["estado_solicitud"] == 10)
            <div class="texto1">
                <h4> 10. Pago al Agremiado </h4>
                <p> Fecha de Configuración: <b> {{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}</b> Configurado por: <b>{{\App\User::find($cambio->usuario)->name}}</b>
                </div>    
                @endif 
                @endforeach
</body>
</html>
@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1><center>
    Solicitudes Completadas de Subsidio de Auxilio Póstumo
    </center>
    </h1>
     <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('resolucion.index')}}"><i class="fa fa-list"></i> Resolución</a></li>
          <li class="active">Detalle</li>
        </ol>
  </section>
  @stop
  
  @section('content')
  <form method="POST" id="BitacoraForm">
          {{csrf_field()}}
          <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-body">
                  <div class="row">
                        <div class="form-group col-md-2" >
                            <label>Colegiado</label>
                            <input type="number" class="form-control"  value="{{$id->n_colegiado}}" readonly>
                        </div>
                        <div class="form-group col-md-6" >
                            <label>Nombres</label>
                                <input type="text" class="form-control" value="{{$adm_persona->Nombre1}}" readonly>
                                
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Fecha de nacimiento</label>
                                <input type="text" class="form-control" value="{{date('d-m-Y', strtotime($fecha_Nac->fecha_nac))}}" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="form-group col-md-6" >
                                <label>Profesión</label>
                                <input type="text" class="form-control" value="{{$profesion->n_profesion}}" readonly>
                            </div>
                            <div class="form-group col-md-2" >
                                <label for="Nombre1">Teléfono</label>
                                <input type="text" class="form-control" value="{{$tel->telefono}}" readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>DPI</label>
                                <input type="text" class="form-control" value="{{$reg->registro}}" readonly>
                            </div>
                        </div>
                        @foreach($usuario_cambio as $cambio)
                        @if($cambio ["estado_solicitud"] == 1)
                        <p><b>1. Ingreso de Información</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{$cambio->fecha}}' readonly>  
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value="{{$adm_persona->Nombre1}}" readonly>
                             
                            </div>
                        </div>
                        @endif  
                        @if($cambio ["estado_solicitud"] == 2)
                        <p><b>2. Adjuntar Documentación</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{$cambio->fecha}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value="{{$adm_persona->Nombre1}}" readonly>
                            </div>
                        </div>
                        @endif

                        @if($cambio ["estado_solicitud"] == 3)
                        <p><b>3. Documentación Rechazada</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{$cambio->fecha}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value="{{$adm_persona->Nombre1}}" readonly>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="form-group col-md-12" >
                                <label>Motivo del rechazo:</label>
                                <input type="text" class="form-control" value="{{$id->solicitud_rechazo_junta}}" readonly>
                            </div>

                        </div>
                        @endif

                        @if($cambio ["estado_solicitud"] == 4)
                        <p><b>3. Autorización de Documentos</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{$cambio->fecha}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value='{{\App\User::find($cambio->usuario)->name}}' readonly>
                            </div>
                        </div>
                        @endif
                      
                        @if($cambio ["estado_solicitud"] == 4)
                       <p><b>4. Solicitud de Aprobación a Junta Directiva</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{$cambio->fecha}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value='{{\App\User::find($cambio->usuario)->name}}' readonly>
                            </div>
                        </div>
                        @endif

                        @if($cambio ["estado_solicitud"] == 5)
                        <p><b>5. Aprobación de Junta Auxilio Póstumo</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{$cambio->fecha}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value='{{\App\User::find($cambio->usuario)->name}}' readonly>
                            </div>
                        </div>
                        @endif

                        @if($cambio ["estado_solicitud"] == 8)
                        <p><b>6. Firma de Resolución</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{$cambio->fecha}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value='{{\App\User::find($cambio->usuario)->name}}' readonly>
                            </div>
                        </div>
                        @endif

                        @if($cambio ["estado_solicitud"] == 9)
                        <p><b>7. Gestión de depósito - Configuración de Pago</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{$cambio->fecha}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value='{{\App\User::find($cambio->usuario)->name}}' readonly>
                            </div>
                        <br>
                            <div class="form-group col-sm-5" >
                                <label for="nombre_banco">Banco</label>
                                    <input type="text" class="form-control" value="{{$banco->nombre_banco}}" readonly>
                                </div>
                            <div class="form-group col-sm-2" >
                                <label for="tipo_cuenta">Tipo de Cuenta</label>
                                <input type="text" class="form-control" value="{{$tipocuenta->tipo_cuenta}}" readonly>
                                </div>
                            <div class="form-group col-sm-5" >
                                <label for="no_cuenta" >No. de cuenta</label>
                                <input type="text" class="form-control" value="{{$id->no_cuenta}}" readonly>
                                </div>
                        </div>
                        @endif

                        @if($cambio ["estado_solicitud"] == 10)
                        <p><b>8. Pago al Agremiado</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{$cambio->fecha}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value='{{\App\User::find($cambio->usuario)->name}}' readonly>
                            </div>
                        </div>
                        @endif 
                        @endforeach
                        
                            <br>
                            
                            <div class="text-center m-t-15">
                                <a class='btn btn-primary form-button' href="{{ route('bitacora.pdfbitacora', $id) }}">Generar PDF</a>
                            </div>
                    </div> 
                </div>
            </div>             
  </form>
  <div class="loader loader-bar"></div>

@endsection

@push('styles')

@endpush

@push('scripts')
 <script src="{{asset('js/resolucion/index.js')}}"></script>
@endpush

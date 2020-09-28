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
                                <input type="text" class="form-control" value="{{date('d/m/Y', strtotime($fecha_Nac->fecha_nac))}}" readonly>
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
                                <input type="text" class="form-control" value='{{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}' readonly>  
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                @if ($cambio->id_creacion==0)
                                <input type="text" class="form-control" value="{{\App\User::find($cambio->usuario)->name}}" readonly>
                                @endif
                                @if ($cambio->id_creacion==1)
                                <input type="text" class="form-control" value="{{$adm_persona->Nombre1}}" readonly>
                                @endif
                                
                             
                            </div>
                        </div>
                        @endif  
                        @if($cambio ["estado_solicitud"] == 2)
                        <p><b>2. Adjuntar Documentación</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                @if ($cambio->id_creacion==0)
                                <input type="text" class="form-control" value="{{\App\User::find($cambio->usuario)->name}}" readonly>
                                @endif
                                @if ($cambio->id_creacion==1)
                                <input type="text" class="form-control" value="{{$adm_persona->Nombre1}}" readonly>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($cambio ["estado_solicitud"] == 3)
                        <p><b>3. Documentación Rechazada</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value="{{\App\User::find($cambio->usuario)->name}}" readonly>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="form-group col-md-12" >
                                <label>Motivo del rechazo:</label>
                                <input type="text" class="form-control" value="{{$id->solicitud_rechazo_ap}}" readonly>
                            </div>

                        </div>
                        @endif

                        @if($cambio ["estado_solicitud"] == 4)
                        <p><b>4. Autorización de Documentos</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}' readonly>
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
                                <input type="text" class="form-control" value='{{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value='{{\App\User::find($cambio->usuario)->name}}' readonly>
                            </div>
                        </div>
                        @endif

                        @if($cambio ["estado_solicitud"] == 6)
                        <p><b>6. Rechazado por Junta</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value="{{\App\User::find($cambio->usuario)->name}}" readonly>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="form-group col-md-12" >
                                <label>Motivo del rechazo:</label>
                                <input type="text" class="form-control" value="{{$id->solicitud_rechazo_junta}}" readonly>
                            </div>

                        </div>
                        @endif
                        @if($cambio ["estado_solicitud"] == 7)
                        <p><b>7. Ingreso de Acta</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value="{{\App\User::find($cambio->usuario)->name}}" readonly>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>No. de Acta</label>
                                <input type="text" class="form-control" value='{{$id->no_acta}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Punto de Acta:</label>
                                <input type="text" class="form-control" value="{{$id->no_punto_acta}}" readonly>
                            </div>
                        </div>  
        
                        @endif

                        @if($cambio ["estado_solicitud"] == 8)
                        <p><b>8. Firma de Resolución</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value='{{\App\User::find($cambio->usuario)->name}}' readonly>
                            </div>
                        </div>
                        @if ($user->roles[0]->name=='Administrador' || $user->roles[0]->name=='Super-Administrador' || $user->roles[0]->name=='Timbre' || $user->roles[0]->name=='JefeTimbres')
                        <div class="row">
                            <div class="col-sm-4">
                                <label  style="padding: 10px;  ">Adjuntar Resolución</label>
                                <a type="button" class="btn btn-primary" href="{{ route('ap.adjuntar-resolucion',$id->id)}}" id="" value="Adjuntar" style=" float: right" >Adjuntar</a>
                            </div>
                            <div class="col-sm-4">
                            </div>
                        </div>
                        @endif

                       <br>
                        @endif

                        @if($cambio ["estado_solicitud"] == 9)
                        <p><b>9. Gestión de depósito - Configuración de Pago</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{ \Carbon\Carbon::parse($cambio->fecha)->format('d/m/Y H:i:s')}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value='{{\App\User::find($cambio->usuario)->name}}' readonly>
                            </div>
                            <div class="form-group col-sm-4" >
                                <label for="nombre_banco">Banco</label>
                                    <input type="text" class="form-control" value="{{$banco->nombre_banco}}" readonly>
                                </div>
                        </div>

                        <br>
                           
                        <div class="row">
      
                            <div class="form-group col-sm-4" >
                                <label for="tipo_cuenta">Tipo de Cuenta</label>
                                <input type="text" class="form-control" value="{{$tipocuenta->tipo_cuenta}}" readonly>
                                </div>
                            <div class="form-group col-sm-4" >
                                <label for="no_cuenta" >No. de cuenta</label>
                                <input type="text" class="form-control" value="{{$id->no_cuenta}}" readonly>
                                </div>
                                <div class="form-group col-sm-4" >
                                <label for="no_cuenta" >Fecha de Pago:</label>
                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse($id->fecha_pago_ap)->format('d/m/Y ')}}" readonly>
                                </div>
                        </div>
                        @endif

                        @if($cambio ["estado_solicitud"] == 10)
                        <p><b>10. Pago al Agremiado</b>
                            <br>
                        <div class="row">
                            <div class="form-group col-md-4" >
                                <label>Fecha de Configuración</label>
                                <input type="text" class="form-control" value='{{ \Carbon\Carbon::parse($cambio->created_at)->format('d/m/Y H:i:s')}}' readonly>
                            </div>
                            <div class="form-group col-md-4" >
                                <label>Configurado por:</label>
                                <input type="text" class="form-control" value='{{\App\User::find($cambio->usuario)->name}}' readonly>
                            </div>
                        </div>
                        @endif 
                        @endforeach
                        
                            <br>
                            <div class="col-sm-12 ">
                                @if ($id->id_estado_solicitud>=2 && $id->pdf_solicitud_ap != null && $id->pdf_dpi_ap != null)
                                <div class="col-sm-6">
                                    <h4  style="padding: 10px">Solicitud de anticipo firmada <a  href="" id="pdfSolicitud" ><img  src="/images/iconover.png" id="" style="width: 30px; height: 30px; background: #67a8ff;border-radius: 1px;    float: right;"></a></h4>
                                    <div class="" id="solicitudpdf" style="display: none  ">
                                        @if ($extSolicitud == 'pdf' || $extSolicitud == 'PDF')
                                        <iframe id="iframeSolicitud" src="{{$id->pdf_solicitud_ap}}" frameborder="0"  width="100%" height="400px" ></iframe>
                                        @else
                                        <a target="_blank" href="{{route('img.vie', $id->id)}}" ><img src="{{$id->pdf_solicitud_ap}}" alt="" style="max-width: 100%"></a>                                
                                        @endif
                                   </div>
                                </div>
                            
                                <div class="col-sm-6">
                                    <h4  style="padding: 10px">Copiade DPI ambos lados<a  href="" id="pdfDpi" ><img  src="/images/iconover.png" id="" style="width: 30px; height: 30px; background: #67a8ff;border-radius: 1px;float: right;"></a></h4>
                                    <div class="" id="dpipdf"  style="display: none">
                                        @if ($extDpi == 'pdf' || $extDpi == 'PDF')
                                        <iframe name="iframeDpi" src="{{$id->pdf_dpi_ap}}" frameborder="0"  width="100%" height="400px"  style="max-width: 100%" ></iframe>
                                        @else
                                        <a target="_blank" href="{{route('img.viedpi', $id->id)}}" ><img src="{{$id->pdf_dpi_ap}}" alt="" style="max-width: 100%"></a>                                                                        
                                        @endif
                                    </div>
                                </div>
  
                                @endif
                                @if ($id->id_estado_solicitud >=7 && $id->pdf_resolucion_ap != null)
                                <div class="col-sm-6">
                                    <h4  style="padding: 10px">Resolución firmada<a target="_blank" href="" id="pdfResolucion" ><img  src="/images/iconover.png" id="" style="width: 20px; height: 20px; background: #67a8ff;border-radius: 1px;float: right;"></i></a></h4>
                                    <div class="" id="resolucionpdf"  style="display: none ">
                                        <embed  src="{{$id->pdf_resolucion_ap}}" type="application/pdf" width="100%" height="400px" />
                                    </div>
                                </div><br><br><br><br>
    
                                @endif
                            </div><br>

 
                            
                            <div class="text-center m-t-15">
                                <a target="_blank" class='btn btn-primary form-button' href="{{ route('bitacora.pdfbitacora', $id) }}">Generar PDF</a>
                            </div>
                    </div> 
                </div>
            </div>             
  </form>

  <div class="loader loader-bar"></div>  

@endsection

@push('styles')
<style>
    
</style>
@endpush

@push('scripts')
 <script src="{{asset('js/resolucion/index.js')}}"></script>
 <script src="{{asset('js/resolucion/bitacora.js')}}"></script>

@endpush

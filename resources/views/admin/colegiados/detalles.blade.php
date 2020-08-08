@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
      <h1>
          Colegiados
          <small>Detalles</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('colegiados.index')}}"><i class="fa fa-list"></i> Colegiados</a></li>
          <li class="active">Detalles</li>
        </ol>
    </section>
@endsection
@section('meta')


@push('scripts')
{{--<script src="{{asset('/ea/jquery-ui.min.js')}}"></script>
<script src="{{asset('/ea/jquery.mask.min.js')}}"></script>
 <script src="{{asset('ea/jquery.auto-complete.js')}}"></script>
<script src="{{asset('/ea/jquery.auto-complete.min.js')}}"></script> 
<script src="{{asset('/ea/bootstrap.min.js')}}"></script>
<script src="{{asset('/ea/jquery.mask.min.js')}}"></script>--}}

@endpush 
  
@section('content')
<form method="POST" id="colegiadosForm" >
  {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <legend>Información Personal</legend>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="dpi">DPI:</label>
                              <input name="dpi"  onchange="cargarDatos()" autofocus="" value="{{$query->dpi}}" class="form-control" type="text" readonly>                            
                            </div>
                            <div class="col-sm-4">
                              <label for="nombre">Nombres:</label>
                              <input id="nombres"  value="{{$query->nombre}}" class="form-control" placeholder="Nombres" name="nombres" type="text" readonly>                            
                            </div>
                            <div class="col-sm-4">
                              <label for="apellidos" class="control-label">Apellidos</label>
                              <input id="apellidos"  value="{{$query->apellidos}}" class="form-control" placeholder="Apellidos" name="apellidos" type="text" readonly>                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                             <div class='col-sm-2'>
                              <label for="sexo">Sexo:</label>
                              <input class="form-control"  value="{{$sx->n_sexo}}" id="sexo" name="sexo" type="text" readonly>                                                  
                              </div>
                              <div class="col-sm-2">
                                <label for="fechaNacimiento" class="control-label">Fecha Nac.</label>
                                <input id="fechaNacimiento" value="{{$query->fechaNacimiento}}" class="form-control" name="fechaNacimiento" type="date" readonly>                            
                              </div>
                              <div class='col-sm-4'>
                                <label for="valMunicipioNacimiento" class="control-label">Municipio Nac.</label>
                                @if ($muninac->n_mpo==true)
                                <input id="valMunicipioNacimiento" value="{{$muninac->n_mpo}}" list="countries" class="form-control" placeholder="Municipio" name="valMunicipioNacimiento" type="text" autocomplete="off" readonly>
                                @else
                                <input id="valMunicipioNacimiento" value="No ingresado" list="countries" class="form-control" name="valMunicipioNacimiento" type="text" readonly>
                                @endif
                              </div>
                              <div class='col-sm-4'>
                                <label for="valDepartamentoNacimiento" class="control-label">Depto. Nac.</label>
                                <input id="valDepartamentoNacimiento" value="{{$depnac->n_depto}}" class="form-control" placeholder="Departamento" name="valDepartamentoNacimiento" type="text" autocomplete="on" readonly>
                              </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class='col-sm-4'>
                              <label for="valPais" class="control-label">País</label>
                              @if($paisnac ["c_pais"] != null)
                              <input id="valPais" value="No encontrado" class="form-control ui-autocomplete-input" placeholder="País" name="valPais" type="text" autocomplete="on" readonly>
                              @else
                              <input id="valPais" value="{{$paisnac->n_pais}}" class="form-control ui-autocomplete-input" placeholder="País" name="valPais" type="text" autocomplete="on" readonly>
                              @endif

                            </div>
                            <div class="col-sm-4">
                              <label for="valNacionalidad" class="control-label">Nacionalidad</label>
                              @if($nacionalidad ["c_nacionalidad"] == null)
                              <input id="valNacionalidad" value="No ingresada" class="form-control ui-autocomplete-input" name="valNacionalidad" type="text" autocomplete="off"readonly>
                              @else
                              <input id="valNacionalidad" value="{{$nacionalidad->n_nacionalidad}}" class="form-control ui-autocomplete-input" name="valNacionalidad" type="text" autocomplete="off"readonly>
                             @endif
                            </div>
                            <div class="col-sm-4">
                              <label for="telefono" class="control-label">Teléfono</label>
                              <input id="telefono" value="{{$query->telefono}}" class="form-control" placeholder="Teléfono" name="telefono" type="text" readonly>                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="email" class="control-label">Correo electrónico</label>
                              <input id="email" value="{{$query->correo}}" class="form-control" placeholder="Correo electrónico" name="email" type="text" readonly>                            
                            </div>
                            <div class="col-sm-4">
                              <label for="estadoCivil" class="control-label">Estado civil</label>
                              <input id="estadoCivil" value="{{$ecivil->n_civil}}" class="form-control" placeholder="Estado civil" name="estadoCivil" type="text" readonly>                                  
                            </div>
                            <div class="col-sm-4">
                              <label for="direccion" class="control-label">Dirección</label>
                              <input id="direccion" value="{{$query->direccionCasa}}" class="form-control" placeholder="Dirección" name="direccion" type="text" readonly>                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="zona" class="control-label">Zona</label>
                              <input id="zona" value="{{$query->zona}}" class="form-control" placeholder="Zona" name="zona" type="tel" readonly>                            
                            </div>
                            <div class="col-sm-4">
                              <label for="valMunicipio" class="control-label">Municipio Casa</label>
                              <input id="valMunicipio" value="{{$municasa->n_mpo}}" list="countries" class="form-control ui-autocomplete-input" placeholder="Municipio" name="valMunicipio" type="text" autocomplete="off" readonly>
                            </div>
                            <div class="col-sm-4">
                              <label for="destino" class="control-label">Destino correo</label>
                              <input id="destino" value="{{$query->destinoCorreo}}" class="form-control ui-autocomplete-input" placeholder="Municipio" name="valMunicipio" type="text" autocomplete="off" readonly>
                            </div>
                        </div>
                        <br>
                        <legend>Trabajo</legend>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="direccionTrabajo" class="control-label">Dirección Trabajo</label>
                              <input id="direccionTrabajo" value="{{$query->direccionTrabajo}}" class="form-control" placeholder="Dirección" name="direccionTrabajo" type="text" readonly>                            
                            </div>
                            <div class="col-sm-4">
                              <label for="zonaTrabajo" class="control-label">Zona</label>
                              <input id="zonaTrabajo" value="{{$query->zonatrabajo}}" class="form-control" placeholder="Zona" name="zonaTrabajo" type="tel" readonly>                            
                            </div>
                            <div class="col-sm-4">
                              <label for="telTrabajo" class="control-label">Tel. Trabajo</label>
                              <input id="telTrabajo" value="{{$query->telefonoTrabajo}}" class="form-control" placeholder="Teléfono" name="telTrabajo" type="tel" readonly>                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="valMunicipioTrabajo" class="control-label">Municipio Trabajo</label>
                              <input id="valMunicipioTrabajo" value="{{$munitrab->n_mpo}}" class="form-control ui-autocomplete-input" placeholder="Municipio" name="valMunicipioTrabajo" type="text" autocomplete="off" readonly>
                            </div>
                            <div class="col-sm-4">
                              <label for="valDepartamentoTrabajo" class="control-label">Depto. Trab.</label>
                              <input id="valDepartamentoTrabajo" value="{{$deptrab->n_depto}}" class="form-control ui-autocomplete-input" placeholder="Departamento" name="valDepartamentoTrabajo" type="text" autocomplete="off" readonly>
                            </div>
                        </div>
                        <br>
                        <legend>Datos Académicos</legend>
                        <div class="row">
                            <div class="col-sm-2">
                              <label for="fechaGraduacion" class="control-label">Fecha Graduación</label>
                              <input id="fechaGraduacion" value="{{$query->fechaGraduacion}}" class="form-control" name="fechaGraduacion" type="date" readonly>
                            </div>
                            <div class="col-sm-5">
                              <label for="valUniversidadGraduado" class="control-label">Universidad Graduado</label>
                              <input id="valUniversidadGraduado" value="{{$uni->n_universidad}}" class="form-control ui-autocomplete-input" placeholder="Universidad" name="valUniversidadGraduado" type="text" autocomplete="off" readonly>
                            </div>
                            <div class="col-sm-5">
                              <label> Carrera afin </label>   
                              <input id="ca" name="interests[]" type="checkbox" value="ca" readonly>     
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                              <label for="valUniversidadIncorporado" class="control-label">Universidad incorporado</label>
                              <input id="valUniversidadIncorporado" value="{{$uniinc->n_universidad}}" class="form-control ui-autocomplete-input" placeholder="Universidad" name="valUniversidadIncorporado" type="text" autocomplete="off" value="Ninguna o Desconocida" readonly>
                            </div>
                            <div class="col-sm-6">
                              <label for="tituloTesis" class="control-label">Título tesis</label>
                              <input id="tituloTesis" value="{{$query->tituloTesis}}" class="form-control" placeholder="Título de Tesis" name="tituloTesis" type="text" readonly>                            
                            </div>
                        </div>
                        <br>
                        <legend>Contacto de Emergencia</legend>
                        <div class="row">
                            <div class="col-sm-6">
                              <label for="nombreContactoEmergencia" class="control-label">Nombre contacto de emergencia</label>
                              <input id="nombreContactoEmergencia" value="{{$query->nombreContactoEmergencia}}" class="form-control" placeholder="Nombres" name="nombreContactoEmergencia" type="text" readonly>                            
                            </div>
                            <div class="col-sm-4">
                              <label for="telefonoContactoEmergencia" class="control-label">Teléfono</label>
                              <input id="telefonoContactoEmergencia" value="{{$query->telefonoContactoEmergencia}}" class="form-control" placeholder="Teléfono" name="telefonoContactoEmergencia" type="tel" readonly>                            
                            </div>
                        </div>
                        <br>

                        <legend>Profesion y Especialidad</legend>
                        <div class="row">
                            <div class="col-sm-6">
                              <label for="profesion" class="control-label">Profesion:</label>
                              @if ($profesion->c_profesion==true)
                              <input id="profesion" value="{{\App\Profesion::find($profasp->c_profesion)->titulo_masculino}} {{\App\Profesion::find($profasp->c_profesion)->n_profesion}}" class="form-control" name="profesion" type="text" readonly>                              @else 
                              @else
                              <input id="profesion" value="No ingresada" class="form-control" placeholder="Teléfono" name="profesion" type="tel" readonly>                            
                              @endif
{{--                                 <input id="profesion" value="{{\App\Profesion::find($profasp->c_profesion)->titulo_masculino}} {{\App\Profesion::find($profasp->c_profesion)->n_profesion}}" class="form-control" name="profesion" type="text" readonly>         
 --}}                              </div>
                            <div class="col-sm-4">
                              <label for="especialidad" class="control-label">Especialidad:</label>

                               @if($especialidadasp ["c_especialidad"] == null)
                              <input id="especialidad" value="No ingresada" class="form-control" name="especialidad" type="text" readonly>         
                              @else 
                               <input id="especialidad" value="{{\App\Especialidad::find($especialidadasp->c_especialidad)->n_especialidad}}" class="form-control" name="especialidad" type="text" readonly>         
                               @endif  
                            </div>
                        </div>
                        <br>
                        <legend>Datos de Timbre</legend>
                        <div class="row">
                            <div class="col-sm-6">
                              <label for="profesion" class="control-label">Monto:</label>
                            @if ($query->montoTimbre==true)
                               <input id="profesion" value="{{$query->montoTimbre}}" value="No ingresado" class="form-control" name="profesion" type="text" readonly>         
                              @else
                             <input id="profesion" value="No ingresado" class="form-control" name="profesion" type="text" readonly>         
                              @endif
                              </div>
                            <div class="col-sm-4">
                              <label for="especialidad" class="control-label">Fecha:</label>
                              @if ($query->topeFechaPagoCuotas==true)
                              <input id="especialidad" value="{{$query->topeFechaPagoCuotas}}" value="No ingresada" class="form-control" name="especialidad" type="text" readonly>           
                            @else 
                            <input id="especialidad" value="No ingresada" value="No ingresada" class="form-control" name="especialidad" type="text" readonly>           
                            @endif
                            </div>
                        </div>
                        <br>
                      <div class="text-right m-t-15">
         {{--                <a class='btn btn-danger form-button' href="{{ route('colegiados.index') }}">Regresar</a>
 <button id="guardarAspirante" onclick="guardarAspiranteF()" class="form-button btn btn-success" type="button">Guardar Aspirante</button>
 
  <button class="btn btn-primary form-button"  id="ButtonColegiado">Guardar</button> 
 <button id="guardarAspirante" onclick="guardarAspiranteF()" class="form-button btn btn-success" type="button">Guardar Aspirante</button>
                        </div>--}}
                    </div>
                </div>
            </div>
        </form>
    <div class="loader loader-bar"></div>

@endsection  
@push('scripts')
{{-- <script src="{{asset('js/colegiados/aspirante.js')}}"></script>
 --}}@endpush

@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
      <script src="/ea/jquery.min.js"></script>

        <h1>
          Colegiados
          <small>Editar aspirante </small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('colegiados.index')}}"><i class="fa fa-list"></i> Colegiados</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@endsection
@section('meta')

<script>
$(document).ready(function(){
//  $('#dpi').mask('0000 00000 0000', {reverse: true});
  $('#dpi').mask('AAAA AAAAA AAAA', {reverse: true});
    $("#mostrarDetalles").click(function(){
        $("#detalles").toggle();
    });
});
</script>

@endsection


@push('scripts')
<script src="{{asset('/ea/jquery-ui.min.js')}}"></script>
<script src="{{asset('/ea/jquery.mask.min.js')}}"></script>
<script src="{{asset('/ea/bootstrap.min.js')}}"></script>

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
                            <input id="dpi" autofocus="" value="{{$query->dpi}}" class="form-control" name="dpi" type="text">                            
                            </div>
                            <div class="col-sm-4">
                              <label for="nombre">Nombres:</label>
                              <input id="nombres" class="form-control" value="{{$query->nombre}}" name="nombres" type="text">                            
                            </div>
                            <div class="col-sm-4">
                              <label for="apellidos" class="control-label">Apellidos</label>
                              <input id="apellidos" class="form-control" value="{{$query->apellidos}}" name="apellidos" type="text">                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                             <div class='col-sm-2'>
                              <label for="sexo">Sexo:</label>
                              <select class="form-control" id="sexo" name="sexo">
                                <option value="{{$query->sexo}}">{{$sx->n_sexo}}</option>
                                <option value="F">FEMENINO</option>
                                <option value="M">MASCULINO</option>
                              </select>                            
                              </div>
                              <div class="col-sm-2">
                                <label for="fechaNacimiento" class="control-label">Fecha Nac.</label>
                                <input id="fechaNacimiento" class="form-control" name="fechaNacimiento" value="{{$query->fechaNacimiento}}" type="date" max="9999-12-31">                            
                              </div>
                              <div class='col-sm-4'>
                                <label for="valMunicipioNacimiento" class="control-label">Municipio Nac.</label>
                                <input id="valMunicipioNacimiento" list="countries" class="form-control ui-autocomplete-input" value="{{$muninac->n_mpo}}" name="valMunicipioNacimiento" type="text" autocomplete="off">
                                <input type="hidden" id="idMunicipioNacimiento" name="idMunicipioNacimiento">
                              </div>
                              <div class='col-sm-4'>
                                <label for="valDepartamentoNacimiento" class="control-label">Depto. Nac.</label>
                                <input id="valDepartamentoNacimiento" class="form-control ui-autocomplete-input" value="{{$depnac->n_depto}}" name="valDepartamentoNacimiento" type="text" autocomplete="on">
                                <input type="hidden" id="idDepartamentoNacimiento" name="idDepartamentoNacimiento">
                              </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class='col-sm-4'>
                              <label for="valPais" class="control-label">País</label>
                              <input id="valPais" class="form-control ui-autocomplete-input" value="{{$paisnac->n_pais}}" name="valPais" type="text" autocomplete="on">
                              <input type="hidden" id="idPais" name="idPais">
                            </div>
                            <div class="col-sm-4">
                              <label for="valNacionalidad" class="control-label">Nacionalidad</label>
                              <input id="valNacionalidad" class="form-control ui-autocomplete-input" value="{{$nacionalidad->n_nacionalidad}}" name="valNacionalidad" type="text" autocomplete="off">
                              <input type="hidden" id="idNacionalidad" name="idNacionalidad">
                            </div>
                            <div class="col-sm-4">
                              <label for="telefono" class="control-label">Teléfono</label>
                              <input id="telefono" class="form-control" value="{{$query->telefono}}" name="telefono" type="text">                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="email" class="control-label">Correo electrónico</label>
                              <input id="email" class="form-control" value="{{$query->correo}}" name="email" type="text">                            
                            </div>
                            <div class="col-sm-4">
                              <label for="estadoCivil" class="control-label">Estado civil</label>
                              <select onchange="mostrarConyugue();" id="estadoCivil" class="form-control" name="estadoCivil">
                                <option value="C">Casado(a)</option>
                                <option value="D">Divorciado(a)</option>
                                <option value="S" selected="selected">Soltero(a)</option>
                                <option value="U">Unido(a)</option>
                                <option value="V">Viudo(a)</option>
                              </select>                            
                            </div>
                            <div class="col-sm-4">
                              <label for="direccion" class="control-label">Dirección</label>
                              <input id="direccion" class="form-control" value="{{$query->direccionCasa}}" name="direccion" type="text">                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                              <label for="zona" class="control-label">Zona</label>
                              <input id="zona" class="form-control" value="{{$query->zona}}" name="zona" type="tel">                            
                            </div>
                            <div class="col-sm-3">
                              <label for="valMunicipio" class="control-label">Municipio Casa</label>
                              <input id="valMunicipio" list="countries" class="form-control ui-autocomplete-input" value="{{$municasa->n_mpo}}" name="valMunicipio" type="text" autocomplete="off">
                              <input type="hidden" id="idMunicipio" name="idMunicipio">
                            </div>
                            <div class="col-sm-3">
                              <label for="valDepartamento" class="control-label">Departamento Casa</label>
                              <input id="valDepartamento" list="countries" class="form-control ui-autocomplete-input" value="{{$depcasa->n_depto}}" name="valDepartamento" type="text" autocomplete="off">
                              <input type="hidden" id="idDepartamento" name="idDepartamento">
                            </div>
                            <div class="col-sm-3">
                              <label for="destino" class="control-label">Destino correo</label>
                              <select class="form-control" id="destino" name="destino">
                                <option value="Casa">Casa</option>
                                <option value="Oficina">Oficina</option>
                                <option value="Otros">Otros</option>
                              </select>
                            </div>
                        </div>
                        <br>
                        <legend>Trabajo</legend>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="direccionTrabajo" class="control-label">Dirección Trabajo</label>
                              <input id="direccionTrabajo" class="form-control" {{$query->direccionTrabajo}} name="direccionTrabajo" type="text">                            
                            </div>
                            <div class="col-sm-4">
                              <label for="zonaTrabajo" class="control-label">Zona</label>
                              <input id="zonaTrabajo" class="form-control" value="{{$query->zonatrabajo}}" name="zonaTrabajo" type="tel">                            
                            </div>
                            <div class="col-sm-4">
                              <label for="telTrabajo" class="control-label">Tel. Trabajo</label>
                              <input id="telTrabajo" class="form-control" value="{{$query->telefonoTrabajo}}" name="telTrabajo" type="tel">                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="valMunicipioTrabajo" class="control-label">Municipio Trabajo</label>
                              <input id="valMunicipioTrabajo" list="countries" class="form-control ui-autocomplete-input" value="{{$munitrab->n_mpo}}" name="valMunicipioTrabajo" type="text" autocomplete="off">
                              <input type="hidden" id="idMunicipioTrabajo" name="idMunicipioTrabajo">
                            </div>
                            <div class="col-sm-4">
                              <label for="valDepartamentoTrabajo" class="control-label">Depto. Trab.</label>
                              <input id="valDepartamentoTrabajo" class="form-control ui-autocomplete-input" value="{{$deptrab->n_depto}}" name="valDepartamentoTrabajo" type="text" autocomplete="off">
                              <input type="hidden" id="idDepartamentoTrabajo" name="idDepartamentoTrabajo">
                            </div>
                        </div>
                        <br>
                        <legend>Datos Académicos</legend>
                        <div class="row">
                            <div class="col-sm-2">
                              <label for="fechaGraduacion" class="control-label">Fecha Graduación</label>
                              <input id="fechaGraduacion" class="form-control" value="{{date('d-m-Y', strtotime($query->fechaGraduacion))}}" name="fechaGraduacion" type="date" max="9999-12-31">
                            </div>
                            <div class="col-sm-5">
                              <label for="valUniversidadGraduado" class="control-label">Universidad Graduado</label>
                              <input id="valUniversidadGraduado" class="form-control ui-autocomplete-input" value="{{$uni->n_universidad}}" name="valUniversidadGraduado" type="text" autocomplete="off">
                              <input type="hidden" id="idUniversidadGraduado" name="idUniversidadGraduado">
                            </div>
                            <div class="col-sm-5">
                              <label> Carrera afin </label>   
                              <input id="ca" name="interests[]" type="checkbox" value="ca">     
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="valUniversidadIncorporado" class="control-label">Universidad incorporado</label>
                                @if ($query->universidadIncorporado==null)
                                <input id="valUniversidadIncorporado" value="Ninguna o Desconocida" class="form-control ui-autocomplete-input" placeholder="Universidad" name="valUniversidadIncorporado" type="text" autocomplete="off" value="Ninguna o Desconocida">
                                @else
                                <input id="valUniversidadIncorporado" value="{{$uniinc->n_universidad}}" class="form-control ui-autocomplete-input" placeholder="Universidad" name="valUniversidadIncorporado" type="text" autocomplete="off" readonly>
                                @endif
                            </div>
                            <div class="col-sm-6">
                              <label for="tituloTesis" class="control-label">Título tesis</label>
                              <input id="tituloTesis" class="form-control" value="{{$query->tituloTesis}}" name="tituloTesis" type="text">                            
                            </div>
                        </div>
                        <br>
                        <legend>Contacto de Emergencia</legend>
                        <div class="row">
                            <div class="col-sm-6">
                              <label for="nombreContactoEmergencia" class="control-label">Nombre contacto de emergencia</label>
                              <input id="nombreContactoEmergencia" required="" class="form-control" value="{{$query->nombreContactoEmergencia}}" name="nombreContactoEmergencia" type="text">                            
                            </div>
                            <div class="col-sm-4">
                              <label for="telefonoContactoEmergencia" class="control-label">Teléfono</label>
                              <input id="telefonoContactoEmergencia" required="" class="form-control" value="{{$query->telefonoContactoEmergencia}}" name="telefonoContactoEmergencia" type="tel">                            
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-danger form-button' href="{{ route('aspirantes.index') }}">Regresar</a>
                          <button id="ButtonGuardarAspirante" class="btn btn-primary edit" type="button">Actualizar Aspirante</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <div class="loader loader-bar"></div>

@endsection
@push('scripts')
<script src="{{asset('js/colegiados/create.js')}}"></script>

@endpush


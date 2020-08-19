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
@endpush 
  
@section('content')
<form method="POST" id="colegiadosForm" >
  {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <legend>Información Personal</legend>
                        <div class="row">
                            <div class="col-sm-2">
                              <label for="dpi">DPI</label>
                              <input name="dpi" value="{{$query->registro}}" class="form-control" type="text" readonly>                            
                            </div> 
                            <div class="col-sm-2">
                              <label for="n_cliente">Numero Colegiado</label>
                              <input name="n_cliente" value="{{$query->c_cliente}}" class="form-control" type="text" readonly>                            
                            </div> 
                            <div class="col-sm-6">
                              <label for="nombre">Nombres</label>
                              <input id="nombres"  value="{{$query->n_cliente}}" class="form-control" placeholder="Nombres" name="nombres" type="text" readonly>                            
                            </div>
                            <div class="col-sm-2">
                              <label for="sexo">Sexo</label>
                              <input name="sexo" value="{{$sx->n_sexo}}" class="form-control" type="text" readonly>                            
                            </div> 
                        </div>
                        <br>
                         <div class="row">
                            <div class="col-sm-4">
                              <label for="fechaNacimiento" class="control-label">Fecha Nac.</label>
                              <input id="fechaNacimiento" value="{{$query->fecha_nac}}" class="form-control" name="fechaNacimiento" type="text" readonly>                            
                            </div>
                            <div class='col-sm-4'>
                              <label for="valMunicipioNacimiento" class="control-label">Municipio Nac.</label>
                                @if ($muninac->c_mpo!=null)
                              <input id="valMunicipioNacimiento" value="{{$muninac->n_mpo}}" list="countries" class="form-control" placeholder="Municipio" name="valMunicipioNacimiento" type="text" autocomplete="off" readonly>
                              @else
                              <input id="valMunicipioNacimiento" value="No ingresado" list="countries" class="form-control" name="valMunicipioNacimiento" type="text" readonly>
                              @endif  
                            </div>
                            <div class='col-sm-4'>
                                <label for="valDepartamentoNacimiento" class="control-label">Depto. Nac.</label>
                                @if ($depnac->c_dpto!=null)
                              <input id="valDepartamentoNacimiento" value="{{$depnac->n_depto}}" class="form-control" placeholder="Departamento" name="valDepartamentoNacimiento" type="text" autocomplete="on" readonly> 
                              @else
                              <input id="valDepartamentoNacimiento" value="No ingresado" class="form-control" placeholder="Departamento" name="valDepartamentoNacimiento" type="text" autocomplete="on" readonly> 
                              @endif
                            </div>
                        </div>
                        <br>
                          <div class="row">
                            <div class='col-sm-4'>
                              <label for="valPais" class="control-label">País</label>
                               @if($query->c_pais== null)
                              <input id="Pais" value="No encontrado" class="form-control ui-autocomplete-input" name="valPais" type="text" autocomplete="on" readonly>
                              @else
                              <input id="Pais" value="{{$paisnac->n_pais}}" class="form-control ui-autocomplete-input" name="valPais" type="text" autocomplete="on" readonly>
                              @endif 
                            </div>
                            <div class="col-sm-4">
                              <label for="telefono" class="control-label">Teléfono</label>
                              <input id="telefono" value="{{$query->telefono}}" class="form-control" placeholder="Teléfono" name="telefono" type="text" readonly>                            
                            </div>
                          <div class="col-sm-4">
                            <label for="direccion" class="control-label">Direccion</label>
                            <input id="direccion" value="{{$query->direccion}}" class="form-control" placeholder="Teléfono" name="telefono" type="text" readonly>                            
                          </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-sm-3">
                              <label for="valNacionalidad" class="control-label">Nacionalidad</label>
                               @if($query->nacionalidad== null)
                              <input id="Nacionalidad" value="No ingresada" class="form-control ui-autocomplete-input" name="valNacionalidad" type="text" readonly>
                              @else
                              <input id="Nacionalidad" value="{{$nacionalidad->n_nacionalidad}}" class="form-control ui-autocomplete-input" name="valNacionalidad" type="text" readonly>
                             @endif 
                            </div>
                            <div class="col-sm-3">
                              <label for="email" class="control-label">Correo electrónico</label>
                              <input id="email" value="{{$query->e_mail}}" class="form-control" name="email" type="text" readonly>                            
                            </div>
                            <div class="col-sm-3">
                              <label for="estadoCivil" class="control-label">Estado civil</label>
                              <input id="estadoCivil" value="{{$ecivil->n_civil}}" class="form-control" name="estadoCivil" type="text" readonly>                                  
                            </div>
                            <div class="col-sm-3">
                              <label for="destino" class="control-label">Destino correo</label>
                              <input id="destino" value="{{$query->destino_correo}}" class="form-control" name="valMunicipio" type="text" autocomplete="off" readonly>
                            </div>
                          </div>
                          <br>
                          <div class="row">
                              <div class="col-sm-4">
                                <label for="valMunicipio" class="control-label">Municipio Casa</label>
                                @if ($query->c_mpocasa==null)
                                <input id="valMunicipio" value="No ingresado" list="countries" class="form-control ui-autocomplete-input" name="valMunicipio" type="text" autocomplete="off" readonly>
                                 @else
                               <input id="valMunicipio" value="{{$municasa->n_mpo}}" list="countries" class="form-control ui-autocomplete-input" name="valMunicipio" type="text" autocomplete="off" readonly>
                                 @endif
                             </div>
                             <div class="col-sm-4">
                              <label for="departamentocasa" class="control-label">Departamento Casa</label>
                              @if ($query->c_deptocasa==null)
                              <input id="departamentocasa" value="No ingresado" list="countries" class="form-control ui-autocomplete-input" name="departamentocasa" type="text" autocomplete="off" readonly>
                               @else
                             <input id="departamentocasa" value="{{$depcasa->n_depto}}" list="countries" class="form-control ui-autocomplete-input" name="departamentocasa" type="text" autocomplete="off" readonly>
                               @endif
                           </div>
                           <div class="col-sm-4">
                            <label for="zona" class="control-label">Zona</label>
                            <input id="zona" value="{{$query->zona}}" class="form-control" placeholder="Zona" name="zona" type="tel" readonly>                            
                          </div>
                            </div>
                          <br>
                          <legend>Trabajo</legend>
                          <div class="row">
                            <div class="col-sm-3">
                              <label for="direccionTrabajo" class="control-label">Dirección Trabajo</label>
                              <input id="direccionTrabajo" value="{{$query->dir_trabajo}}" class="form-control" placeholder="Dirección" name="direccionTrabajo" type="text" readonly>                            
                            </div>
                            <div class="col-sm-3">
                              <label for="zonaTrabajo" class="control-label">Zona</label>
                              <input id="zonaTrabajo" value="{{$query->zona_trabajo}}" class="form-control" placeholder="Zona" name="zonaTrabajo" type="tel" readonly>                            
                            </div>
                         
                            <div class="col-sm-3">
                              <label for="valMunicipioTrabajo" class="control-label">Municipio Trabajo</label>
                              @if ($query->c_mpotrab==null)
                              <input id="valMunicipioTrabajo" value="No ingresado" class="form-control ui-autocomplete-input" name="valMunicipioTrabajo" type="text" autocomplete="off" readonly>
                             @else
                             <input id="valMunicipioTrabajo" value="{{$munitrab->n_mpo}}" class="form-control ui-autocomplete-input" name="valMunicipioTrabajo" type="text" autocomplete="off" readonly>
                            @endif
                           </div>
                           <div class="col-sm-3">
                              <label for="valDepartamentoTrabajo" class="control-label">Depto. Trab.</label>
                              @if ($query->c_deptotrab==null)
                              <input id="valDepartamentoTrabajo" value="No ingresado" class="form-control ui-autocomplete-input" name="valDepartamentoTrabajo" type="text" autocomplete="off" readonly>
                             @else
                             <input id="valDepartamentoTrabajo" value="{{$deptrab->n_depto}}" class="form-control ui-autocomplete-input" name="valDepartamentoTrabajo" type="text" autocomplete="off" readonly>
                            @endif
                           </div>
                          </div>
                          <br>
                          <legend>Datos Académicos</legend>
                          <div class="row">
                              <div class="col-sm-2">
                                <label for="fechaGraduacion" class="control-label">Fecha Graduación</label>
                                <input id="fechaGraduacion" value="{{$query->fecha_grad}}" class="form-control" name="fechaGraduacion" type="text" readonly>
                              </div>
                              <div class="col-sm-5">
                                <label for="valUniversidadGraduado" class="control-label">Universidad Graduado</label>
                                <input id="valUniversidadGraduado" value="{{$uni->n_universidad}}" class="form-control ui-autocomplete-input" name="valUniversidadGraduado" type="text" autocomplete="off" readonly>
                              </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-sm-6">
                              <label for="valUniversidadIncorporado" class="control-label">Universidad incorporado</label>
                              <input id="valUniversidadIncorporado" value="{{$uniinc->n_universidad}}" class="form-control ui-autocomplete-input" name="valUniversidadIncorporado" type="text" autocomplete="off" readonly>
                            </div>
                            <div class="col-sm-6">
                              <label for="tituloTesis" class="control-label">Título tesis</label>
                              <input id="tituloTesis" value="{{$query->titulo_tesis}}" class="form-control" name="tituloTesis" type="text" readonly>                            
                            </div>
                        </div>
                        <br>
                        <legend>Contacto de Emergencia</legend>
                        <div class="row">
                            <div class="col-sm-6">
                              <label for="nombreContactoEmergencia" class="control-label">Nombre contacto de emergencia</label>
                              @if ($query->nombreContactoEmergencia==null)
                              <input id="nombreContactoEmergencia" value="No ingresado" class="form-control" placeholder="Nombres" name="nombreContactoEmergencia" type="text" readonly>                            
                              @else
                              <input id="nombreContactoEmergencia" value="{{$query->nombreContactoEmergencia}}" class="form-control" placeholder="Nombres" name="nombreContactoEmergencia" type="text" readonly>                            
                              @endif
                            </div>
                            <div class="col-sm-4">
                              <label for="telefonoContactoEmergencia" class="control-label">Teléfono</label>
                              @if ($query->telefonoContactoEmergencia==null)
                              <input id="telefonoContactoEmergencia" value="No ingresado" class="form-control" name="telefonoContactoEmergencia" type="tel" readonly>                            
                              @else
                              <input id="telefonoContactoEmergencia" value="{{$query->telefonoContactoEmergencia}}" class="form-control" name="telefonoContactoEmergencia" type="tel" readonly>                            
                              @endif
                            </div>
                        </div>
                        <br>
                        <legend>Profesión y Especialidad</legend>
                        <div class="row">
                            <div class="col-sm-6">
                              <label for="Profesión" class="control-label">Profesión:</label>
                              @if ($profasp!=null)
                              <input id="profesion" value="{{$profasp->n_profesion}}" class="form-control" name="profesion" type="text" readonly>                           
                              @else
                              <input id="profesion" value="No ingresada" class="form-control" name="profesion" type="text" readonly>                            
                              @endif
                              </div>
                            <div class="col-sm-4">
                              <label for="especialidad" class="control-label">Especialidad:</label>
                                 @if($especialidadasp!= null)
                                <input id="especialidad" value="{{$especialidadasp->n_especialidad}}" class="form-control" name="especialidad" type="text" readonly>         
                              @else 
                               <input id="especialidad" value="No ingresada" class="form-control" name="especialidad" type="text" readonly>         
                               @endif    
                            </div>
                        </div>
                        <br>
                        <legend>Datos de Timbre</legend>
                        <div class="row">
                            <div class="col-sm-6">
                              <label for="montoTimbre" class="control-label">Monto:</label>
                            @if ($query->monto_timbre!=null)
                               <input id="montoTimbre" value="{{$query->monto_timbre}}" class="form-control" name="montoTimbre" type="text" readonly>         
                            @else
                             <input id="montoTimbre" value="No ingresado" class="form-control" name="montoTimbre" type="text" readonly>         
                              @endif
                            </div>
                            <div class="col-sm-4">
                              <label for="fechaMonto" class="control-label">Fecha:</label>
                              @if ($query->f_ult_timbre!=null)
                              <input id="fechaMonto" value="{{$query->f_ult_timbre}}" class="form-control" name="fechaMonto" type="text" readonly>           
                            @else 
                            <input id="fechaMonto" value="No ingresada" class="form-control" name="fechaMonto" type="text" readonly>           
                            @endif
                            </div>
                        </div>
                        <br>
                        <legend>Datos de Colegiación</legend>
                        <div class="row">
                            <div class="col-sm-3">
                              <label for="c_colegiado" class="control-label">Número de Colegiado:</label>
                            @if ($query->c_cliente!=null)
                               <input id="c_colegiado" value="{{$query->c_cliente}}" class="form-control" name="c_colegiado" type="text" readonly>         
                            @else
                             <input id="c_colegiado" value="No ingresado" class="form-control" name="c_colegiado" type="text" readonly>         
                              @endif
                            </div>
                            <div class="col-sm-3">
                              <label for="fecha_col" class="control-label">Fecha de Colegiación:</label>
                              @if ($query->fecha_col!=null)
                              <input id="fecha_col" value="{{$query->fecha_col}}" class="form-control" name="fecha_col" type="text" readonly>           
                            @else 
                            <input id="fecha_col" value="No ingresada" class="form-control" name="fecha_col" type="text" readonly>           
                            @endif
                            </div>
                            <div class="col-sm-3">
                              <label for="col_pagado" class="control-label">Colegio pagado hasta:</label>
                              @if ($query->f_ult_pago!=null)
                              <input id="col_pagado" value="{{$query->f_ult_pago}}" class="form-control" name="col_pagado" type="text" readonly>           
                            @else 
                            <input id="col_pagado" value="No ingresada" class="form-control" name="col_pagado" type="text" readonly>           
                            @endif
                            </div>
                            <div class="col-sm-3">
                              <label for="timbre_pagado" class="control-label">Timbre pagado hasta:</label>
                              @if ($query->f_ult_timbre!=null)
                              <input id="timbre_pagado" value="{{$query->f_ult_timbre}}" class="form-control" name="timbre_pagado" type="text" readonly>           
                            @else 
                            <input id="timbre_pagado" value="No ingresada" class="form-control" name="timbre_pagado" type="text" readonly>           
                            @endif
                            </div>
                        </div>
                        <br>  
                </div>
            </div>
        </form>
    <div class="loader loader-bar"></div>

@endsection  
@push('scripts')
@endpush

@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Colegiados
          <small>Ingresar datos de nuevo colegiado </small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('colegiados.index')}}"><i class="fa fa-list"></i> Colegiados</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop


@section('content')
    <form method="POST" id="colegiadosForm" action="{{route('colegiados.save')}}" >
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <legend>Información Personal</legend>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="dpi">Dpi:</label>
                                <input type="text" class="form-control" placeholder="Dpi" name="dpi" >
                            </div>
                            <div class="col-sm-4">
                                <label for="nombre">Nombres:</label>
                                <input type="text" class="form-control" placeholder="Nombres" name="nombre" >
                            </div>
                            <div class="col-sm-4">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" class="form-control" placeholder="Apellidos" name="apellidos" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="sexo">Sexo:</label>
                                <select  class="form-control" placeholder="Sexo:" name="sexo" >
                                    <option value="value1">M</option> 
                                    <option value="value2" selected>F</option>
                                </select>   
                            </div>
                            <div class="col-sm-2">
                                <label for="fechanac">Fecha de nacimiento:</label>
                                <input type="date" class="form-control" placeholder="fechanac:" name="fechanac" >
                            </div>
                            <div class="col-sm-4">
                                <label for="municipio">Municipio:</label>
                                <input type="text" class="form-control" placeholder="Municipio" name="municipio">
                            </div>
                            <div class="col-sm-4">
                                <label for="departamento">Departamento:</label>
                                <input type="text" class="form-control" placeholder="Departamento" name="departamento">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="pais">País:</label>
                                <input type="text" class="form-control" placeholder="País" name="pais">
                            </div>
                            <div class="col-sm-4">
                                <label for="nacionalidad">Nacionalidad:</label>
                                <input type="text" class="form-control" placeholder="Nacionalidad" name="nacionalidad">
                            </div>
                            <div class="col-sm-4">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" placeholder="Telefono:" name="telefono">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="correo_electronico">Correo Electrónico:</label>
                                <input type="text" class="form-control" placeholder="Correo electrónico:" name="correo_electronico">
                            </div>
                            <div class="col-sm-4">
                                <label for="estadocivil">Estado Civil:</label>
                                <select  class="form-control" placeholder="Sexo:" name="sexo" >
                                    <option value="value1">Casado (a)</option> 
                                    <option value="value2" selected>Soltero (a)</option>
                                </select>                            
                            </div>
                            <div class="col-sm-4">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" placeholder="Direccion:" name="direccion">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="zona">Zona:</label>
                                <input type="text" class="form-control" placeholder="Zona:" name="zona">
                            </div>
                            <div class="col-sm-4">
                                <label for="municipioc">Municipio:</label>
                                <input type="text" class="form-control" placeholder="Municipio" name="municipioc">
                            </div>
                            <div class="col-sm-4">
                                <label for="correo_destino">Correo Electrónico Destino:</label>
                                <input type="text" class="form-control" placeholder="Correo electrónico" name="correo_destino">
                            </div>
                        </div>
                        <br>
                        <legend>Trabajo</legend>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="direcciontrabajo">Dirección Trabajo:</label>
                                <input type="text" class="form-control" placeholder="Dirección" name="direcciontrabajo">
                            </div>
                            <div class="col-sm-4">
                                <label for="nombre_sede">Zona Trabajo:</label>
                                <input type="text" class="form-control" placeholder="Nombre Sede:" name="nombre_sede" >
                            </div>
                            <div class="col-sm-4">
                                <label for="telefonotrabajo">Teléfono Trabajo:</label>
                                <input type="text" class="form-control" placeholder="Telefono" name="telefonotrabajo">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="municipiotrabajo">Municipio Trabajo:</label>
                                <input type="text" class="form-control" placeholder="Municipio" name="municipiotrabajo">
                            </div>
                            <div class="col-sm-4">
                                <label for="departamentotrabajo">Departamento Trabajo:</label>
                                <input type="text" class="form-control" placeholder="Departamento" name="departamentotrabajo" >
                            </div>
                        </div>
                        <br>
                        <legend>Datos Académicos</legend>
                        <div class="row">
                            <div class="col-sm-2">
                                <label for="fechagrad">Fecha de Graduación:</label>
                                <input type="date" class="form-control" placeholder="Fecha" name="fechagrad" >
                            </div>
                            <div class="col-sm-5">
                                <label for="ugrad">Universidad de Graduación:</label>
                                <input type="text" class="form-control" placeholder="Universidad" name="ugrad" >
                            </div>
                            <div class="col-sm-5">
                                <label for="carrera">Carrera:</label>
                                <input type="checkbox" class="form-control" placeholder="Carrera" name="carrera">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="uinc">Universidad Incorporado:</label>
                                <input type="text" class="form-control" placeholder="Universidad" name="uinc" value="Ninguna o Desconocida">
                            </div>
                            <div class="col-sm-6">
                                <label for="tesis">Título de Tesis: (opcional)</label>
                                <input type="text" class="form-control" placeholder="Título" name="tesis" >
                            </div>
                        </div>
                        <br>
                        <legend>Contacto de Emergencia</legend>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="nombreemergencia">Nombre de contacto de emergencia:</label>
                                <input type="text" class="form-control" placeholder="Nombre" name="nombreemergencia" >
                            </div>
                            <div class="col-sm-4">
                                <label for="numeroemergencia">Número de contacto de emergencia:</label>
                                <input type="text" class="form-control" placeholder="Número" name="numeroemergencia" >
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-danger form-button' href="{{ route('colegiados.index') }}">Regresar</a>

                            <button class="btn btn-primary form-button" id="ButtonColegiado">Guardar</button>

                        </div>

                    </div>
                </div>
            </div>
    </form>
    <div class="loader loader-bar"></div>

@stop

@push('styles')

@endpush

@push('scripts')
<script src="{{asset('js/colegiados/create.js')}}"></script>
@endpush

@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          SOLICITUDES
          <small>Ingresar Solicitud</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('solicitud.index')}}"><i class="fa fa-list"></i> Solicitudes</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="SolicitudForm"  action="{{route('solicitud.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="fecha">Fecha:</label>
                                <input type="date" class="form-control" value="<?php echo date("Y-m-d");?>" name="fecha" >
                            </div>
                            <div class="col-sm-4">
                                <label for="departamento_id">Departamento:</label>
                                <input type="text" class="form-control" placeholder="Departamento:" name="departamento_id" >
                            </div>
                            <div class="col-sm-4">
                                <label for="responsable">Responsable:</label>
                                <input type="text" class="form-control" placeholder="Responsable:" name="responsable" >
                            </div> 
                        </div>
                        <br> 
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="descripcion_boleta">Descripcion de la boleta:</label>
                                <input type="text" class="form-control" placeholder="Descripcion de la boleta:" name="descripcion_boleta">
                            </div>
                        </div>
                        <br> 

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="user_id">ID de supervisor:</label>
                                <input type="text" class="form-control" placeholder="ID de supervisor:" name="user_id" >
                            </div>
                            <div class="col-sm-8">
                                <label for="quien_la_usara">Ingrese quien la usara:</label>
                                <input type="text" class="form-control" placeholder="Ingrese quien la usara:" name="quien_la_usara" >
                            </div>
                        </div>
                        
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-danger form-button' href="{{ route('solicitud.index') }}">Regresar</a>
                            <button class="btn btn-primary form-button">Guardar</button>
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
<script src="{{asset('js/solicitudes/create.js')}}"></script>
@endpush

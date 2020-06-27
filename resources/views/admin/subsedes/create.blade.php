@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          SUBSEDES
          <small>Ingresar datos de la Subsede </small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('subsedes.index')}}"><i class="fa fa-list"></i> subsedes</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="subsedesForm"  action="{{route('subsedes.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="nombre_sede">Nombre:</label>
                                <input type="text" class="form-control" placeholder="Nombre Sede:" name="nombre_sede" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" placeholder="Direccion:" name="direccion" >
                            </div>
                            <div class="col-sm-4">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" placeholder="Telefono:" name="telefono" >
                            </div>
                            <div class="col-sm-4">
                                <label for="telefono_2">Teléfono 2:</label>
                                <input type="text" class="form-control" placeholder="Telefono 2:" name="telefono_2">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="correo_electronico">Correo electrónico:</label>
                                <input type="text" class="form-control" placeholder="Correo electronico:" name="correo_electronico">
                            </div>

                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('subsedes.index') }}">Regresar</a>

                            <button id = "subsedes" class="btn btn-success form-button">Guardar</button>

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
<script src="{{asset('js/subsedes/create.js')}}"></script>
@endpush



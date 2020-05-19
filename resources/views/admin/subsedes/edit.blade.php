@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          SUBSEDES
          <small>Editar Sede</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('subsedes.index')}}"><i class="fa fa-list"></i> Colaboradores</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="subsedesUpdateForm"  action="{{route('subsedes.update', $su)}}">
            {{csrf_field()}} {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" name="nombre_sede" value="{{$su->nombre_sede}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" name="direccion" value="{{$su->direccion}}">
                            </div>
                            <div class="col-sm-3">
                                    <label for="nombre">Teléfono:</label>
                                <input type="number" class="form-control" name="telefono" value="{{$su->telefono}}">
                            </div>
                            <div class="col-sm-3">
                                    <label for="telefono_2">Teléfono:</label>
                                    <input type="number" class="form-control" name="telefono_2" value="{{$su->telefono_2}}">
                            </div>
                            <div class="col-sm-3">
                                <label for="correo_electrónico">Correo Electrónico:</label>
                                <input type="text" class="form-control" name="correo_electronico" value="{{$su->correo_electronico}}">
                                <input type="hidden" name="num" value="{{$su->id}}">
                        </div>
                        <br>
                        <div class="row">
                        <div class="text-right mt-3">
                            <a class='btn btn-primary form-button' href="{{ route('subsedes.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonSubsedes">Guardar</button>
                        </div>
                    </div>
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
<script src="{{asset('js/subsedes/edit.js')}}"></script>
@endpush

@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Boletas
          <small>Editar Boletas</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('boleta.index')}}"><i class="fa fa-list"></i> Boletas</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="BoletaUpdateForm"  action="{{route('boleta.update', $boleta)}}">
            {{csrf_field()}}  {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <label for="no_boleta">Numero de Boleta:</label>
                                <input type="number" class="form-control" placeholder="Numero de Boleta:" name="no_boleta" value="{{$boleta->no_boleta}}" >
                            </div>
                            <div class="col-sm-5">
                                <label for="nombre_usuario">Nombre del usuario:</label>
                                <input type="text" class="form-control" placeholder="Nombre del usuario:" name="nombre_usuario" value="{{$boleta->nombre_usuario}}">
                            </div>
                            <div class="col-sm-2">
                                <label for="solicitud_boleta_id">Numero de solicitud:</label>
                                <input type="number" class="form-control" placeholder="Numero de solicitud:" name="solicitud_boleta_id" value="{{$boleta->solicitud_boleta_id}}" >
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-danger form-button' href="{{ route('boleta.index') }}">Regresar</a>
                            <button class="btn btn-primary form-button" id="ButtonBoletaUpdate">Guardar</button>
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
<script src="{{asset('js/boletas/edit.js')}}"></script>
@endpush
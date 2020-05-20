@extends('gerencia.layoutgerencia')

@section('header')
    <section class="content-header">
        <h1>
          Informes
          <small>Editar Informes</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('llamada.index')}}"><i class="fa fa-list"></i> Informes</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="LlamadaUpdateForm"  action="{{route('llamada.update', $informe)}}">
            {{csrf_field()}}  {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="colegiado">Colegiado:</label>
                                <input type="number" class="form-control" name="colegiado" value="{{$informe->colegiado}}" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="telefono">Telefono:</label>
                                <input type="text" class="form-control" name="telefono" value="{{$informe->telefono}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="observaciones">Observaciones:</label>
                                <textarea class="form-control" name="observaciones" rows="3">{{$informe->observaciones}}</textarea>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('llamada.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonLlamadaUpdate">Guardar</button>
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
<script src="{{asset('js/llamadas/edit.js')}}"></script>
@endpush
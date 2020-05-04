@extends('gerencia.layoutgerencia')

@section('header')
    <section class="content-header">
        <h1>
          Informes
          <small>Ingresar Informes</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('llamada.index')}}"><i class="fa fa-list"></i> Informes</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')


    <div class="box-header">
      <a class="btn btn-primary pull-right" href="{{route('llamada.index')}}">
        <i class="fa fa-file-alt"></i>    Ver Historial de Registros</a>
    </div>


    <form method="POST" id="LlamadaForm"  action="{{route('llamada.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="colegiado">Numero de Colegiado:</label>
                                <input type="number" class="form-control" placeholder="Numero de Colegiado:" name="colegiado" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="telefono">Telefono:</label>
                                <input type="number" class="form-control" placeholder="Telefono:" name="telefono" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="observaciones">Ingrese las Observaciones:</label>
                                <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('llamada.index') }}">Regresar</a>
                            <button class="btn btn-success form-button">Guardar</button>
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
<script src="{{asset('js/llamadas/create.js')}}"></script>
@endpush
@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          Actas
          <small>Ingresar Acta</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('acta.index')}}"><i class="fa fa-list"></i> Actas</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ActaForm"  action="{{route('acta.save')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="fecha_acta">Fecha:</label>
                                <input type="date" class="form-control" value="<?php echo date("Y-m-d");?>" name="fecha_acta" >
                            </div>
                            <div class="col-sm-6">
                                <label for="no_acta">Numero de Acta:</label>
                                <input type="number" class="form-control" name="no_acta" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="pdf_acta">Documento:</label>
                                <input type="file" name="pdf_acta" class="form-control"> 
                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-danger form-button' href="{{ route('acta.index') }}">Regresar</a>
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
<script src="{{asset('js/actas/create.js')}}"></script>
@endpush

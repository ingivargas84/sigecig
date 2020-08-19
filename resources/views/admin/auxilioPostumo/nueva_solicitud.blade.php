@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1><center>Crear nueva solicitud de Auxilio Póstumo</center>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{route('resolucion.index')}}"><i class="fa fa-list"></i> Resolución</a></li>
        <li class="active">Crear</li>
    </ol>
</section>
@section('content')
<div class="box-header">
<div class="pull-right col-md-4 col-sm-6 col-xs-12">
        <select id="colegiado" name="colegiado" class="selectpicker form-control" data-live-search="true">
          @foreach ($result as $colegiado)
          <option  value="{{$colegiado->c_cliente}}" > {{$colegiado->n_cliente}} </option>
          @endforeach
        </select>
  </div>


</div><br><br>
@include('admin.auxilioPostumo.solicitud')
@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('css/auxilio-postumo/bootstrap-select1.13.css') }}">

@endpush
@push('scripts')
    <script src="{{asset('js/resolucion/apinterno.js')}}"></script>
    <script src="{{asset('js/auxilio-postumo/bootstrap-select1.13.js')}}"></script>
@endpush
@stop

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
<div class="pull-right">
        <select id="colegiado" name="colegiado" class="form-control " >
          <option selected >Elegir colegiado *</option>
          @foreach ($result as $colegiado)
          <option  value="{{$colegiado->c_cliente}}" > {{$colegiado->n_cliente}} </option>
          @endforeach
        </select>
  </div>


</div><br><br>
@include('admin.auxilioPostumo.solicitud')
@endsection
@push('styles')
@endpush
@push('scripts')
    <script src="{{asset('js/resolucion/apinterno.js')}}"></script>
@endpush
@stop

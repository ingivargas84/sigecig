@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1><center>Crear nueva solicitud de Auxilio Póstumo</center>
    </h1>
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
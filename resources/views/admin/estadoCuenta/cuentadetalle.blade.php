@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1><center>
    Estado de Cuenta Detallado
    </center>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Estado de Cuenta Detallado</li>
    </ol>
  </section>

  @section('content')


<div class="box-header">

</div>
  <!-- /.box-header -->

  <!-- /.box-body -->
  <div>
      <label for="">Tipo de pago</label><input type="text">
  </div>
  <div class="loader loader-bar is-active" style="display: none "></div>
<!-- /.box --> 

@endsection

@push('styles')
 
 
@endpush

@push('scripts')

  @endpush
@stop
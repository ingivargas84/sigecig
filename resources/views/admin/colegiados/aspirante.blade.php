@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
  <script src="/ea/jquery.min.js"></script>

    <h1><center>
      Aspirantes
      </center>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Aspirantes</li>
    </ol>
  </section>

  @endsection

  @section('content')
  @include('admin.users.confirmarAccionModal')
  @include('admin.colegiados.profesionModal', $resultado)
  @include('admin.colegiados.timbreModal')
  @include('admin.colegiados.asociarModal')
  
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
        <a class="btn btn-primary pull-right" data-toggle="modal" href="{{route('aspirante.new')}}">
            Ingresar aspirante  <i class="fa fa-plus"></i></a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="aspirantes-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}">
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->

@endsection

@push('styles')
@endpush
@push('scripts')
<script src="{{asset('js/colegiados/aspiranteIndex.js')}}"></script>
<script src="{{asset('js/colegiados/profesionAsp.js')}}"></script>
<script src="{{asset('js/colegiados/timbre.js')}}"></script>
<script src="{{asset('js/colegiados/asociar.js')}}"></script>

<script src="{{ asset('js/bootstrap-select/bootstrap-select1.13.js') }}"></script>

  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
    $(document).ready(function(){
        aspirantes_table.ajax.url("{{route('aspirantes.getJson')}}").load();
    });
</script>
@endpush
@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
  <script src="/ea/jquery.min.js"></script>

    <h1><center>
      Colegiados
      </center>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Colegiados</li>
    </ol>
  </section>

  @endsection

  @section('content')
  @include('admin.users.confirmarAccionModal')
  @include('admin.colegiados.profesionModal')
  
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
        <a class="btn btn-primary pull-right" href="{{route('aspirante.new')}}">
            Ingresar colegiado  <i class="fa fa-plus"></i></a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="colegiados-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
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
<script src="{{asset('js/colegiados/index.js')}}"></script>
<script src="{{asset('js/colegiados/add.js')}}"></script>

   {{--  <script src="{{asset('js/bodegas/create.js')}}"></script>
      <script src="{{asset('js/bodegas/edit.js')}}"></script> --}}
 
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
    $(document).ready(function(){
        colegiados_table.ajax.url("{{route('colegiados.getJson')}}").load();
    });
</script>
@endpush
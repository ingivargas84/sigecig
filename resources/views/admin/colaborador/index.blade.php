@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1><center>
      Colaboradores
      </center>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Colaboradores</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <a class="btn btn-primary pull-right" href="{{route('colaborador.new')}}">
        <i class="fa fa-plus"></i> Ingresar Colaborador</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="colaboradores-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
      solicitudes_table.ajax.url("{{route('colaborador.getJson')}}").load();
    });

  </script>
  <script src="{{asset('js/colaboradores/index.js')}}"></script>

@endpush
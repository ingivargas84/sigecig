@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1><center>
      Bodegas
      </center>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Bodegas</li>
    </ol>
  </section>

  @endsection
 
@section('content')
@include('admin.users.confirmarAccionModal')
@include('admin.bodegas.createModal')
@include('admin.bodegas.editModal') 
@include('admin.bodegas.createModal')


<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#ingresoModal">
         Agregar <i class="fa fa-plus"></i></a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="bodegas-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
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
    <script src="{{asset('js/bodegas/index.js')}}"></script>
    <script src="{{asset('js/bodegas/create.js')}}"></script>
      <script src="{{asset('js/bodegas/edit.js')}}"></script>
 
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
    $(document).ready(function(){
        bodegas_table.ajax.url("{{route('bodegas.getJson')}}").load();
    });


  </script>

@endpush 

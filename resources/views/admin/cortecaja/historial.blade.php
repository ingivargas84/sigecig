@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1><center>
     Historial
      </center>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Historial</li>
    </ol>
  </section>
  @endsection

  @section('content')
 
<div class="loader loader-bar is-active"></div>
<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
     
        <legend ><center>Historial de Corte de Caja </center></legend>

      <input type="hidden" name="rol_user" value="{{auth()->user()->id}}">
        <table id="historial-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
        </table>

        <div class="text-right m-t-15">
        </div>

        <input type="hidden" name="urlActual" value="{{url()->current()}}">
    </div>
    <!-- /.box-body -->

  </div>
  <!-- /.box -->

  
  @endsection

@push('styles')
@endpush

@push('scripts')
<script src="{{asset('js/cortecaja/historial.js')}}"></script>

  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
    $(document).ready(function(){
      historial_table.ajax.url("{{route('cortedecaja.getHistorial')}}").load();
    });
</script>
@endpush
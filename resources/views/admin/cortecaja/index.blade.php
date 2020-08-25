@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1><center>
      Corte de Caja Diario
      </center>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Corte de Caja</li>
    </ol>
  </section>
  @endsection

  @section('content')
 
<div class="loader loader-bar is-active"></div>
<div class="box">
    <!-- /.box-header -->
    <div class="box-body">
      <legend><center>Detalles</center></legend>

        <input type="hidden" name="rol_user" value="{{auth()->user()->id}}">
        <table id="cortedecaja-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
        </table>
        <legend ><center>Total Recibido </center></legend>

        <input type="hidden" name="rol_user" value="{{auth()->user()->id}}">
        <table id="totales-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
        </table>

        <div class="text-right m-t-15">
          <a class="btn btn-primary" class='corte-caja' href="{{route('cortedecaja.save')}}">Corte de Caja</a>
          <a class="btn btn-primary" href="{{route('cortedecaja.pdfbitacora')}}">Generar PDF</a>
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
<script src="{{asset('js/cortecaja/index.js')}}"></script>
<script src="{{asset('js/cortecaja/totales.js')}}"></script>

  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
    $(document).ready(function(){
      cortedecaja_table.ajax.url("{{route('cortedecaja.getJson')}}").load();
      totales_table.ajax.url("{{route('cortedecaja.getDetalle')}}").load();

    });
</script>
@endpush
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
  
<div class="loader loader-bar is-active"></div>
<div class="box">
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

  
@push('styles')
@endpush
@push('scripts')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
    $(document).ready(function(){
        colegiados_table.ajax.url("{{route('colegiados.getJson')}}").load();
    });
</script>
@endpush
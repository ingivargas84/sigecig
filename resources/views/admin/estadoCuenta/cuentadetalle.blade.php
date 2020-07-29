@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1><center>
    Estado de Cuenta Detallado
    </center>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
      <li><a href="{{route('estadocuenta.index')}}"><i class="fa fa-list"></i> Estados de Cuenta </a></li>
      <li class="active">Detalle</li>
    </ol>
  </section>

  @section('content')


  <div class="box-header">

  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <input type="hidden" name="rol_user" value="{{$user->roles[0]->name}}">
      <table id="resolucion-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
      </table>
      <input type="hidden" name="urlActual" value="{{url()->current()}}">
  </div>
  <!-- /.box-body -->
  <div class="loader loader-bar is-active" style="display: none "></div>
</div>
<!-- /.box --> 

@endsection

@push('styles')
 
 
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
        resolucion_table.ajax.url("{{route('estadocuenta.getdetalle',$id)}}").load();       
    });
</script>
  <script src="{{asset('js/estadocuenta/detalle.js')}}"></script>
  @endpush
@stop
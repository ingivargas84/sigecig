@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1><center>
    Listado de Solicitudes Firmadas
    </center>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Solicitudes firmadas</li>
    </ol>
  </section>

  @section('content')
@include('admin.firmaresolucion.acta')

  <div class="box-header">
      <a class="btn btn-confirm pull-right" target="_blank" href="auxiliopostumo/solicitudes_pendientes">
        Solicitudes por aprobar <i class="fa fa-check"></i>  </a>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <input type="hidden" name="rol_user" value="{{$user->roles[0]->name}}">
      <table id="contabilidad-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
        contabilidad_table.ajax.url("{{route('contabilidad.getJson')}}").load();
    });
  
</script>

  <script src="{{asset('js/contabilidad/index.js')}}"></script>

  @endpush
@stop
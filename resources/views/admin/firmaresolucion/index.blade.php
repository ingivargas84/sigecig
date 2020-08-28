@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1><center>
    Solicitudes de Subsidio de Auxilio Póstumo
    </center>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Resolución</li>
    </ol>
  </section>

  @section('content')
@include('admin.firmaresolucion.acta')
@include('admin.contabilidad.configfecha')
@include('admin.firmaresolucion.aprobacion')

  <div class="box-header">

        @if ($user->roles[0]->name=='Administrador' || $user->roles[0]->name=='Super-Administrador' || $user->roles[0]->name=='Timbre' || $user->roles[0]->name=='JefeTimbres');
        <a class="btn btn-confirm pull-right" target="_blank" href="auxiliopostumo/solicitudes_pendientes">
          Solicitudes por aprobar <i class="fa fa-check"></i>  </a>
        <a class="btn btn-confirm pull-right"  href="auxiliopostumo/crea_solicitud" style="margin-right: 5px;">Crear solicitud Auxilio Póstumo  <i class="fa fa-plus"></i>  </a>
  
        @endif

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
        resolucion_table.ajax.url("{{route('resolucion.getJson')}}").load();       
    });
</script>
  <script src="{{asset('js/resolucion/index.js')}}"></script>
  

  @endpush
@stop
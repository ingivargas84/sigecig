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
  @include('admin.colegiados.profesionModal', $resultado)
  
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

@endsection

@push('styles')
<link rel="stylesheet" href='{{ asset('css/bootstrap-select/bootstrap-select1.13.css') }}'>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script> --}}
@endpush
@push('scripts')
<script src="{{asset('js/colegiados/index.js')}}"></script>
<script src="{{asset('/ea/jquery-ui.min.js')}}"></script>
<script src="{{asset('/ea/jquery.mask.min.js')}}"></script>
<script src="{{asset('js/colegiados/add.js')}}"></script>
<!-- Modal -->
<!-- Latest compiled and minified JavaScript -->
<script src="{{ asset('js/bootstrap-select/bootstrap-select1.13.js') }}"></script>

 {{--<script src="{{asset('ea/jquery.auto-complete.js')}}"></script>
<script src="{{asset('/ea/jquery.auto-complete.min.js')}}"></script> 
<script src="{{asset('/ea/bootstrap.min.js')}}"></script>--}}

  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
    $(document).ready(function(){
        colegiados_table.ajax.url("{{route('colegiados.getJson')}}").load();
    });
</script>
@endpush
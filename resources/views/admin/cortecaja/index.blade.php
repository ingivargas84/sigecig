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
{{--    @if($corte->corte_fecha->format('Y-m-d') != $hoy) 
 --}}    <!-- /.box-header -->
    <div class="box-body">
      <legend><center>Detalles</center></legend>

        <input type="hidden" name="rol_user" value="{{auth()->user()->id}}">
        <table id="cortedecaja-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
        </table>
      <legend ><center>Total Recibido </center></legend>

        <input type="hidden" name="rol_user" value="{{auth()->user()->id}}">
        <table id="totales-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">
        </table>

        <input id="monto_total" type="hidden" name="monto_total" value="{{$id}}">
        <input id="caja" type="hidden" name="caja" value="{{\App\Cajas::where('cajero', Auth::user()->id)->pluck('nombre_caja')->first()}}">
     {{--   \App\User::where(['name' => $posts->username])->pluck('avatar')->first();
         {{\App\Cajas::find($rp->serie_recibo_id)->serie_recibo}} --}}
        <div class="text-right m-t-15">
          <a class="btn btn-primary corte-caja data-method='post'" href="{{route('cortedecaja.save')}}">Corte de Caja</a>
        </div>

        <input type="hidden" name="urlActual" value="{{url()->current()}}">
    </div>
    <!-- /.box-body -->
   {{--   @endif
    @if($corte->corte_fecha->format('Y-m-d') == $hoy) 
    <h3> Corte de caja ya realizado </h3>
    @endif  --}}


  </div>
  <!-- /.box -->

  
  @endsection

@push('styles')
@endpush

@push('scripts')
<script src="{{asset('js/cortecaja/index.js')}}"></script>
<script src="{{asset('js/cortecaja/totales.js')}}"></script>
<script src="{{asset('js/cortecaja/historial.js')}}"></script>

  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
    $(document).ready(function(){
      cortedecaja_table.ajax.url("{{route('cortedecaja.getJson')}}").load();
      totales_table.ajax.url("{{route('cortedecaja.getDetalle')}}").load();
      historial_table.ajax.url("{{route('cortedecaja.getHistorial')}}").load();

    });
</script>
@endpush
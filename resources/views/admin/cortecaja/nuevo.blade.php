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

  <legend>Detalles</legend>
  <div class="row">
      <div class="col-sm-6">
        <label for="nombreContactoEmergencia" class="control-label">Nombre contacto de emergencia</label>
        <input id="nombreContactoEmergencia" value="{{$query->nombreContactoEmergencia}}" class="form-control" placeholder="Nombres" name="nombreContactoEmergencia" type="text" readonly>                            
      </div>
      <div class="col-sm-4">
        <label for="telefonoContactoEmergencia" class="control-label">Teléfono</label>
        <input id="telefonoContactoEmergencia" value="{{$query->telefonoContactoEmergencia}}" class="form-control" placeholder="Teléfono" name="telefonoContactoEmergencia" type="tel" readonly>                            
      </div>
  </div>
  <br>

  
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
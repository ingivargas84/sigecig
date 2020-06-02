@extends('admin.layoutadmin')

@section('content')

<h1>Administración</h1>

<div class="col-lg-3 col-xs-6">
    <div class="small-box bg-blue">
      <div class="inner">
        <h3>1</h3>

        <p>Registro de Llamadas</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-telephone"></i>
      </div>
        <a href="{{route('llamada.new')}}" class="small-box-footer">
          Mas info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-3 col-xs-6">
  <div class="small-box bg-green">
      <div class="inner">
        <h3>2</h3>

        <p>Directorio de Colaboradores</p>
      </div>
      <div class="icon">
        <i class="ion ion-chatbubbles"></i>
      </div>
      <a href="{{route('colaborador.index')}}" class="small-box-footer">
        Mas info <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

@role("Super-Administrador|Administrador|Caja")
<div class="col-lg-3 col-xs-6">
  <div class="small-box bg-orange">
      <div class="inner">
        <h3>3</h3>

        <p>Creacion de Recibo</p>
      </div>
      <div class="icon">
        <i class="ion ion-ios-cart"></i>
      </div>
      <a href="{{route('creacionRecibo.index')}}" class="small-box-footer">
        Mas info <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>
@endrole

@stop

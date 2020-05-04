@extends('gerencia.layoutgerencia')

@section('content')

<h1>Dashboard Principal</h1>
<div class="col-lg-3 col-xs-6">
    <div class="small-box bg-red">
      <div class="inner">
        <h3>3</h3>

        <p>Usuarios Registrados</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
        <a href="#" class="small-box-footer">
          Mas info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-3 col-xs-6">
    <div class="small-box bg-green">
      <div class="inner">
        <h3>3</h3>

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

@stop
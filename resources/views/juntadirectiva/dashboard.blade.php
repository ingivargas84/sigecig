@extends('juntadirectiva.layoutjuntadirectiva')

@section('content')

<h1>Junta Directiva</h1>
<div class="col-lg-3 col-xs-6">
  <div class="small-box bg-blue">
      <div class="inner">
        <h3>1</h3>

        <p>Listado de Actas</p>
      </div>
      <div class="icon">
        <i class="ion ion-android-archive"></i>
      </div>
        <a href="{{route('acta.index')}}" class="small-box-footer">
          Mas info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
    
  </div>

@stop
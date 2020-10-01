@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
        <center>Adjuntar Resolución Firmada</center>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard') }}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
        <li><a href="{{ route('resolucion.index') }}"><i class="fa fa-list"></i> Resolución</a></li>
        <li><a href="{{ route('bitacora.index',$id->id) }}"><i class="fa fa-list"></i> Bitacora</a></li>
        <li class="active">Firma-Resolución</li>
    </ol>
</section>
@section('content')
<div class="col-md-12">

    <div class="col2"> </div>

    <div class=" ">
        <div class="col " style="text-align: center">
            <a href="/pdf/{{$id->id}}" target="_blank"><img src="/images/descargar.jpg"
                    id="descargar" height="50" alt=""> Descargar resolucion para firmar</a>
        </div>
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('ap.guardar-resolucion',$id) }}"
                    enctype="multipart/form-data" id="miFormulario">
                    {{ csrf_field() }}
                    <div class="form-group " style="margin-bottom: 50px">
                        <div class=" row">
                            <div class="tx col-lg-8 col-md-8 col-sm-7">Añadir resolución, firmada, en formato PDF</div>
                            <div class="col-lg-4 col-md-4 col-sm-5">
                                <div class="mr " id="div_file">
                                    <p id="texto"><img src="/tracking/STEP2.png" height="20" class="desc"
                                            style="margin-right: 15px"> Añadir archivo</p>
                                    <input name="solicitud" id="solicitud" type="file" class=""
                                        onchange="return validarSolciditud()"><br />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" id='msj1' style="margin-bottom: 10px"></div>
                        <div class="progress">
                            <div class="bar"></div>
                            <div class="percent">0%</div>
                        </div>
                    </div>
                    <br>
                    <div style="text-align: center">
                        <button type="submit" id="ejecutar" class=" button btn-primary" style=" border-radius: 5px; height: 30px;">Guardar Cambios</button>
                        <div class="loader loader-bar is-active" style="display: none"></div>
                    </div> <br> <br> <br> <br>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
@endpush
@push('scripts')
<script src="{{ asset('js/jquery.form.js') }}"></script>
<script src="{{ asset('js/auxilio-postumo/firma-resolucion.js') }}"></script>
    @endpush
@stop

@extends('admin.layoutadmin')

@section('header')


@section('content')
<div class="box-header">
</div><br><br>
<div class="container">
    <div class=" col-lg-10 col2 col-md-offset-1 col-sm-offset-1 col-xs-offset-0 col-md-10 col-sm-10 col-xs-12 ">
      <div class=""> DOCUMENTOS AUXILIO PÓSTUMO </div>
    </div>
  </div>
    <div class="container col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
      <div class="col " style="text-align: center">
        <a href="/auxilioPostumo/{{$id}}/print"  target="_blank"><img src="/images/descargar.jpg" id="descargar" height="50"  alt=""> Descargar solicitud para firmar</a>
      </div>
        <div class="card">
          <div class="card-body">
          <form method="POST" action="{{ route('guardarDocumentosAp',$id)}}" enctype="multipart/form-data" id="miFormulario">
                    {{ csrf_field() }}
                    <div class="form-group " style="margin-bottom: 50px">
                        <div class=" row">
                        <div class="tx col-lg-8 col-md-8 col-sm-8">Añadir solicitud de anticipo, firmada, en formato</div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="mr " id="div_file">                       
                          <p id="texto"><img src="/tracking/STEP2.png" height="20" class="desc" style="margin-right: 15px"> Añadir archivo</p>
                          <input name="solicitud" id="solicitud" type="file"  class="" onchange="return validarSolciditud()" ><br/>
                        </div>
                      </div>
                      </div>
                      <div class="col-lg-12" id='msj1' style="margin-bottom: 10px"></div>
                        <div class="progress">
                            <div class="bar"></div >
                            <div class="percent">0%</div >
                        </div>
                    </div>
                    <div class="form-group ">
                      <div class="row">
                      <div class="tx col-lg-8 col-md-8 col-sm-8" >Copia de DPI ambos lados en formato PDF</div>
                      <div class="col-lg-4 col-md-4 col-sm-4">
                      <div class="mr" id="div_file">
                      <p id="texto"><img src="/tracking/STEP2.png" height="20" class="desc" style="margin-right: 15px">Añadir archivo</p>
                      <input name="dpi" id="dpi" type="file" class=" bt" onchange="return validarDpi()" ><br/>
                       </div>
                      </div>
                      </div>
                      <div class="col-lg-12" id='msj2' style="margin-bottom: 10px"></div>
                      <div class="progress">
                          <div class="bar"></div >
                          <div class="percent">0%</div >
                      </div>
                  </div>
                  <br>
                    <div style="text-align: center">
                      <button  type="submit" id="ejecutar" class=" button btn-primary" >Guardar Cambios</button>
                      <div class="loader loader-bar is-active" style="display: none"></div>
                    </div> <br>  <br>  <br> <br>
                </form> 
          </div>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script src="{{asset('js/resolucion/documentos.js')}}"></script>
@endsection
@push('styles')
<link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
@endpush
@push('scripts')
@endpush
@stop
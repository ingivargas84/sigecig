@extends('admin.layoutadmin')

@section('content')

<h2 class="text-center">Bienvenidos al Sistema Integral de Gestión del Colegio de Ingenieros de Guatemala</h2>
<div class="row text-center">
  <img class="fluid" width="150px" height="37px" src="/images/sigecig-logo.png">
</div>
<br><br>
<h1 class="text-center">Menú Principal</h1>

<br><br>

<div class="row centra_vertical" id="buttons1">
    <div class="col-md-2 col-sm-6 text-center mt-2 mb-2" >
        <div class="button_menu" id="btgerencia">
            <a href="/gerencia">
                <img class="fluid" width="150px" height="150px" src="/images/gerencia.png">
                <h4>Gerencia</h4>
            </a>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 text-center mt-2 mb-2">
        <div class="button_menu" id="btjuntadirectiva">
            <a href="/juntadirectiva">
                <img class="fluid" width="150px" height="150px" src="/images/juntadirectiva.png">
                <h4>Junta Directiva</h4>
            </a>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 text-center mt-2 mb-2">
        <div class="button_menu" id="btadministracion">
            <a href="/administracion">
                <img class="fluid" width="150px" height="150px" src="/images/administracion.png">
                <h4>Administración</h4>
            </a>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 text-center mt-2 mb-2">
        <div class="button_menu" id="btcontabilidad">
            <a href="/contabilidad">
                <img class="fluid" width="150px" height="150px" src="/images/contabilidad.png">
                <h4>Contabilidad</h4>
            </a>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 text-center mt-2 mb-2">
        <div class="button_menu" id="btinformatica">
            <a href="/informatica">
                <img class="fluid" width="150px" height="150px" src="/images/informatica.png">
                <h4>Informática</h4>
            </a>
        </div>
    </div>
</div>

<br><br><br>

<div class="row centra_vertical mt-5" id="buttons2">
    <div class="col-md-2 col-sm-6 text-center mt-2 mb-2" >
        <div class="button_menu" id="btceduca">
            <a href="/ceduca">
                <img class="fluid" width="150px" height="150px" src="/images/ceduca.png">
                <h4>Ceduca</h4>
            </a>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 text-center mt-2 mb-2">
        <div class="button_menu" id="btnuevoscolegiados">
            <a href="/nuevoscolegiados">
                <img class="fluid" width="150px" height="150px" src="/images/nuevoscolegiados.png">
                <h4>Nuevos Colegiados</h4>
            </a>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 text-center mt-2 mb-2">
        <div class="button_menu" id="bttimbreingenieria">
            <a href="/timbreingenieria">
                <img class="fluid" width="150px" height="150px" src="/images/timbreingenieria.png">
                <h4>Timbre Ingeniería</h4>
            </a>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 text-center mt-2 mb-2">
        <div class="button_menu" id="btcomisiones">
            <a href="/comisiones">
                <img class="fluid" width="150px" height="150px" src="/images/comisiones.png">
                <h4>Comisiones</h4>
            </a>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 text-center mt-2 mb-2">
        <div class="button_menu" id="btauditoria">
            <a href="/auditoria">
                <img class="fluid" width="150px" height="150px" src="/images/auditoria.png">
                <h4>Auditoria</h4>
            </a>
        </div>
    </div>
</div>

@stop
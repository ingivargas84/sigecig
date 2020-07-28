@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
      <script src="/ea/jquery.min.js"></script>

        <h1>
          Colegiados
          <small>Ingresar datos de nuevo colegiado </small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('colegiados.index')}}"><i class="fa fa-list"></i> Colegiados</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@endsection
@section('meta')

<script>
$(document).ready(function(){
//  $('#dpi').mask('0000 00000 0000', {reverse: true});
  $('#dpi').mask('AAAA AAAAA AAAA', {reverse: true});
    $("#mostrarDetalles").click(function(){
        $("#detalles").toggle();
    });
});
</script>

@endsection


@push('scripts')
<script src="{{asset('/ea/jquery-ui.min.js')}}"></script>
<script src="{{asset('/ea/jquery.mask.min.js')}}"></script>
{{-- <script src="{{asset('ea/jquery.auto-complete.js')}}"></script>
<script src="{{asset('/ea/jquery.auto-complete.min.js')}}"></script> --}}
<script src="{{asset('/ea/bootstrap.min.js')}}"></script>
<script src="{{asset('/ea/jquery.mask.min.js')}}"></script>

@endpush 

@section('content')
<form method="POST" id="colegiadosForm" action="{{route('colegiados.save')}}">
  {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <legend>Información Personal</legend>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="dpi">Dpi:</label>
                              <input id="dpi" onchange="cargarDatos()" autofocus="" placeholder="Dpi" class="form-control" name="dpi" type="text">                            
                            </div>
                            <div class="col-sm-4">
                              <label for="nombre">Nombres:</label>
                              <input id="nombres" class="form-control" placeholder="Nombres" name="nombres" type="text">                            
                            </div>
                            <div class="col-sm-4">
                              <label for="apellidos" class="control-label">Apellidos</label>
                              <input id="apellidos" class="form-control" placeholder="Apellidos" name="apellidos" type="text">                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                             <div class='col-sm-2'>
                              <label for="sexo">Sexo:</label>
                              <select class="form-control" id="sexo" name="sexo">
                                <option value="F">FEMENINO</option>
                                <option value="M">MASCULINO</option>
                              </select>                            
                              </div>
                              <div class="col-sm-2">
                                <label for="fechaNacimiento" class="control-label">Fecha Nac.</label>
                                <input id="fechaNacimiento" class="form-control" name="fechaNacimiento" type="date">                            
                              </div>
                              <div class='col-sm-4'>
                                <label for="valMunicipioNacimiento" class="control-label">Municipio Nac.</label>
                                <input id="valMunicipioNacimiento" list="countries" class="form-control ui-autocomplete-input" placeholder="Municipio" name="valMunicipioNacimiento" type="text" autocomplete="off">
                                <input type="hidden" id="idMunicipioNacimiento" name="idMunicipioNacimiento">
                              </div>
                              <div class='col-sm-4'>
                                <label for="valDepartamentoNacimiento" class="control-label">Depto. Nac.</label>
                                <input id="valDepartamentoNacimiento" class="form-control ui-autocomplete-input" placeholder="Departamento" name="valDepartamentoNacimiento" type="text" autocomplete="on">
                                <input type="hidden" id="idDepartamentoNacimiento" name="idDepartamentoNacimiento">
                              </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class='col-sm-4'>
                              <label for="valPais" class="control-label">País</label>
                              <input id="valPais" class="form-control ui-autocomplete-input" placeholder="País" name="valPais" type="text" autocomplete="on">
                              <input type="hidden" id="idPais" name="idPais">
                            </div>
                            <div class="col-sm-4">
                              <label for="valNacionalidad" class="control-label">Nacionalidad</label>
                              <input id="valNacionalidad" class="form-control ui-autocomplete-input" placeholder="Nacionalidad" name="valNacionalidad" type="text" autocomplete="off">
                              <input type="hidden" id="idNacionalidad" name="idNacionalidad">
                            </div>
                            <div class="col-sm-4">
                              <label for="telefono" class="control-label">Teléfono</label>
                              <input id="telefono" class="form-control" placeholder="Teléfono" name="telefono" type="text">                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="email" class="control-label">Correo electrónico</label>
                              <input id="email" class="form-control" placeholder="Correo electrónico" name="email" type="text">                            
                            </div>
                            <div class="col-sm-4">
                              <label for="estadoCivil" class="control-label">Estado civil</label>
                              <select onchange="mostrarConyugue();" id="estadoCivil" class="form-control" name="estadoCivil">
                                <option value="C">Casado(a)</option>
                                <option value="D">Divorciado(a)</option>
                                <option value="S" selected="selected">Soltero(a)</option>
                                <option value="U">Unido(a)</option>
                                <option value="V">Viudo(a)</option>
                              </select>                            
                            </div>
                            <div class="col-sm-4">
                              <label for="direccion" class="control-label">Dirección</label>
                              <input id="direccion" class="form-control" placeholder="Dirección" name="direccion" type="text">                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="zona" class="control-label">Zona</label>
                              <input id="zona" class="form-control" placeholder="Zona" name="zona" type="tel">                            
                            </div>
                            <div class="col-sm-4">
                              <label for="valMunicipio" class="control-label">Municipio Casa</label>
                              <input id="valMunicipio" list="countries" class="form-control ui-autocomplete-input" placeholder="Municipio" name="valMunicipio" type="text" autocomplete="off">
                              <input type="hidden" id="idMunicipio" name="idMunicipio">
                            </div>
                            <div class="col-sm-4">
                              <label for="destino" class="control-label">Destino correo</label>
                              <select class="form-control" id="destino" name="destino">
                                <option value="Casa">Casa</option>
                                <option value="Oficina">Oficina</option>
                                <option value="Otros">Otros</option>
                              </select>
                            </div>
                        </div>
                        <br>
                        <legend>Trabajo</legend>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="direccionTrabajo" class="control-label">Dirección Trabajo</label>
                              <input id="direccionTrabajo" class="form-control" placeholder="Dirección" name="direccionTrabajo" type="text">                            
                            </div>
                            <div class="col-sm-4">
                              <label for="zonaTrabajo" class="control-label">Zona</label>
                              <input id="zonaTrabajo" class="form-control" placeholder="Zona" name="zonaTrabajo" type="tel">                            
                            </div>
                            <div class="col-sm-4">
                              <label for="telTrabajo" class="control-label">Tel. Trabajo</label>
                              <input id="telTrabajo" class="form-control" placeholder="Teléfono" name="telTrabajo" type="tel">                            
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                              <label for="valMunicipioTrabajo" class="control-label">Municipio Trabajo</label>
                              <input id="valMunicipioTrabajo" list="countries" class="form-control ui-autocomplete-input" placeholder="Municipio" name="valMunicipioTrabajo" type="text" autocomplete="off">
                              <input type="hidden" id="idMunicipioTrabajo" name="idMunicipioTrabajo">
                            </div>
                            <div class="col-sm-4">
                              <label for="valDepartamentoTrabajo" class="control-label">Depto. Trab.</label>
                              <input id="valDepartamentoTrabajo" class="form-control ui-autocomplete-input" placeholder="Departamento" name="valDepartamentoTrabajo" type="text" autocomplete="off">
                              <input type="hidden" id="idDepartamentoTrabajo" name="idDepartamentoTrabajo">
                            </div>
                        </div>
                        <br>
                        <legend>Datos Académicos</legend>
                        <div class="row">
                            <div class="col-sm-2">
                              <label for="fechaGraduacion" class="control-label">Fecha Graduación</label>
                              <input id="fechaGraduacion" class="form-control" name="fechaGraduacion" type="date">
                            </div>
                            <div class="col-sm-5">
                              <label for="valUniversidadGraduado" class="control-label">Universidad Graduado</label>
                              <input id="valUniversidadGraduado" class="form-control ui-autocomplete-input" placeholder="Universidad" name="valUniversidadGraduado" type="text" autocomplete="off">
                              <input type="hidden" id="idUniversidadGraduado" name="idUniversidadGraduado">
                            </div>
                            <div class="col-sm-5">
                              <label> Carrera afin </label>   
                              <input id="ca" name="interests[]" type="checkbox" value="ca">     
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6">
                              <label for="valUniversidadIncorporado" class="control-label">Universidad incorporado</label>
                              <input id="valUniversidadIncorporado" class="form-control ui-autocomplete-input" placeholder="Universidad" name="valUniversidadIncorporado" type="text" autocomplete="off" value="Ninguna o Desconocida">
                              <input type="hidden" id="idUniversidadIncorporado" name="idUniversidadIncorporado">
                            </div>
                            <div class="col-sm-6">
                              <label for="tituloTesis" class="control-label">Título tesis</label>
                              <input id="tituloTesis" class="form-control" placeholder="Título de Tesis" name="tituloTesis" type="text">                            
                            </div>
                        </div>
                        <br>
                        <legend>Contacto de Emergencia</legend>
                        <div class="row">
                            <div class="col-sm-6">
                              <label for="nombreContactoEmergencia" class="control-label">Nombre contacto de emergencia</label>
                              <input id="nombreContactoEmergencia" required="" class="form-control" placeholder="Nombres" name="nombreContactoEmergencia" type="text">                            </div>
                            <div class="col-sm-4">
                              <label for="telefonoContactoEmergencia" class="control-label">Teléfono</label>
                              <input id="telefonoContactoEmergencia" required="" class="form-control" placeholder="Teléfono" name="telefonoContactoEmergencia" type="tel">                            </div>
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-danger form-button' href="{{ route('colegiados.index') }}">Regresar</a>
{{-- <button id="guardarAspirante" onclick="guardarAspiranteF()" class="form-button btn btn-success" type="button">Guardar Aspirante</button>
 --}}
 {{-- <button class="btn btn-primary form-button"  id="ButtonColegiado">Guardar</button> --}}
 <button id="guardarAspirante" onclick="guardarAspiranteF()" class="form-button btn btn-success" type="button">Guardar Aspirante</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    <div class="loader loader-bar"></div>

@endsection
@push('scripts')
<script src="{{asset('js/colegiados/aspirante.js')}}"></script>
@endpush

{{-- 
@push('scripts')

<script>
$(window).load(function(e) {
  $("#idusuario").val(location.hash);
    if($("#idusuario").val()) {
      getdatos();
    }
    $(".nombreEspecialidad").autocomplete({
      source: "General/busquedaEspecialidadAutocomplete",
      focus: function(event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox
        $(this).val(ui.item.label);
      },
      select: function(event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox and hidden field

        $(this).val(ui.item.label);
        $('#idespecialidad').val(ui.item.value);
        //$(this).nextAll('input').first().val(ui.item.value);
      }
    });

    $(".nombreProfesion").autocomplete({
      source: "General/busquedaProfesionAutocomplete",
      focus: function(event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox
        $(this).val(ui.item.label);
      },
      select: function(event, ui) {
        // prevent autocomplete from updating the textbox
        event.preventDefault();
        // manually update the textbox and hidden field

        $(this).val(ui.item.label);
        $('#idprofesion').val(ui.item.value);
        //$(this).nextAll('input').first().val(ui.item.value);
      }
    });
});

function cargarDatos() {
  getdatos();
  $(".colegiado").val($("#idusuario").val());
  if($('.nav-tabs .active').text() == "Pagos de colegio") {
    getPagosColegiado("02");
  } else if($('.nav-tabs .active').text() == "Pagos de timbre") {
    getPagosColegiado("01");
  }  else if($('.nav-tabs .active').text() == "Datos profesionales") {
    getDatosProfesionales("M");
    getDatosProfesionales("P");
  } else if($('.nav-tabs .active').text() == "Datos timbre y restricciones") {
    getDatosTimbre();
    getFechaTopeMensualidades();
  }


}

function getdatos() {
  $("#cleanButton").click();
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var idusuario = $("#dpi").cleanVal();
  var idusuarioF = $("#dpi").val();
	var invitacion = {
		'_token': tok._token,
		'idusuario': idusuario
	};
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "/Aspirante/getdatosaspirante",
		data: invitacion,
		success: function(data){
				var idusuario = $("#idusuario").val();
				limpiarFormulario();
				$("#mensajes").html("");
        $("#dpi").val(idusuarioF);
        $('#fotoColegiado').attr('src', '');
        $('#firmaColegiado').attr('src', '');
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#nombres").val(data.nombre);
						$("#apellidos").val(data.apellidos);
						$("#telefono").val(data.telefono);
						$("#email").val(data.correo);
						$("#fechaUltimoPagoColegio").val(data.fechaultimopagocolegio);
						$("#fechaUltimoPagoTimbre").val(data.fechaultimopagotimbre);
						$("#status").val(data.status);
            $("#fechaColegiado").val(data.fechacolegiado);
            $("#fallecido").val(data.fallecido);
            $("#idDepartamentoNacimiento").val(data.iddepartamentonacimiento);
						$("#valDepartamentoNacimiento").val(data.valdepartamentonacimiento);
						$("#idMunicipioNacimiento").val(data.idmunicipionacimiento);
						$("#valMunicipioNacimiento").val(data.valmunicipionacimiento);

            $("#direccion").val(data.direccionCasa);
						$("#direccionTrabajo").val(data.direccionTrabajo);
            $("#direccionOtro").val(data.direccionOtro);
						$("#idDepartamento").val(data.idDepartamentoCasa);
						$("#valDepartamento").val(data.valDepartamentoCasa);
						$("#idMunicipio").val(data.idMunicipioCasa);
						$("#valMunicipio").val(data.valMunicipioCasa);

            $("#conyugue").val(data.conyugue);
            $("#valPais").val(data.valPais);
            $("#idPais").val(data.idPaisNacimiento);
            $("#idNacionalidad").val(data.idnacionalidad);
            $("#valNacionalidad").val(data.valNacionalidad);



						$("#idDepartamentoTrabajo").val(data.idDepartamentoTrabajo);
						$("#valDepartamentoTrabajo").val(data.valDepartamentoTrabajo);
						$("#idMunicipioTrabajo").val(data.idMunicipioTrabajo);
						$("#valMunicipioTrabajo").val(data.valMunicipioTrabajo);

						$("#idDepartamentoOtro").val(data.idDepartamentoOtro);
						$("#valDepartamentoOtro").val(data.valDepartamentoOtro);
						$("#idMunicipioOtro").val(data.idMunicipioOtro);
						$("#valMunicipioOtro").val(data.valMunicipioOtro);
						$("#zona").val(data.zona);
						$("#zonaTrabajo").val(data.zonatrabajo);
						$("#zonaOtro").val(data.zonaotro);
						$("#nit").val(data.nit);
						$("#estadoJunta").val(data.estadojunta);
						$("#sexo").val(data.sexo);
						$("#estadoCivil").val(data.estadocivil);
						$("#destino").val(data.destinoCorreo);
						$("#codigoPostal").val(data.codigopostal);
						$("#telTrabajo").val(data.telefonoTrabajo);
						$("#lugarTrabajo").val(data.lugar);

						$("#fechaNacimiento").val(data.fechaNacimiento);
						$("#tipoSangre").val(data.tipoSangre);
						$("#maxConstancias").val(data.maxconstancias);
						$("#u_egresado").val(data.u_egresado);
            $("#telefonoContactoEmergencia").val(data.telefonoContactoEmergencia);
						$("#nombreContactoEmergencia").val(data.nombreContactoEmergencia);
            $("#pagaAuxilio").val(data.pagaauxilio);

            $("#fechaGraduacion").val(data.fechaGraduacion);
            $("#valUniversidadGraduado").val(data.valuniversidadgraduado);
            $("#idUniversidadGraduado").val(data.universidadGraduado);
            $("#valUniversidadIncorporado").val(data.valuniversidadincorporado);
            $("#idUniversidadIncorporado").val(data.universidadIncorporado);
            $("#creditos").val(data.creditos);
            $("#tituloTesis").val(data.tituloTesis);

            if($("#estadoCivil").val() == "C") {
              $('#conyugueDiv').fadeIn(100);
            }
            if(data.carrera_afin == "1") {
              $("#ca").prop("checked", true);
            } else {
              $("#ca").prop("checked", false);
            }


						if(data.status == "Activo") {
								$("#status").css({'color':'green'});
						} else {
								$("#status").css({'color':'red'});
						}
				}
				//alert(data.n_cliente);
		},
		error: function(response) {

      $('#fotoColegiado').attr('src', '');
      $('#firmaColegiado').attr('src', '');
				$("#cleanButton").click();
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function guardarAspiranteF() {
  $("#cleanButton").click();
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var idusuario = $("#dpi").cleanVal();
  var carrera_afin = 0;
  if($('#ca').is(":checked")) {
    carrera_afin = 1;
  }
	var datos = {
		'_token': tok._token,
    'idusuario': $("#dpi").cleanVal(),
    'nombres': $("#nombres").val(),
    'apellidos': $("#apellidos").val(),

    'sexo': $("#sexo").val(),
    'fechaNacimiento': $("#fechaNacimiento").val(),
    'idDepartamentoNacimiento': $("#idDepartamentoNacimiento").val(),
    'idMunicipioNacimiento': $("#idMunicipioNacimiento").val(),
    'idPaisNacimiento': $("#idPais").val(),
    'tipoSangre': $("#tipoSangre").val(),

    'idNacionalidad': $("#idNacionalidad").val(),
    'telefono': $("#telefono").val(),
    'telTrabajo': $("#telTrabajo").val(),
    'email': $("#email").val(),
    'nit': $("#nit").val(),
    'estadoCivil': $("#estadoCivil").val(),

    'conyugue': $("#conyugue").val(),

    'direccion': $("#direccion").val(),
    'zona': $("#zona").val(),
    'idDepartamentoCasa': $("#idDepartamento").val(),
    'idMunicipioCasa': $("#idMunicipio").val(),
    'codigoPostal': $("#codigoPostal").val(),

    'direccionTrabajo': $("#direccionTrabajo").val(),
    'zonaTrabajo': $("#zonaTrabajo").val(),
    'idDepartamentoTrabajo': $("#idDepartamentoTrabajo").val(),
    'idMunicipioTrabajo': $("#idMunicipioTrabajo").val(),
    'lugarTrabajo': $("#lugarTrabajo").val(),

    'direccionOtro': $("#direccionOtro").val(),
    'zonaOtro': $("#zonaOtro").val(),
    'idDepartamentoOtro': $("#idDepartamentoOtro").val(),
    'idMunicipioOtro': $("#idMunicipioOtro").val(),
    'destino': $("#destino").val(),

    'fechaGraduacion': $("#fechaGraduacion").val(),
    'idUniversidadGraduado': $("#idUniversidadGraduado").val(),
    'idUniversidadIncorporado': $("#idUniversidadIncorporado").val(),
    'creditos': $("#creditos").val(),

    'tituloTesis': $("#tituloTesis").val(),
    'telefonoContactoEmergencia': $("#telefonoContactoEmergencia").val(),
    'nombreContactoEmergencia': $("#nombreContactoEmergencia").val(), 
    'ca': carrera_afin
	};
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "/Aspirante/setdatosaspirante",
		data: datos,
		success: function(data){
				var idusuario = $("#idusuario").val();
				$("#cleanButton").click();
				$("#mensajes").html("");
				if(data.error==1){
          var html = "<ul>";
          $.each(data.infoError, function (index, item) {
            html += "<li>";
            $.each(item, function (index1, item1) {
              html += item1;
            });
            html += "</li>";
            //console.log(item);
            /*html += "<ul>" + item.question;
            $.each(item.answer, function (index1, item1) {
              html += "<li>" + item1 + "</li>";
            });
            html+="</ul>";*/
          });
          html += "</ul>";
						$("#mensajes").html(data.mensaje + html);
						$("#mensajes").css({'color':'red'});
				} else {
						$("#mensajes").html("Datos guardados correctamente.");
            $("#mensajes").css({'color':'green'});
				}
				//alert(data.n_cliente);
		},
		error: function(response) {

      $('#fotoColegiado').attr('src', '');
      $('#firmaColegiado').attr('src', '');
				$("#cleanButton").click();
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function limpiarFormulario() {
  $("#nombres").val('');
  $("#apellidos").val('');
  $("#telefono").val('');
  $("#email").val('');
  $("#fechaUltimoPagoColegio").val('');
  $("#fechaUltimoPagoTimbre").val('');
  $("#status").val('');
  $("#fechaColegiado").val('');
  $("#fallecido").val('N');
  $("#idDepartamentoNacimiento").val('');
  $("#valDepartamentoNacimiento").val('');
  $("#idMunicipioNacimiento").val('');
  $("#valMunicipioNacimiento").val('');
  $("#idNacionalidad").val('');
  $("#valNacionalidad").val('');

  $("#direccion").val('');
  $("#direccionTrabajo").val('');
  $("#idDepartamento").val('');
  $("#valDepartamento").val('');
  $("#idMunicipio").val('');
  $("#valMunicipio").val('');
  $("#conyugue").val('');
  $("#conyugueDiv").fadeOut(100);



  $("#idDepartamentoTrabajo").val('');
  $("#valDepartamentoTrabajo").val('');
  $("#idMunicipioTrabajo").val('');
  $("#valMunicipioTrabajo").val('');

  $("#idDepartamentoOtro").val('');
  $("#valDepartamentoOtro").val('');
  $("#idMunicipioOtro").val('');
  $("#valMunicipioOtro").val('');
  $("#zona").val('');
  $("#zonaTrabajo").val('');
  $("#zonaOtro").val('');
  $("#dpi").val('');
  $("#nit").val('');
  $("#estadoJunta").val('01');
  $("#sexo").val('');
  $("#estadoCivil").val('');
  $("#destino").val('');
  $("#codigoPostal").val('');
  $("#telTrabajo").val('');
  $("#lugarTrabajo").val('');
  $("#idPais").val('');
  $("#valPais").val('');
  $("#fechaNacimiento").val('');
  $("#tipoSangre").val('');
  $("#maxConstancias").val('');
  $("#u_egresado").val('');
  $("#telefonoContactoEmergencia").val('');
  $("#nombreContactoEmergencia").val('');

}

function getPagosColegiado(tipo) {
  if(tipo=='01') {
    div_a_cambiar = "pagosTimbreTabla";
  } else if(tipo == '02'){
    div_a_cambiar = "pagosColegioTabla";
  }
  $('#' + div_a_cambiar).empty();
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var invitacion = {
		'_token': tok._token,
		'colegiado': $("#idusuario").val(),
		'tipo': tipo
	};
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "Colegiado/getpagoscolegiado",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
			var i = 1;
			var texto = "<table width='100%' class='table-striped table-bordered table-hover'>";
			texto += "<thead>";
			texto += "<tr>";
			texto += "<th align='center'>";
			texto += "Fecha";
			texto += "</th>";
			texto += "<th align='center'>";
			texto += "Serie";
			texto += "</th>";
			texto += "<th align='center'>";
			texto += "Número";
			texto += "</th>";
			texto += "<th align='center'>";
			texto += "Pagado hasta";
			texto += "</th>";
			texto += "<th align='center'>";
			texto += "Descripcion";
			texto += "</th>";
      texto += "<th align='center'>";
			texto += "Total";
			texto += "</th>";
			texto += "</tr>";
			texto += "</thead>";
			texto += "<tbody>";
			for (dato in data) {
				texto += "<tr>";
				texto += "<td align='center'>"+data[dato].fecha + "</td>";
				texto += "<td align='center'>"+data[dato].serie + "</td>";
				texto += "<td align='center'>";
        texto += "<a href='/Facturacion/caja/" + data[dato].control +"' target='_blank'>"; 
        texto += data[dato].numerofactura;
        texto += "</a>"; 
        texto += "</td>";
				texto += "<td align='center'>"+data[dato].fechahasta + "</td>";
				texto += "<td align='center'>"+data[dato].descripcion + "</td>";
				texto += "<td align='right'>Q"+parseFloat(data[dato].total).toFixed(2) + "</td>";
				texto += "</tr>";
				i++;

			}
			texto += "</tbody>";
			texto += "</table>";
			var div_a_cambiar = "";
			if(tipo=='01') {
				div_a_cambiar = "pagosTimbreTabla";
			} else if(tipo == '02'){
				div_a_cambiar = "pagosColegioTabla";
			}
			//$('#' + div_a_cambiar).empty();
			$('#' + div_a_cambiar).append(
				texto
			);

				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#cleanButton").click();
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function getDatosProfesionales(tipo) {
  divACambiar="";
  titulo="Profesiones";
  if(tipo=="P") {
    divACambiar="#profesiones";
  } else if(tipo=="M") {
    divACambiar="#especialidades";
    titulo="Especialidades";
  }

  $(divACambiar).empty();

	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var datos = {
		'_token': tok._token,
		'idusuario': $("#dpi").cleanVal(),
    'tipo': tipo
	};
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "Aspirante/getDatosProfesionalesAspirante",
		xhrFields: {
				withCredentials: true
		},
		data: datos,
		success: function(data){
			var i = 1;
      titulo="Profesiones";
      var f = "2";
      if(tipo=="M") {
        titulo="Especialidades";
        f = "1";
      }
			var texto = "<table width='100%' class='table table-striped table-hover'>";
			texto += "<thead>";
			texto += "<tr>";
      texto += "<th align='center' style='width:15%'>";
			texto += "Código";
			texto += "</th>";
			texto += "<th align='center' style='width:70%'>";
			texto += titulo;
			texto += "</th>";
      texto += "<th align='center' style='width:15%'>";
			texto += "Eliminar";
			texto += "</th>";
			texto += "</tr>";
			texto += "</thead>";
			texto += "<tbody>";
			for (dato in data) {
				texto += "<tr>";
        texto += "<td align='center'>";
        var codigo = data[dato].c_profesion;
        var terminacion = data[dato].n_profesion;
        if(tipo=="M") {
          codigo = data[dato].c_especialidad;
          terminacion = data[dato].n_especialidad;
        }
        texto += '<input type="hidden" class="codigo1" name="codigo" disabled value="'+codigo+'" id="codigo1">';
        texto += '<input type="text" class="codigo form-control" disabled value="'+codigo+'">';
        texto += "</td>";
        texto += "<td align='center'>";
        var tituloSexo = data[dato].titulo_masculino;
        if($("#sexo").val() == 'F') {
          tituloSexo = data[dato].titulo_femenino;
        }

        texto += '<input type="text" class="titulo form-control" disabled value="'+ (tituloSexo ? tituloSexo : "") + ' ' + (terminacion ? terminacion : "")+'">';
        texto += "</td>";
        texto += "<td align='center'><button class='form-button btn btn-danger' onclick='eliminarPE(this, " + f + ")' type='button'>Eliminar</button></td>";
				texto += "</tr>";
				i++;
			}
			texto += "</tbody>";
			texto += "</table>";
      divACambiar="";
      if(tipo=="P") {
        divACambiar="#profesiones";
      } else if(tipo=="M") {
        divACambiar="#especialidades";
      }

			$(divACambiar).empty();
			$(divACambiar).append(texto);

				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#cleanButton").click();
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
  var target = $(e.target).attr("href");
  var tipo = "";
  if(target == '#pagosTimbre') {
    tipo = "01";
    getPagosColegiado(tipo);
  } else if(target == '#pagosColegio') {
    tipo = "02";
    getPagosColegiado(tipo);
  } else if(target == '#datosProfesionales') {
    getDatosProfesionales("M");
    getDatosProfesionales("P");
  } else if(target == '#datosTimbre') {
    getDatosTimbre();
    getFechaTopeMensualidades();
  }
});

$("#valUniversidadGraduado").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listauniversidades", { valUniversidad: $('#valUniversidadGraduado').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idUniversidadGraduado").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idUniversidadGraduado").val(ui.item.value);
	}
});

$("#valUniversidadIncorporado").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listauniversidades", { valUniversidad: $('#valUniversidadIncorporado').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idUniversidadIncorporado").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idUniversidadIncorporado").val(ui.item.value);
	}
});

$("#valMunicipio").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listamunicipios", { valMunicipio: $('#valMunicipio').val(), idDepartamento: $('#idDepartamento').val(), idPais: $('#idPais').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idMunicipio").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idMunicipio").val(ui.item.value);
		setDepartamentoPais();
	}
});

$("#valDepartamento").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listadepartamentos", { valDepartamento: $('#valDepartamento').val(), idPais: $('#idPais').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idDepartamento").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idDepartamento").val(ui.item.value);
		$("#valMunicipio").val("");
		$("#idMunicipio").val("");
	}
});

$("#valPais").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listapaises", { valPais: $('#valPais').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
		$("#idPais").val(ui.item ? ui.item.value : "");
	},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idPais").val(ui.item.value);
	}
});

$("#valNacionalidad").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listapaises", { valPais: $('#valPais').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
		$("#idPais").val(ui.item ? ui.item.value : "");
	},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idNacionalidad").val(ui.item.value);
	}
});

function setDepartamentoPais() {
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var idMunicipio = $("#idMunicipio").val();
	var invitacion = {
		'_token': tok._token,
		'idMunicipio': idMunicipio
	};
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "/General/departamentopais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valDepartamento").val(data.departamento);
						$("#idDepartamento").val(data.codigodepartamento);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#cleanButton").click();
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function setPaisDelMunicipio() {
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var idDepartamento = $("#idDepartamento").val();
	var invitacion = {
		'_token': tok._token,
		'idDepartamento': idDepartamento
	};
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "/General/pais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valMunicipio").val("");
						$("#idMunicipio").val("");
						$("#valPais").val(data.pais);
						$("#idPais").val(data.codigopais);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#cleanButton").click();
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}



$("#valMunicipioTrabajo").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listamunicipios", { valMunicipio: $('#valMunicipioTrabajo').val(), idDepartamento: $('#idDepartamentoTrabajo').val(), idPais: $('#idPaisTrabajo').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idMunicipioTrabajo").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idMunicipioTrabajo").val(ui.item.value);
		setDepartamentoPaisTrabajo();
	}
});

$("#valDepartamentoTrabajo").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listadepartamentos", { valDepartamento: $('#valDepartamentoTrabajo').val(), idPais: $('#idPaisTrabajo').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idDepartamentoTrabajo").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idDepartamentoTrabajo").val(ui.item.value);
		$("#valMunicipioTrabajo").val("");
		$("#idMunicipioTrabajo").val("");
	}
});

$("#valPaisTrabajo").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listapaises", { valPais: $('#valPaisTrabajo').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
		$("#idPaisTrabajo").val(ui.item ? ui.item.value : "");
	},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idPaisTrabajo").val(ui.item.value);
	}
});

function setDepartamentoPaisTrabajo() {
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var idMunicipio = $("#idMunicipioTrabajo").val();
	var invitacion = {
		'_token': tok._token,
		'idMunicipio': idMunicipio
	};
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "/General/departamentopais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valDepartamentoTrabajo").val(data.departamento);
						$("#idDepartamentoTrabajo").val(data.codigodepartamento);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#cleanButton").click();
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function setPaisDelMunicipioTrabajo() {
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var idDepartamento = $("#idDepartamentoTrabajo").val();
	var invitacion = {
		'_token': tok._token,
		'idDepartamento': idDepartamento
	};
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "/General/pais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valMunicipioTrabajo").val("");
						$("#idMunicipioTrabajo").val("");
						$("#valPaisTrabajo").val(data.pais);
						$("#idPaisTrabajo").val(data.codigopais);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#cleanButton").click();
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

//////////////////////////////////////
$("#valMunicipioOtro").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listamunicipios", { valMunicipio: $('#valMunicipioOtro').val(), idDepartamento: $('#idDepartamentoOtro').val(), idPais: $('#idPaisOtro').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idMunicipioOtro").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idMunicipioOtro").val(ui.item.value);
		setDepartamentoPaisOtro();
	}
});

$("#valDepartamentoOtro").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listadepartamentos", { valDepartamento: $('#valDepartamentoOtro').val(), idPais: $('#idPaisOtro').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idDepartamentoOtro").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idDepartamentoOtro").val(ui.item.value);
		$("#valMunicipioOtro").val("");
		$("#idMunicipioOtro").val("");
	}
});

$("#valPaisOtro").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listapaises", { valPais: $('#valPaisOtro').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
		$("#idPaisOtro").val(ui.item ? ui.item.value : "");
	},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idPaisOtro").val(ui.item.value);
	}
});

function setDepartamentoPaisOtro() {
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var idMunicipio = $("#idMunicipioOtro").val();
	var invitacion = {
		'_token': tok._token,
		'idMunicipio': idMunicipio
	};
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "/General/departamentopais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valDepartamentoOtro").val(data.departamento);
						$("#idDepartamentoOtro").val(data.codigodepartamento);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function setPaisDelMunicipioOtro() {
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var idDepartamento = $("#idDepartamentoOtro").val();
	var invitacion = {
		'_token': tok._token,
		'idDepartamento': idDepartamento
	};
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "/General/pais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valMunicipioOtro").val("");
						$("#idMunicipioOtro").val("");
						$("#valPaisOtro").val(data.pais);
						$("#idPaisOtro").val(data.codigopais);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}
/////////////////////////
$("#valMunicipioNacimiento").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listamunicipios", { valMunicipio: $('#valMunicipioNacimiento').val(), idDepartamento: $('#idDepartamentoNacimiento').val(), idPais: $('#idPaisNacimiento').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idMunicipioNacimiento").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idMunicipioNacimiento").val(ui.item.value);
		setDepartamentoPaisNacimiento();
	}
});

$("#valDepartamentoNacimiento").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listadepartamentos", { valDepartamento: $('#valDepartamentoNacimiento').val(), idPais: $('#idPaisNacimiento').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
            $("#idDepartamentoOtro").val(ui.item ? ui.item.value : "");
					},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idDepartamentoNacimiento").val(ui.item.value);
		$("#valMunicipioNacimiento").val("");
		$("#idMunicipioNacimiento").val("");
	}
});

$("#valPaisNacimiento").autocomplete({
	source: function(request, response) {
    $.getJSON("/General/listapaises", { valPais: $('#valPaisNacimiento').val()},
              response);
  },
	focus: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
	},
	change: function(event, ui) {
		$("#idPaisNacimiento").val(ui.item ? ui.item.value : "");
	},
	select: function(event, ui) {
		event.preventDefault();
		$(this).val(ui.item.label);
		$("#idPaisNacimiento").val(ui.item.value);
	}
});

function setDepartamentoPaisNacimiento() {
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var idMunicipio = $("#idMunicipioNacimiento").val();
	var invitacion = {
		'_token': tok._token,
		'idMunicipio': idMunicipio
	};
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "/General/departamentopais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valDepartamentoNacimiento").val(data.departamento);
						$("#idDepartamentoNacimiento").val(data.codigodepartamento);
            $("#valPais").val(data.pais);
						$("#idPais").val(data.codigopais);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function setPaisDelMunicipioNacimiento() {
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var idDepartamento = $("#idDepartamentoNacimiento").val();
	var invitacion = {
		'_token': tok._token,
		'idDepartamento': idDepartamento
	};
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "/General/pais",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
				if(data.error==1){
						$("#mensajes").html("Ningún dato encontrado.");
						$("#mensajes").css({'color':'red'});
				} else {
						$("#valMunicipioNacimiento").val("");
						$("#idMunicipioNacimiento").val("");
						$("#valPaisNacimiento").val(data.pais);
						$("#idPaisNacimiento").val(data.codigopais);
				}
				//alert(data.n_cliente);
		},
		error: function(response) {
				$("#status").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}

function busqueda() {
	var popup;
	$("#mensajes").html("");
	popup = window.open("/Colegiado/busquedapornombre", "Popup", "width=600,height=500");
	popup.focus();
}


function actualizarPagosBanrural() {
  var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
  var invitacion = {
    '_token': tok._token,
    'colegiado': $("#idusuario").val()
  };
  $.ajax({
    type: "POST",
    dataType:'JSON',
    url: "Colegiado/actualizarpagosbanrural",
    xhrFields: {
        withCredentials: true
    },
    data: invitacion,
    success: function(data){
      $("#mensajes").html("Solicitud enviada a Banrural.");
      $("#mensajes").css({'color':'green'});
    },
    error: function(response) {
      $("#mensajes").html("Error al actualizar.");
      $("#mensajes").css({'color':'red'});
    }
  });
}
function guardarMontoTimbre()
{
  var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
  var invitacion = {
    '_token': tok._token,
    'idusuario': $("#dpi").cleanVal(),
    'montoTimbre': $("#montoTimbre").val(),
    'nombres': $("#nombres").val(),
    'apellidos': $("#apellidos").val(),

    'sexo': $("#sexo").val(),
    'fechaNacimiento': $("#fechaNacimiento").val(),
    'idDepartamentoNacimiento': $("#idDepartamentoNacimiento").val(),
    'idMunicipioNacimiento': $("#idMunicipioNacimiento").val(),
    'idPaisNacimiento': $("#idPais").val(),
    'tipoSangre': $("#tipoSangre").val(),

    'idNacionalidad': $("#idNacionalidad").val(),
    'telefono': $("#telefono").val(),
    'telTrabajo': $("#telTrabajo").val(),
    'email': $("#email").val(),
    'nit': $("#nit").val(),
    'estadoCivil': $("#estadoCivil").val(),

    'conyugue': $("#conyugue").val(),

    'direccion': $("#direccion").val(),
    'zona': $("#zona").val(),
    'idDepartamentoCasa': $("#idDepartamento").val(),
    'idMunicipioCasa': $("#idMunicipio").val(),
    'codigoPostal': $("#codigoPostal").val(),

    'direccionTrabajo': $("#direccionTrabajo").val(),
    'zonaTrabajo': $("#zonaTrabajo").val(),
    'idDepartamentoTrabajo': $("#idDepartamentoTrabajo").val(),
    'idMunicipioTrabajo': $("#idMunicipioTrabajo").val(),
    'lugarTrabajo': $("#lugarTrabajo").val(),

    'direccionOtro': $("#direccionOtro").val(),
    'zonaOtro': $("#zonaOtro").val(),
    'idDepartamentoOtro': $("#idDepartamentoOtro").val(),
    'idMunicipioOtro': $("#idMunicipioOtro").val(),
    'destino': $("#destino").val(),

    'fechaGraduacion': $("#fechaGraduacion").val(),
    'idUniversidadGraduado': $("#idUniversidadGraduado").val(),
    'idUniversidadIncorporado': $("#idUniversidadIncorporado").val(),
    'creditos': $("#creditos").val(),

    'tituloTesis': $("#tituloTesis").val(),
    'telefonoContactoEmergencia': $("#telefonoContactoEmergencia").val(),
    'nombreContactoEmergencia': $("#nombreContactoEmergencia").val()
  };
  $.ajax({
    type: "POST",
    dataType:'JSON',
    url: "Aspirante/guardarMontoTimbreAspirante",
    data: invitacion,
    success: function(data){
      if(data.error==1){
        $("#mensajes").html("Ningún dato encontrado.");
        $("#mensajes").css({'color':'red'});
      } else {
        $("#mensajes").html("Datos guardados correctamente.");
        $("#mensajes").css({'color':'green'});
      }
    },
    error: function(response) {
      $("#mensajes").html("Error en el sistema.");
    }
  });
}

      function getDatosTimbre() {
        $("#montoTimbre").val("");
                        var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
                        var invitacion = {
          '_token': tok._token,
                            'idusuario': $("#dpi").cleanVal()
                        };
                        $.ajax({
                            type: "POST",
                            dataType:'JSON',
                            url: "Aspirante/getMontoTimbreAspirante",
          xhrFields: {
                  withCredentials: true
            },
                            data: invitacion,
                            success: function(data){
                                    //$("#mensajes").html(data);
            if(data.error==1){
                                            $("#mensajes").html("Ningún dato encontrado.");
                                            $("#mensajes").css({'color':'red'});
                                    } else {
              $("#montoTimbre").val(data.montoTimbre);
            }
                                    //alert(data.n_cliente);
                            },
                            error: function(response) {
                                    $("#mensajes").html("Error en el sistema.");
                                    $("#mensajes").css({'color':'red'});
                            }
                        });
      }

      function getFechaTopeMensualidades() {
        $("#montoTimbre").val("");
                        var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
                        var invitacion = {
          '_token': tok._token,
                            'idusuario': $("#dpi").cleanVal()
                        };
                        $.ajax({
                            type: "POST",
                            dataType:'JSON',
                            url: "Aspirante/obtenerFechaTopeMensualidades",
          xhrFields: {
                  withCredentials: true
            },
                            data: invitacion,
                            success: function(data){
                                    //$("#mensajes").html(data);
            if(data.error==1){
                                            $("#mensajes").html("Ningún dato encontrado.");
                                            $("#mensajes").css({'color':'red'});
                                    } else {
                                      $("#fechaTopeMensualidades").val(data.topefechapagocuotas)
            }
                                    //alert(data.n_cliente);
                            },
                            error: function(response) {
                                    $("#mensajes").html("Error en el sistema.");
                                    $("#mensajes").css({'color':'red'});
                            }
                        });
      }

function agregarEspecialidadF() {
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var invitacion = {
		'_token': tok._token,
		'idespecialidad': $("#idespecialidad").val(),
    'idusuario': $("#dpi").cleanVal(),
    'nombres': $("#nombres").val(),
    'apellidos': $("#apellidos").val(),

    'sexo': $("#sexo").val(),
    'fechaNacimiento': $("#fechaNacimiento").val(),
    'idDepartamentoNacimiento': $("#idDepartamentoNacimiento").val(),
    'idMunicipioNacimiento': $("#idMunicipioNacimiento").val(),
    'idPaisNacimiento': $("#idPais").val(),
    'tipoSangre': $("#tipoSangre").val(),

    'idNacionalidad': $("#idNacionalidad").val(),
    'telefono': $("#telefono").val(),
    'telTrabajo': $("#telTrabajo").val(),
    'email': $("#email").val(),
    'nit': $("#nit").val(),
    'estadoCivil': $("#estadoCivil").val(),

    'conyugue': $("#conyugue").val(),

    'direccion': $("#direccion").val(),
    'zona': $("#zona").val(),
    'idDepartamentoCasa': $("#idDepartamento").val(),
    'idMunicipioCasa': $("#idMunicipio").val(),
    'codigoPostal': $("#codigoPostal").val(),

    'direccionTrabajo': $("#direccionTrabajo").val(),
    'zonaTrabajo': $("#zonaTrabajo").val(),
    'idDepartamentoTrabajo': $("#idDepartamentoTrabajo").val(),
    'idMunicipioTrabajo': $("#idMunicipioTrabajo").val(),
    'lugarTrabajo': $("#lugarTrabajo").val(),

    'direccionOtro': $("#direccionOtro").val(),
    'zonaOtro': $("#zonaOtro").val(),
    'idDepartamentoOtro': $("#idDepartamentoOtro").val(),
    'idMunicipioOtro': $("#idMunicipioOtro").val(),
    'destino': $("#destino").val(),

    'fechaGraduacion': $("#fechaGraduacion").val(),
    'idUniversidadGraduado': $("#idUniversidadGraduado").val(),
    'idUniversidadIncorporado': $("#idUniversidadIncorporado").val(),
    'creditos': $("#creditos").val(),

    'tituloTesis': $("#tituloTesis").val(),
    'telefonoContactoEmergencia': $("#telefonoContactoEmergencia").val(),
    'nombreContactoEmergencia': $("#nombreContactoEmergencia").val()
	};
  $("#mensajes").html("");
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "Aspirante/setDatosEspecialidadesAspirante",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
      if(data.retorno==0) {
        $("#mensajes").html("Especialidad guardada correctamente.");
        $("#mensajes").css({'color':'green'});
        getDatosProfesionales("M");
      } else if(data.retorno==1) {
        $("#mensajes").html("Especialidad ya presente.");
        $("#mensajes").css({'color':'red'});
      } else {
        var a = "Error en el sistema.";
        if(data.hasOwnProperty("mensaje")) {
          a += " " + data.mensaje;
        }
        $("#mensajes").html(a);
        $("#mensajes").css({'color':'red'});
      }
		},
		error: function(response) {
				$("#mensajes").html("Error en el sistema.");
        $("#mensajes").css({'color':'red'});
		}
	});
}
function agregarProfesionF() {
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var invitacion = {
		'_token': tok._token,
		'idprofesion': $("#idprofesion").val(),
    'idusuario': $("#dpi").cleanVal(),
    'nombres': $("#nombres").val(),
    'apellidos': $("#apellidos").val(),

    'sexo': $("#sexo").val(),
    'fechaNacimiento': $("#fechaNacimiento").val(),
    'idDepartamentoNacimiento': $("#idDepartamentoNacimiento").val(),
    'idMunicipioNacimiento': $("#idMunicipioNacimiento").val(),
    'idPaisNacimiento': $("#idPais").val(),
    'tipoSangre': $("#tipoSangre").val(),

    'idNacionalidad': $("#idNacionalidad").val(),
    'telefono': $("#telefono").val(),
    'telTrabajo': $("#telTrabajo").val(),
    'email': $("#email").val(),
    'nit': $("#nit").val(),
    'estadoCivil': $("#estadoCivil").val(),

    'conyugue': $("#conyugue").val(),

    'direccion': $("#direccion").val(),
    'zona': $("#zona").val(),
    'idDepartamentoCasa': $("#idDepartamento").val(),
    'idMunicipioCasa': $("#idMunicipio").val(),
    'codigoPostal': $("#codigoPostal").val(),

    'direccionTrabajo': $("#direccionTrabajo").val(),
    'zonaTrabajo': $("#zonaTrabajo").val(),
    'idDepartamentoTrabajo': $("#idDepartamentoTrabajo").val(),
    'idMunicipioTrabajo': $("#idMunicipioTrabajo").val(),
    'lugarTrabajo': $("#lugarTrabajo").val(),

    'direccionOtro': $("#direccionOtro").val(),
    'zonaOtro': $("#zonaOtro").val(),
    'idDepartamentoOtro': $("#idDepartamentoOtro").val(),
    'idMunicipioOtro': $("#idMunicipioOtro").val(),
    'destino': $("#destino").val(),

    'fechaGraduacion': $("#fechaGraduacion").val(),
    'idUniversidadGraduado': $("#idUniversidadGraduado").val(),
    'idUniversidadIncorporado': $("#idUniversidadIncorporado").val(),
    'creditos': $("#creditos").val(),

    'tituloTesis': $("#tituloTesis").val(),
    'telefonoContactoEmergencia': $("#telefonoContactoEmergencia").val(),
    'nombreContactoEmergencia': $("#nombreContactoEmergencia").val()
	};
  $("#mensajes").html("");
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "Aspirante/setDatosProfesionalesAspirante",
		xhrFields: {
				withCredentials: true
		},
		data: invitacion,
		success: function(data){
      if(data.retorno==0) {
        $("#mensajes").html("Profesión guardada correctamente.");
        $("#mensajes").css({'color':'green'});
        getDatosProfesionales("P");
      } else if(data.retorno==1) {
        $("#mensajes").html("Especialidad ya presente.");
        $("#mensajes").css({'color':'red'});
      } else {
        var a = "Error en el sistema.";
        if(data.hasOwnProperty("mensaje")) {
          a += " " + data.mensaje;
        }
        $("#mensajes").html(a);
        $("#mensajes").css({'color':'red'});
      }
		},
		error: function(response) {
				$("#mensajes").html("Error en el sistema.");
        $("#mensajes").css({'color':'red'});
		}
	});
}
$("#serieReciboColegio").bind('keyup', function (e) {
    if (e.which >= 97 && e.which <= 122) {
        var newKey = e.which - 32;
        e.keyCode = newKey;
        e.charCode = newKey;
    }

    $("#serieReciboColegio").val(($("#serieReciboColegio").val()).toUpperCase());
});
$("#serieReciboTimbre").bind('keyup', function (e) {
    if (e.which >= 97 && e.which <= 122) {
        var newKey = e.which - 32;
        e.keyCode = newKey;
        e.charCode = newKey;
    }

    $("#serieReciboTimbre").val(($("#serieReciboTimbre").val()).toUpperCase());
});

function asociarRecibo(tipo) {
  var serie = "";
  var numeroFactura = "";
  var nombreTipo = "";
  if(tipo=="01") {
    serie = $("#serieReciboTimbre").val();
    numeroFactura = $("#numeroReciboTimbre").val();
    nombreTipo="Timbre";
  } else if (tipo == "02") {
    serie = $("#serieReciboColegio").val();
    numeroFactura = $("#numeroReciboColegio").val();
    nombreTipo="Colegio";
  }
  if (confirm("Confirma que desea asociar el recibo " + serie + " - " + numeroFactura + " de " + nombreTipo + " al colegiado " + $("#idusuario").val())   == false) {
		return;
	}
  alert("morir");
  return;
	var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
	var serie = "";
  var numeroFactura = "";
  if(tipo=="01") {
    serie = $("#serieReciboTimbre").val();
    numeroFactura = $("#numeroReciboTimbre").val();
  } else if (tipo == "02") {
    serie = $("#serieReciboColegio").val();
    numeroFactura = $("#numeroReciboColegio").val();
  }
	var datos = {
		'_token': tok._token,
		'serie': serie,
		'numeroFactura': numeroFactura,
    'tipo': tipo,
    'colegiado': $("#idusuario").val()
	};
  $("#mensajes").html("");
	$.ajax({
		type: "POST",
		dataType:'JSON',
		url: "Facturacion/asociarRecibo",
		xhrFields: {
				withCredentials: true
		},
		data: datos,
		success: function(data){
        if(data.retorno==0) {
          $("#mensajes").html("Recibo asociado correctamente.");
          $("#mensajes").css({'color':'green'});
          getPagosColegiado(tipo);
        } else {
          var a = "Error al asociar recibo. Verifique datos.";
          if(data.hasOwnProperty("mensaje")) {
            a += " " + data.mensaje;
          }
          $("#mensajes").html(a);
          $("#mensajes").css({'color':'red'});
        }
		},
		error: function(response) {
				$("#cleanButton").click();
				$("#mensajes").css({'color':'red'});
				$("#mensajes").html("Error en el sistema.");
		}
	});
}
function generarKardex(tipoV){
    $.post("Colegiado/generarKardex",{colegiado:$("#idusuario").val(), tipo: tipoV}, function(data, status){

    });
}
function guardarFechaTopeMensualidades()
{
                  var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
                  var invitacion = {
                      '_token': tok._token,
                      'idusuario': $("#dpi").cleanVal(),
                      'fechaTopeMensualidades': $("#fechaTopeMensualidades").val(),
                      'nombres': $("#nombres").val(),
                      'apellidos': $("#apellidos").val(),

                      'sexo': $("#sexo").val(),
                      'fechaNacimiento': $("#fechaNacimiento").val(),
                      'idDepartamentoNacimiento': $("#idDepartamentoNacimiento").val(),
                      'idMunicipioNacimiento': $("#idMunicipioNacimiento").val(),
                      'idPaisNacimiento': $("#idPais").val(),
                      'tipoSangre': $("#tipoSangre").val(),

                      'idNacionalidad': $("#idNacionalidad").val(),
                      'telefono': $("#telefono").val(),
                      'telTrabajo': $("#telTrabajo").val(),
                      'email': $("#email").val(),
                      'nit': $("#nit").val(),
                      'estadoCivil': $("#estadoCivil").val(),

                      'conyugue': $("#conyugue").val(),

                      'direccion': $("#direccion").val(),
                      'zona': $("#zona").val(),
                      'idDepartamentoCasa': $("#idDepartamento").val(),
                      'idMunicipioCasa': $("#idMunicipio").val(),
                      'codigoPostal': $("#codigoPostal").val(),

                      'direccionTrabajo': $("#direccionTrabajo").val(),
                      'zonaTrabajo': $("#zonaTrabajo").val(),
                      'idDepartamentoTrabajo': $("#idDepartamentoTrabajo").val(),
                      'idMunicipioTrabajo': $("#idMunicipioTrabajo").val(),
                      'lugarTrabajo': $("#lugarTrabajo").val(),

                      'direccionOtro': $("#direccionOtro").val(),
                      'zonaOtro': $("#zonaOtro").val(),
                      'idDepartamentoOtro': $("#idDepartamentoOtro").val(),
                      'idMunicipioOtro': $("#idMunicipioOtro").val(),
                      'destino': $("#destino").val(),

                      'fechaGraduacion': $("#fechaGraduacion").val(),
                      'idUniversidadGraduado': $("#idUniversidadGraduado").val(),
                      'idUniversidadIncorporado': $("#idUniversidadIncorporado").val(),
                      'creditos': $("#creditos").val(),

                      'tituloTesis': $("#tituloTesis").val(),
                      'telefonoContactoEmergencia': $("#telefonoContactoEmergencia").val(),
                      'nombreContactoEmergencia': $("#nombreContactoEmergencia").val()
                  };
                  $.ajax({
                      type: "POST",
                      dataType:'JSON',
                      url: "Aspirante/guardarFechaTopeMensualidades",
                      data: invitacion,
                      success: function(data){
                              if(data.error==1){
                                      $("#mensajes").html("Error al guardar.");
                                      $("#mensajes").css({'color':'red'});
                              } else {
        $("#mensajes").html("Datos guardados correctamente.");
        $("#mensajes").css({'color':'green'});
                              }
                      },
                      error: function(response) {
                              $("#mensajes").html("Error en el sistema.");
                      }
                  });
}

function asociarColegiado() {
  var tok = {!! json_encode(array('_token'=> csrf_token())) !!};
  var invitacion = {
      '_token': tok._token,
      'idusuario': $("#dpi").cleanVal(),
      'colegiado': $("#colegiado").val(),
      'fechaColegiado': $("#fechaColegiado").val(),
      'fechaUltimoPagoColegio': $("#fechaUltimoPagoColegio").val(),
      'fechaUltimoPagoTimbre': $("#fechaUltimoPagoTimbre").val(),
      'observaciones': $("#observaciones").val(),
      'memo': $("#memo").val(),
      'password': $("#password").val(),
  };
  $("#password").val('');
  $.ajax({
    type: "POST",
    dataType:'JSON',
    url: "Aspirante/asociarColegiado",
    data: invitacion,
    success: function(data){
      if(data.error==0){
        $("#mensajes").html("Colegiado asociado correctamente.");
        $("#mensajes").css({'color':'green'});

      } else if(data.error==2){
        $("#mensajes").html("Error de autenticación.");
        $("#mensajes").css({'color':'red'});

      } else if(data.error==3){
        $("#mensajes").html("Colegiado ya existente.");
        $("#mensajes").css({'color':'red'});

      } else {
        $("#mensajes").html("Error al guardar.");
        $("#mensajes").css({'color':'red'});
      }
    },
    error: function(response) {
      $("#mensajes").html("Error en el sistema.");
    }
  });
}

function mostrarConyugue() {
  if($('#estadoCivil').val() == 'C') {
    $('#conyugueDiv').fadeIn(100);
  } else {
    $('#conyugueDiv').fadeOut(100);
  }
}
</script>
@endpush --}}
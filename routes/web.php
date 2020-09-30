<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'middleware'=>['auth','estado'] ],
    function(){

        // Pantalla Principal y General
        Route::get('/admin','HomeController@index')->name('dashboard');

        // Módulo Informática
        Route::get('user/getJson' , 'UsersController@getJson' )->name('users.getJson');
        Route::get('users' , 'UsersController@index' )->name('users.index');
        Route::post('users' , 'UsersController@store' )->name('users.store');
        Route::delete('users/{user}' , 'UsersController@destroy' );
        Route::post('users/update/{user}' , 'UsersController@update' );
        Route::get('users/{user}/edit', 'UsersController@edit' );
        Route::post('users/reset/tercero' , 'UsersController@resetPasswordTercero')->name('users.reset.tercero');
        Route::post('users/reset' , 'UsersController@resetPassword')->name('users.reset');
        Route::get( '/users/cargar' , 'UsersController@cargarSelect')->name('users.cargar');
        Route::get( '/users/cargarA' , 'UsersController@cargarSelectApertura')->name('users.cargarA');

        Route::get( '/negocio/{negocio}/edit' , 'NegocioController@edit')->name('negocio.edit');
        Route::put( '/negocio/{negocio}/update' , 'NegocioController@update')->name('negocio.update');


        // Módulo Contabilidad Y JefeContabilidad
      //  Route::get('/contabilidad', 'ContabilidadController@index')->name('contabilidad.index');
       // Route::get('/contabilidad/getJson/', 'ContabilidadController@getJson')->name('contabilidad.getJson');


        // Módulo Contabilidad
        Route::get( '/proveedores' , 'ProveedoresController@index')->name('proveedores.index');
        Route::get( '/proveedores/getJson/' , 'ProveedoresController@getJson')->name('proveedores.getJson');
        Route::get( '/proveedores/new' , 'ProveedoresController@create')->name('proveedores.new');
        Route::get( '/proveedores/edit/{proveedor}' , 'ProveedoresController@edit')->name('proveedores.edit');
        Route::put( '/proveedores/{proveedor}/update' , 'ProveedoresController@update')->name('proveedores.update');
        Route::post( '/proveedores/save/' , 'ProveedoresController@store')->name('proveedores.save');
        Route::post('/proveedores/{proveedor}/delete' , 'ProveedoresController@destroy');
        Route::post('/proveedores/{proveedor}/activar' , 'ProveedoresController@activar');
        Route::get('/proveedores/nitDisponible/', 'ProveedoresController@nitDisponible')->name('proveedores.nitDisponible');

        Route::get( '/corte' , 'HomeController@corte_diario')->name('corte');


        // Módulo de Gerencia
        Route::get( '/solicitud' , 'SolicitudBoletaController@index')->name('solicitud.index');
        Route::get( '/solicitud/getJson/' , 'SolicitudBoletaController@getJson')->name('solicitud.getJson');
        Route::get( '/solicitud/new' , 'SolicitudBoletaController@create')->name('solicitud.new');
        Route::post( '/solicitud/save/' , 'SolicitudBoletaController@store')->name('solicitud.save');
        Route::get( '/solicitud/edit/{solBoleta}' , 'SolicitudBoletaController@edit')->name('solicitud.edit');
        Route::put( '/solicitud/{solBoleta}/update' , 'SolicitudBoletaController@update')->name('solicitud.update');
        Route::post('/solicitud/{solBoleta}/destroy' , 'SolicitudBoletaController@destroy')->name('solicitud.destroy');
        Route::post('/solicitud/{solBoleta}/delete' , 'SolicitudBoletaController@delete')->name('solicitud.delete');
        Route::post('/solicitud/{solBoleta}/activar' , 'SolicitudBoletaController@activar');

        Route::get( '/boleta', 'BoletaController@index')->name('boleta.index');
        Route::get( '/boleta/getJson/', 'BoletaController@getJson')->name('boleta.getJson');
        Route::get( '/boleta/new', 'BoletaController@create')->name('boleta.new');
        Route::post( '/boleta/save/', 'BoletaController@store')->name('boleta.save');
        Route::get( '/boleta/edit/{boleta}' , 'BoletaController@edit')->name('boleta.edit');
        Route::put( '/boleta/{boleta}/update' , 'BoletaController@update')->name('boleta.update');
        Route::post('/boleta/{boleta}/destroy' , 'BoletaController@destroy')->name('boleta.destroy');
        Route::post('/boleta/{boleta}/delete' , 'BoletaController@delete')->name('boleta.delete');
        Route::post('/boleta/{boleta}/activar' , 'BoletaController@activar');

        Route::get( '/llamada', 'InformeLlamadasController@index')->name('llamada.index');
        Route::get( '/llamada/getJson/', 'InformeLlamadasController@getJson')->name('llamada.getJson');
        Route::get( '/llamada/new', 'InformeLlamadasController@create')->name('llamada.new');
        Route::post( '/llamada/save/', 'InformeLlamadasController@store')->name('llamada.save');
        Route::get( '/llamada/edit/{informe}' , 'InformeLlamadasController@edit')->name('llamada.edit');
        Route::put( '/llamada/{informe}/update' , 'InformeLlamadasController@update')->name('llamada.update');
        Route::post('/llamada/{informe}/delete' , 'InformeLlamadasController@delete')->name('llamada.delete');
        Route::post('/llamada/{informe}/activar' , 'InformeLlamadasController@activar');

        // Módulo de Administracion
        Route::get('/colaborador', 'ColaboradorController@index')->name('colaborador.index');
        Route::get('/colaborador/getJson/', 'ColaboradorController@getJson')->name('colaborador.getJson');
        Route::get('/colaborador/new', 'ColaboradorController@create')->name('colaborador.new');
        Route::post('/colaborador/save/', 'ColaboradorController@store')->name('colaborador.save');
        Route::get('/colaborador/dpiDisponible/', 'ColaboradorController@dpiDisponible');
        Route::get('/colaborador/dpiDisponibleEdit/', 'ColaboradorController@dpiDisponibleEdit');
        Route::get('/colaborador/edit/{colaborador}', 'ColaboradorController@edit')->name('colaborador.edit');
        Route::put('/colaborador/{colaborador}/update', 'ColaboradorController@update')->name('colaborador.update');
        Route::post('/colaborador/{colaborador}/destroy', 'ColaboradorController@destroy')->name('colaborador.destroy');
        Route::get( '/iddepartamento/{value}', 'ColaboradorController@getMunicipio');
        Route::get( '/iddepartamentoEdit/{value}', 'ColaboradorController@getDepartamentoEdit');

       // Módulo de Registro de Cajas
       Route::get('/cajas', 'CajasController@index')->name('cajas.index');
       Route::get('/cajas/getJson/', 'CajasController@getJson')->name('cajas.getJson');
       Route::get('/cajas/new', 'CajasController@create')->name('cajas.new');
       Route::post('/cajas/save/', 'CajasController@store')->name('cajas.save');
       Route::get('/cajas/dpiDisponible/', 'CajasController@dpiDisponible');
       Route::get('/cajas/dpiDisponibleEdit/', 'CajasController@dpiEdit');
       Route::get('/cajas/edit/{cajas}', 'CajasController@edit')->name('cajas.edit');
       Route::post('/cajas/{cajas}/update', 'CajasController@update');
       Route::post('/cajas/{cajas}/destroy', 'CajasController@destroy')->name('cajas.destroy');
       Route::post('/cajas/{cajas}/activar', 'CajasController@activar')->name('cajas.activar');
       Route::get('/cajas/nombreDisponible/', 'CajasController@nombreDisponible');
       Route::get('/cajas/nombreDisponibleEdit/', 'CajasController@nombreDisponibleEdit');

        // Modulo de Junta Directiva
        Route::get('/acta', 'ActaMaestroController@index')->name('acta.index');
        Route::get('/acta/getJson/', 'ActaMaestroController@getJson')->name('acta.getJson');
        Route::get('/acta/new', 'ActaMaestroController@create')->name('acta.new');
        Route::post('/acta/save/', 'ActaMaestroController@store')->name('acta.save');
        Route::get('/acta/edit/{acta}', 'ActaMaestroController@edit')->name('acta.edit');
        Route::put('/acta/{acta}/update', 'ActaMaestroController@update')->name('acta.update');
        Route::post('/acta/{acta}/destroy', 'ActaMaestroController@destroy')->name('acta.destroy');

        // Módulo de ResolucionPago
        Route::get('/resolucion', 'ResolucionPagoController@index')->name('resolucion.index');
        Route::get('/resolucion/getJson/', 'ResolucionPagoController@getJson')->name('resolucion.getJson');
        Route::post('auxiliopostumo/{solicitud}/acta' , 'ResolucionPagoController@addActa' );
        Route::get('/resolucion/asap/{solicitud}', 'ResolucionPagoController@asap')->name('resolucion.asap');
        Route::post('/resolucion/asapsave/', 'ResolucionPagoController@storeasap')->name('asap.save');
        Route::get('auxiliopostumo/solicitudes_pendientes' , 'ResolucionPagoController@solicitudesPendientes');
        Route::get('pdf/{id}/',  'ResolucionPagoController@imprimir' )->name('pdf.imprimir');
        Route::post('/resolucion/{solicitud}/cambio', 'ResolucionPagoController@cambiarestado');
        Route::post('resolucion/{tipo}/fecha' , 'ResolucionPagoController@fechaconfig' );
        Route::post('resolucion/{solicitud}/finalizaestado', 'ResolucionPagoController@finalizarestado');

        //crear solicitud de auxilio postumo
        Route::get('/auxiliopostumo/crea_solicitud','AuxilioPostumoController@nuevaSolicitud');
        Route::get('/auxilioPostumo/{no_colegiado}/getDatosColegiado','AuxilioPostumoController@getDatosColegiado');
        Route::post('/auxilioPostumo/save','AuxilioPostumoController@GuardarSolicitudAp');
        Route::get('/auxilioPostumo/{id}/documentosap/','AuxilioPostumoController@DocumentosAp');
        Route::post('/auxilioPostumo/documentos/{id}','AuxilioPostumoController@guardarDocumentosAp')->name('guardarDocumentosAp');
        Route::get('auxilioPostumo/{id}/print','AuxilioPostumoController@imprimirSolicitud');
        Route::get('/auxiliopostumo/crearusuario','AuxilioPostumoController@crearUsuario')->name('crearUsuario.index');
        Route::get('/auxiliopostumo/save','HomeController@saveUsuario');
        Route::get('/auxiliopostumo/adjuntar-resolucion/{id}','AuxilioPostumoController@adjuntarResolucion')->name('ap.adjuntar-resolucion');
        Route::post('/auxilioPostumo/guardar-resolucion/{id}','AuxilioPostumoController@guardarResolucion')->name('ap.guardar-resolucion');




        //Módulo Reporte Finalizadas
        Route::get('reporte/',  'ResolucionPagoController@reporte_ap' )->name('reporteap.reporte_ap');


        // Módulo Bitacora
        Route::get('/resolucion/{id}/bitacora/', 'ResolucionPagoController@bitacora')->name('bitacora.index');
        Route::get('/resolucion/pdf_bitacora/{id}/', 'ResolucionPagoController@imprimirbitacora')->name('bitacora.pdfbitacora');
        //Módulo Auxilio Postumo-->Aprobacion de Documentos
        Route::post('/resolucion/aprdocumentosap','ResolucionPagoController@aprDocumentosAp')->name('doc.aprobacion');
        //envio de correo de aprobacion prueba
        Route::get('/resolucion/correo','ResolucionPagoController@correo');
        Route::post('/resolucion/rczdocumentosap','ResolucionPagoController@rczDocumentosAp')->name('doc.rechazado');

        //Módulo Auxilio Postumo-->Aprobacion o Rechazo por Junta
        Route::post('/resolucion/aprdocumentosjunta','ResolucionPagoController@aprDocumentosJunta')->name('doc.aprobacionJunta');
        Route::post('/resolucion/rczdocumentosjunta','ResolucionPagoController@rczDocumentosJunta')->name('doc.rechazadoJunta');

        //Modulo para mostrar documentos de Auxilio Postumo
        Route::get('/resolucion/solicitudap/{solicitud}','ResolucionPagoController@verSolicitudAp')->name('img.vie');
        Route::get('/resolucion/dpiap/{solicitud}','ResolucionPagoController@verDpiAp')->name('img.viedpi');


        // Modulo de Tipos de pago
        Route::get( '/tipoDePago' , 'TipoDePagoController@index')->name('tipoDePago.index');
        Route::get( '/tipoDePago/getJson/' , 'TipoDePagoController@getJson')->name('tipoDePago.getJson');
        Route::get( '/tipoDePago/new' , 'TipoDePagoController@create')->name('tipoDePago.new');
        Route::post( '/tipoDePago/save/' , 'TipoDePagoController@store')->name('tipoDePago.save');
        Route::post('tipoDePago' , 'TipoDePagoController@store' )->name('tipoDePago.store');
        Route::post('tipoDePago/{tipo}/update' , 'TipoDePagoController@update' );
        Route::get('tipoDePago/{tipo}/edit', 'TipoDePagoController@edit' );
        Route::post('/tipoDePago/{tipo}/destroy' , 'TipoDePagoController@destroy')->name('tipoDePago.destroy');
        Route::post('/tipoDePago/{tipo}/delete' , 'TipoDePagoController@delete')->name('tipoDePago.delete');
        Route::post('/tipoDePago/{tipo}/activar' , 'TipoDePagoController@activar');
        Route::get('/tipoDePago/nombreDisponible/', 'TipoDePagoController@nombreDisponible');
        Route::get('/tipoDePago/nombreDisponibleEdit/', 'TipoDePagoController@nombreDisponibleEdit');

        // Modulo de Sub Sedes
        Route::get( '/subsedes' , 'SubsedesController@index')->name('subsedes.index');
        Route::get( '/subsedes/getJson/' , 'SubsedesController@getJson')->name('subsedes.getJson');
        Route::get( '/subsedes/new' , 'SubsedesController@create')->name('subsedes.new');
        Route::post( '/subsedes/save/' , 'SubsedesController@store')->name('subsedes.save');
        Route::get( '/subsedes/edit/{su}' , 'SubsedesController@edit')->name('subsedes.edit');
        Route::put( '/subsedes/{su}/update' , 'SubsedesController@update')->name('subsedes.update');
        Route::post('/subsedes/{su}/destroy' , 'SubsedesController@destroy')->name('subsedes.destroy');
        Route::get('/subsedes/nombreDisponible/', 'SubsedesController@nombreDisponible');
        Route::get('/subsedes/nombreDisponibleEdit/', 'SubsedesController@nombreDisponibleEdit');
        Route::post('/subsedes/{su}/delete' , 'SubsedesController@delete')->name('subsedes.delete');
        Route::post('/subsedes/{su}/activar' , 'SubsedesController@activar');

        // Modulo de Creacion de Recibos
        Route::get( '/creacionRecibo' , 'ReciboController@index')->name('creacionRecibo.index');
        Route::get( '/colegiado/{colegiado}','ReciboController@getDatosColegiado');
        Route::get( '/empresa/{nit}','ReciboController@getDatosEmpresa');
        Route::get( '/tipo/ajax/A', 'ReciboController@SerieDePagoA');
        Route::get( '/tipo/ajax/B', 'ReciboController@SerieDePagoB');
        Route::get( '/tipo/ajax/aspirante', 'ReciboController@SerieDePagoAspirante');
        Route::get( '/tipoPagoColegiadoA/{tipo}', 'ReciboController@getTipoDePagoA');
        Route::get( '/tipoPagoColegiadoB/{tipo}', 'ReciboController@getTipoDePagoB');
        Route::post('/creacionRecibo/save', 'ReciboController@store')->name('guardarReciboColegiado.save');
        Route::post('/creacionRecibo/save/particular', 'ReciboController@store')->name('guardarReciboParticular.save');
        Route::post('/creacionRecibo/save/empresa', 'ReciboController@store')->name('guardarReciboEmpresa.save');
        Route::post('Facturacion/getMontoInteresColegio', 'ReciboController@getInteresColegio');
        Route::get('/creacionRecibo/pdf/{id}/', 'ReciboController@pdfRecibo')->name('creacionRecibo.pdfrecibo');
        Route::get('/estadocuenta/pdf/{id}/', 'ReciboController@estadoCuetapdfRecibo');
        Route::post('/consultaTimbres', 'ReciboController@consultaTimbres');
        Route::post('existenciaBodega', 'ReciboController@existenciaBodega');
        Route::post('getTimbresDePago', 'ReciboController@codigosTimbrePago');
        Route::get('/getAsporante/existenciaDpi/{valid}', 'ReciboController@existenciaDpi');

        // Modulo de Calculo de Reactivacion
        Route::get( '/reactivacion', 'ReciboController@getDatosReactivacion')->name('reactivacion.interes');
        Route::post('getMontoReactivacion', 'ReciboController@getMontoReactivacion');

        // Modulo de Bodegas
        Route::get( '/bodegas' , 'BodegasController@index')->name('bodegas.index');
        Route::get('/bodegas/getJson/', 'BodegasController@getJson')->name('bodegas.getJson');
        Route::get('/bodegas/new', 'BodegasController@create')->name('bodegas.new');
        Route::post('/bodegas/save/', 'BodegasController@store')->name('bodegas.save');
        Route::post('/bodegas/{bodegas}/update', 'BodegasController@update');
        Route::post('/bodegas/{bodegas}/destroy' , 'BodegasController@destroy')->name('bodegas.destroy');
        Route::get('/bodegas/nombreDisponible/', 'BodegasController@nombreDisponible');
        Route::get('/bodegas/nombreDisponibleEdit/', 'BodegasController@nombreDisponibleEdit');

        // Modulo de Colegiados
        Route::get( '/colegiados' , 'ColegiadosController@index')->name('colegiados.index');
        Route::get( '/aspirantes' , 'ColegiadosController@indexAsp')->name('aspirantes.index');
        Route::get('/colegiados/getJson/', 'ColegiadosController@getJson')->name('colegiados.getJson');
        Route::get('/aspirantes/getJsonAsp/', 'ColegiadosController@getJsonAsp')->name('aspirantes.getJson');
        Route::get('/colegiados/new', 'ColegiadosController@create')->name('colegiados.new');
        Route::post('Aspirante/getDatosProfesionalesAspirante', ['middleware' => 'auth', 'uses' => 'ColegiadosController@getDatosProfesionalesAspirante']);
        Route::post('Aspirante/setDatosProfesionalesAspirante', ['middleware' => 'auth', 'uses' => 'ColegiadosController@setDatosProfesionalesAspirante']);
        Route::post('Aspirante/setDatosEspecialidadesAspirante', ['middleware' => 'auth', 'uses' => 'ColegiadosController@setDatosEspecialidadesAspirante']);
        Route::post('Aspirante/guardarMontoTimbreAspirante', ['middleware' => 'auth', 'uses' => 'ColegiadosController@guardarMontoTimbreAspirante']);
        Route::post('Aspirante/getMontoTimbreAspirante', ['middleware' => 'auth', 'uses' => 'ColegiadosController@getMontoTimbreAspirante']);
        Route::post('Aspirante/guardarFechaTopeMensualidades', ['middleware' => 'auth', 'uses' => 'ColegiadosController@guardarFechaTopeMensualidades']);
        Route::post('Aspirante/asociarColegiado', ['middleware' => 'auth', 'uses' => 'ColegiadosController@asociarColegiado']);
        Route::get('/Aspirante/colDisponible/', 'ColegiadosController@colegiadoDisponible');
        Route::get('/Aspirante/dpiDisponible/', 'ColegiadosController@dpiDisponible');
        Route::get('/Aspirante/dpiDisponible2/', 'ColegiadosController@dpiDisponibleColegiado');
        Route::get('/Aspirante/dpiDisponibleEdit/', 'ColegiadosController@dpiDisponibleEdit');

        Route::post('colegiado/getDatosProfesionalesColegiado', ['middleware' => 'auth', 'uses' => 'ColegiadosController@getDatosProfesionalesColegiado']);
        Route::post('colegiado/setDatosProfesionalesColegiado', ['middleware' => 'auth', 'uses' => 'ColegiadosController@setDatosProfesionalesColegiado']);
        Route::post('colegiado/getDatosEspecialidadesColegiado', ['middleware' => 'auth', 'uses' => 'ColegiadosController@getDatosEspecialidadesColegiado']);
        Route::post('colegiado/setDatosEspecialidadesColegiado', ['middleware' => 'auth', 'uses' => 'ColegiadosController@setDatosEspecialidadesColegiado']);
        Route::get('/aspirante/edit/{codigo}', ['middleware' => 'auth', 'uses' => 'ColegiadosController@edit'])->name('aspirante.edit');

         //General
         Route::get('General/listamunicipios','General@getListaMunicipios');
        Route::get('General/listadepartamentos','General@getListaDepartamentos');
        Route::get('General/listapaises','General@getListaPaises');
        Route::get('General/listauniversidades','General@getListaUniversidades');
        Route::post('General/departamentopais','General@getDepartamentoPais');
        Route::post('General/pais','General@getPais');
        Route::get('General/busquedaProfesionAutocomplete',['middleware' => 'auth', 'uses' => 'General@busquedaProfesionAutocomplete']);
        Route::get('General/busquedaEspecialidadAutocomplete',['middleware' => 'auth', 'uses' => 'General@busquedaEspecialidadAutocomplete']);

        Route::post('Aspirante/setdatosaspirante', 'ColegiadosController@setDatosAspirante')->name('colegiados.save');
        Route::post('Aspirante/getdatosaspirante', 'ColegiadosController@getDatosAspirante');
        Route::get('Aspirante/new', ['middleware' => 'auth', 'uses' => 'ColegiadosController@vistaAspirante'])->name('aspirante.new');
        Route::get( 'aspirante/detalles/{id}', 'ColegiadosController@detalles')->name('aspirante.detalles');
        Route::get( 'colegiados/detalles/{codigo}', 'ColegiadosController@detallesCo')->name('colegiado.detalles');

        // Modulo de Remesa
        Route::get( '/remesa', 'IngresoBodegaController@index')->name('remesa.index');
        Route::get( '/remesa/getJson/', 'IngresoBodegaController@getJson')->name('remesa.getJson');
        Route::get( '/remesa/new', 'IngresoBodegaController@create')->name('remesa.new');
        Route::post( '/remesa/save', 'IngresoBodegaController@store')->name('remesa.save');
        Route::post('/getUltimoDato/{datos}', 'IngresoBodegaController@getUltimoDato');
        Route::get( '/remesa/detalle/{id}' , 'IngresoBodegaController@show')->name('remesa.show');
        Route::get('/remesa/pdf/{id}/', 'IngresoBodegaController@pdfRemesa')->name('remesa.pdfRemesa');

        // Modulo de Traspaso de timbres
        Route::get( '/traspaso', 'TraspasoController@index')->name('traspaso.index');
        Route::get( '/traspaso/getJson/', 'TraspasoController@getJson')->name('traspaso.getJson');
        Route::get( '/traspaso/new', 'TraspasoController@create')->name('traspaso.new');
        Route::post( '/traspaso/save', 'TraspasoController@store')->name('traspaso.save');
        Route::get( '/getBodega/{bodega}', 'TraspasoController@getBodega');
        Route::get('/traspaso/pdf/{id}/', 'TraspasoController@pdfTraspaso')->name('traspaso.pdfTraspaso');

         // Módulo Corte de Caja
         Route::get('/cortedecaja', 'CorteDeCajaController@index')->name('cortecaja.index');
         Route::get('/cortedecaja/historial', 'CorteDeCajaController@historial')->name('cortecaja.historial');
         Route::get('/cortedecaja/getJson/', 'CorteDeCajaController@getJson')->name('cortedecaja.getJson');
         Route::get('/cortedecaja/getDetalle/', 'CorteDeCajaController@getDetalle')->name('cortedecaja.getDetalle');
         Route::get('/cortedecaja/getHistorial/', 'CorteDeCajaController@getHistorial')->name('cortedecaja.getHistorial');
         Route::get('/cortedecaja/historial/pdf/{id}/', 'CorteDeCajaController@pdf')->name('cortedecaja.pdfbitacora');
         Route::post('/cortedecaja/save/', 'CorteDeCajaController@setDetalleCorteCaja')->name('cortedecaja.save');
         Route::get( '/edit/bodega/{id}','CajasController@editBodegaCaja');

         //Timbres
         Route::get('/timbres/reporte/', 'TimbresController@reporteTimbres')->name('timbres.reporte');
         Route::get('/ventas/reporte-xyz/', 'ReportesController@reporteVentasXyz')->name('ventasxyz.reporte');
         Route::get('/ventas/reporteEnvios/', 'ReportesController@reporteEnvios')->name('envios.reporte');
         Route::get('/cursos/ceduca/', 'ReportesController@reporteCursosCeduca')->name('cursos.ceduca');
         Route::get('/timbres/getCajas/', 'TimbresController@getCajas');
         Route::get('/cursos/getTiposDePago/', 'ReportesController@getCursos');
         Route::get('/reportes/getCajas/', 'ReportesController@getCajas');
         Route::get('/colegiados/reporte/rango', 'TimbresController@reporteRangoColegiado')->name('timbres.rango');


    });


    Route::get('/', function () {
        $negocio = App\Negocio::all();
        return view('welcome', compact('negocio'));
    });

    Route::get('/pdf/{id}', 'ResolucionPagoController@imprimirResolucion');

    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/user/get/' , 'Auth\LoginController@getInfo')->name('user.get');
    Route::post('/user/contador' , 'Auth\LoginController@Contador')->name('user.contador');
    Route::post('/password/reset2' , 'Auth\ForgotPasswordController@ResetPassword')->name('password.reset2');
    Route::get('/user-existe/', 'Auth\LoginController@userExiste')->name('user.existe');

    //Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    //Estado de cuenta colegiado
    Route::get('/estadocuenta','EstadoCuentaController@index')->name('estadocuenta.index');
    Route::get('/estadocuenta/getJson/', 'EstadoCuentaController@getJson')->name('estadocuenta.getJson');
    Route::get('/estadocuenta/detallado/{id}','EstadoCuentaController@estadoCuentaDetallado')->name('estadocuenta.detallado');
    Route::get('/estadocuenta/getDetalle/{id}','EstadoCuentaController@getDetalle')->name('estadocuenta.getdetalle');
    Route::get('/estadocuenta/xyz/{id}','EstadoCuentaController@xyz')->name('estadocuenta.xyz');
    Route::get('/estadocuenta/getxyz/{id}','EstadoCuentaController@getXyz')->name('estadocuenta.getxyz');




    // Password Reset Routes...
    /*Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');*/


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
    Route::get('/gerencia','HomeController@gerencia')->name('dashboardgerencia');
    Route::get('/juntadirectiva','HomeController@juntadirectiva')->name('dashboardjuntadirectiva');
    Route::get('/administracion','HomeController@administracion')->name('dashboardadministracion');
    Route::get('/contabilidad','HomeController@contabilidad')->name('dashboardcontabilidad');
    Route::get('/informatica','HomeController@informatica')->name('dashboardinformatica');
    Route::get('/ceduca','HomeController@ceduca')->name('dashboardceduca');
    Route::get('/nuevoscolegiados','HomeController@nuevoscolegiados')->name('dashboardnuevoscolegiados');
    Route::get('/timbreingenieria','HomeController@timbreingenieria')->name('dashboardtimbreingenieria');
    Route::get('/comisiones','HomeController@contabilidad')->name('dashboardcomisiones');
    Route::get('/auditoria','HomeController@auditoria')->name('dashboardauditoria');


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
    Route::get('/colaborador/edit/{colaborador}', 'ColaboradorController@edit')->name('colaborador.edit');
    Route::put('/colaborador/{colaborador}/update', 'ColaboradorController@update')->name('colaborador.update');
    Route::post('/colaborador/{colaborador}/destroy', 'ColaboradorController@destroy')->name('colaborador.destroy');

    // Modulo de Junta Directiva
    Route::get('/acta', 'ActaMaestroController@index')->name('acta.index');
    Route::get('/acta/getJson/', 'ActaMaestroController@getJson')->name('acta.getJson');
    Route::get('/acta/new', 'ActaMaestroController@create')->name('acta.new');
    Route::post('/acta/save/', 'ActaMaestroController@store')->name('acta.save');
    Route::get('/acta/edit/{acta}', 'ActaMaestroController@edit')->name('acta.edit');
    Route::put('/acta/{acta}/update', 'ActaMaestroController@update')->name('acta.update');
    Route::post('/acta/{acta}/destroy', 'ActaMaestroController@destroy')->name('acta.destroy');

    // Modulo de Tipos de pago
    Route::get( '/tipoDePago' , 'TipoDePagoController@index')->name('tipoDePago.index');
    Route::get( '/tipoDePago/getJson/' , 'TipoDePagoController@getJson')->name('tipoDePago.getJson');
    Route::get( '/tipoDePago/new' , 'TipoDePagoController@create')->name('tipoDePago.new');
    Route::post( '/tipoDePago/save/' , 'TipoDePagoController@store')->name('tipoDePago.save');
    Route::get( '/tipoDePago/edit/{tipo}' , 'TipoDePagoController@edit')->name('tipoDePago.edit');
    Route::put( '/tipoDePago/{tipo}/update' , 'TipoDePagoController@update')->name('tipoDePago.update');
    Route::post('/tipoDePago/{tipo}/destroy' , 'TipoDePagoController@destroy')->name('tipoDePago.destroy');
    Route::post('/tipoDePago/{tipo}/delete' , 'TipoDePagoController@delete')->name('tipoDePago.delete');
    Route::post('/tipoDePago/{tipo}/activar' , 'TipoDePagoController@activar');

    // Modulo de Sub Sedes
    Route::get( '/subsedes' , 'SubsedesController@index')->name('subsedes.index');
    Route::get( '/subsedes/getJson/' , 'SubsedesController@getJson')->name('subsedes.getJson');
    Route::get( '/subsedes/new' , 'SubsedesController@create')->name('subsedes.new');
    Route::post( '/subsedes/save/' , 'SubsedesController@store')->name('subsedes.save');
    Route::get( '/subsedes/edit/{su}' , 'SubsedesController@edit')->name('subsedes.edit');
    Route::put( '/subsedes/{su}/update' , 'SubsedesController@update')->name('subsedes.update');
    Route::post('/subsedes/{su}/destroy' , 'SubsedesController@destroy')->name('subsedes.destroy');
    Route::post('/subsedes/{su}/delete' , 'SubsedesController@delete')->name('subsedes.delete');
    Route::post('/subsedes/{su}/activar' , 'SubsedesController@activar');
});


Route::get('/', function () {
    $negocio = App\Negocio::all();
    return view('welcome', compact('negocio'));
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home')->middleware(['estado']);

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

// Password Reset Routes...
/*Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');*/

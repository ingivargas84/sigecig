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
    Route::get('/admin','HomeController@index')->name('dashboard');
    Route::get('/gerencia','HomeController@gerencia')->name('dashboardgerencia');
    Route::get('/juntadirectiva','HomeController@juntadirectiva')->name('dashboardjuntadirectiva');
    Route::get('/administracion','HomeController@administracion')->name('dashboardadministracion');
    Route::get('/contabilidad','HomeController@contabilidad')->name('dashboardcontabilidad');

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

    Route::get( '/proveedores' , 'ProveedoresController@index')->name('proveedores.index');
    Route::get( '/proveedores/getJson/' , 'ProveedoresController@getJson')->name('proveedores.getJson');
    Route::get( '/proveedores/new' , 'ProveedoresController@create')->name('proveedores.new');
    Route::get( '/proveedores/edit/{proveedor}' , 'ProveedoresController@edit')->name('proveedores.edit');
    Route::put( '/proveedores/{proveedor}/update' , 'ProveedoresController@update')->name('proveedores.update');
    Route::post( '/proveedores/save/' , 'ProveedoresController@store')->name('proveedores.save');
    Route::post('/proveedores/{proveedor}/delete' , 'ProveedoresController@destroy');
    Route::post('/proveedores/{proveedor}/activar' , 'ProveedoresController@activar');
    Route::get('/proveedores/nitDisponible/', 'ProveedoresController@nitDisponible')->name('proveedores.nitDisponible');

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
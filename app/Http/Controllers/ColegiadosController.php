<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Image, Mail, Log, Auth, PDF, Date, Hash;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Aspirante;
use App\Universidad;
use App\Municipio;
use App\DepartamentoNac;
use App\Pais;
use App\Nacionalidad;
use App\Sexo;
use App\Especialidad;
use App\EspecialidadAspirante;
use App\Profesion;
use App\ProfesionAspirante;
use App\EstadoCivil;
use App\CC00;
use App\CC00prof;
use App\CC00espec;

class ColegiadosController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

    public function index()
    {
        $query = "SELECT c_profesion id, IIF (n_profesion='',titulo_masculino,titulo_masculino+' '+n_profesion) as nombre
        FROM profesion
        ORDER BY titulo_masculino+' '+n_profesion";
        $resultado = DB::connection('sqlsrv')->select($query);
        
        $query = "SELECT c_especialidad id, n_especialidad nombre 
        FROM especialidad 
        ORDER BY n_especialidad";
    		$esp = DB::connection('sqlsrv')->select($query);

        return view ('admin.colegiados.index', compact('resultado', 'esp'));
    }

    public function create()
    {
       /*  $estadocvl = EstadoCivil::all();

        return view ('admin.colegiados.create', compact('estadocvl')); */
    }

    protected function vistaAspirante($colegiado = null) {
        $query = "SELECT c_civil idcivil, n_civil valcivil FROM e_civil ORDER BY c_civil";
        $resultado = DB::connection('sqlsrv')->select($query);
        $estadosCivil = array();
        foreach($resultado as $fila) {
          $estadosCivil[$fila->idcivil] = $fila->valcivil;
        }
  
        $query = "SELECT c_sexo idsexo, n_sexo valsexo FROM sexo ORDER BY n_sexo";
        $resultado = DB::connection('sqlsrv')->select($query);
        $sexos = array();
        foreach($resultado as $fila) {
          $sexos[$fila->idsexo] = $fila->valsexo;
        }
  
        $query = "SELECT destino FROM destino_correo ORDER BY destino";
        $resultado = DB::connection('sqlsrv')->select($query);
        $destinos = array();
        foreach($resultado as $fila) {
          $destinos[$fila->destino] = $fila->destino;
        }
        return view('admin.colegiados.create')->with(['estadosCivil'=> $estadosCivil, 'sexos' => $sexos, 'destinos' => $destinos, 'colegiado' => $colegiado]);
      }

      public function detalles(Aspirante $id)
    {
      $query = Aspirante::where('dpi', '=', $id->dpi)->get()->first();
      $uni = Universidad::where('c_universidad', '=', $id->universidadGraduado)->get()->first();
      $uniinc = Universidad::where('c_universidad', '=', $id->universidadIncorporado)->get()->first();
      $muninac = Municipio::where('c_mpo', '=', $id->idmunicipionacimiento)->get()->first();
      $depnac = DepartamentoNac::where('c_depto', '=', $id->iddepartamentonacimiento)->get()->first();
      $paisnac = Pais::where('c_pais', '=', $id->idPaisNacimiento)->get()->first();
      $nacionalidad = Nacionalidad::where('c_nacionalidad', '=', $id->idnacionalidad)->get()->first();
      $ecivil = EstadoCivil::where('c_civil', '=', $id->estadocivil)->get()->first();
      $sx = Sexo::where('c_sexo', '=', $id->sexo)->get()->first();
      $municasa = Municipio::where('c_mpo', '=', $id->idMunicipioCasa)->get()->first();
      $munitrab = Municipio::where('c_mpo', '=', $id->idMunicipioTrabajo)->get()->first();
      $deptrab = DepartamentoNac::where('c_depto', '=', $id->idDepartamentoTrabajo)->get()->first();
 
      $especialidadasp = EspecialidadAspirante::where('dpi', '=', $id->dpi)->get()->first();
      
      $profasp = ProfesionAspirante::where('dpi', '=', $id->dpi)->get()->first();
/* dd($profasp);
      $profesion = Profesion::where('c_profesion', '=', $profasp->c_profesion)->get()->first(); */

      /*
      $especialidad = Especialidad::where('c_especialidad', '=', $especilidadasp->c_especialidad)->get()->first();
      $especilidadasp = Especialidad::select('aspirante.n_especialidad')
            ->join('especialidadAspirante', 'aspirante.dpi', '=', 'especialidadAspirante.dpi')
            ->get();*/
        return view ('admin.colegiados.detalles', compact('query', 'uni', 'uniinc', 'muninac','depnac', 'paisnac', 'nacionalidad', 'ecivil', 'sx', 'municasa', 'munitrab', 'deptrab', 'especialidadasp', 'profasp', 'id'));
    }

    public function detallesCo(CC00 $codigo)
    {
      $query = CC00::where('c_cliente', '=', $codigo->c_cliente)->get()->first();
      $sx = Sexo::where('c_sexo', '=', $codigo->sexo)->get()->first();
      $paisnac = Pais::where('c_pais', '=', $codigo->c_pais)->get()->first();
      $muninac = Municipio::where('c_mpo', '=', $codigo->c_mpo)->get()->first();
      $depnac = DepartamentoNac::where('c_depto', '=', $codigo->c_depto)->get()->first();
      $nacionalidad = Nacionalidad::where('c_nacionalidad', '=', $codigo->nacionalidad)->get()->first();
      $ecivil = EstadoCivil::where('c_civil', '=', $codigo->e_civil)->get()->first();
      $municasa = Municipio::where('c_mpo', '=', $codigo->c_mpocasa)->get()->first();
      $depcasa = DepartamentoNac::where('c_depto', '=', $codigo->c_deptocasa)->get()->first();
      $munitrab = Municipio::where('c_mpo', '=', $codigo->c_mpotrab)->get()->first();
      $deptrab = DepartamentoNac::where('c_depto', '=', $codigo->c_deptotrab)->get()->first();
      $uni = Universidad::where('c_universidad', '=', $codigo->c_universidad)->get()->first();
      $uniinc = Universidad::where('c_universidad', '=', $codigo->c_universidad1)->get()->first();
      $especialidadasp = CC00espec::where('c_cliente', '=', $codigo->c_cliente)->get()->first();
      $profasp = CC00prof::where('c_cliente', '=', $codigo->c_cliente)->get()->first(); 

        return view ('admin.colegiados.detallesCo', compact('query', 'sx', 'paisnac', 'muninac', 'depnac', 'nacionalidad', 'ecivil', 'municasa', 'depcasa', 'munitrab', 'deptrab', 'uni', 'uniinc', 'profasp', 'especialidadasp'));
    }
      
      public function getDatosAspirante() {
        $aspirante = Input::get('idusuario');
      Log::info("CIG. El usuario " . Auth::user()->name . " ha consultado al aspirante " . $aspirante);
      $user = \App\Aspirante::find($aspirante);
      if(!$user) {
      $respuesta = array('error' => '1', 'mensaje' => 'Datos no encontrados');
      return json_encode($respuesta);
    }
    try {
      $universidadGraduado = \App\Universidad::findOrFail($user->universidadGraduado);
      $user->{"valuniversidadgraduado"} = $universidadGraduado->n_universidad;
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      $user->{"valuniversidadgraduado"} = null;
    }

    try {
      $universidadIncorporado = \App\Universidad::findOrFail($user->universidadIncorporado);
      $user->{"valuniversidadincorporado"} = $universidadIncorporado->n_universidad;
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      $user->{"valuniversidadincorporado"} = null;
    }

    try {
      $municipioNacimiento = \App\Municipio::findOrFail($user->idmunicipionacimiento);
      $user->{"valmunicipionacimiento"} = $municipioNacimiento->n_mpo;
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      $user->{"valmunicipionacimiento"} = null;
    }

    try {
      $departamentoNacimiento = \App\DepartamentoNac::findOrFail($user->iddepartamentonacimiento);
      $user->{"valdepartamentonacimiento"} = $departamentoNacimiento->n_depto;
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      $user->{"valdepartamentonacimiento"} = null;
    }

    try {
      $municipioCasa = \App\Municipio::findOrFail($user->idMunicipioCasa);
      $user->{"valMunicipioCasa"} = $municipioNacimiento->n_mpo;
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      $user->{"valMunicipioCasa"} = null;
    }

    try {
      $departamentoCasa = \App\DepartamentoNac::findOrFail($user->idDepartamentoCasa);
      $user->{"valDepartamentoCasa"} = $departamentoNacimiento->n_depto;
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      $user->{"valDepartamentoCasa"} = null;
    }

    try {
      $municipioTrabajo = \App\Municipio::findOrFail($user->idMunicipioTrabajo);
      $user->{"valMunicipioTrabajo"} = $municipioTrabajo->n_mpo;
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      $user->{"valMunicipioTrabajo"} = null;
    }

    try {
      $departamentoTrabajo = \App\DepartamentoNac::findOrFail($user->idDepartamentoTrabajo);
      $user->{"valDepartamentoTrabajo"} = $departamentoTrabajo->n_depto;
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      $user->{"valDepartamentoTrabajo"} = null;
    }

    try {
      $municipioOtro = \App\Municipio::findOrFail($user->idMunicipioOtro);
      $user->{"valMunicipioOtro"} = $municipioOtro->n_mpo;
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      $user->{"valMunicipioOtro"} = null;
    }

    try {
      $departamentoOtro = \App\DepartamentoNac::findOrFail($user->idDepartamentoOtro);
      $user->{"valDepartamentoOtro"} = $departamentoOtro->n_depto;
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      $user->{"valDepartamentoOtro"} = null;
    }

    try {
      $pais = \App\Pais::findOrFail($user->idPaisNacimiento);
      $user->{"valPais"} = $pais->n_pais;
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      $user->{"valPais"} = null;
    }

    try {
      $nacionalidad = \App\Pais::findOrFail($user->idnacionalidad);
      $user->{"valNacionalidad"} = $nacionalidad->n_pais;
    } catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
      $user->{"valNacionalidad"} = null;
    }

    return json_encode($user);
  }

  public function setDatosAspirante() {
    DB::beginTransaction();
   
    //Log::info("CIG. Colegio. El usuario " . Auth::user()->name . " ha guardado al aspirante " . print_r(Input::all(), true));
 
    $user = \App\Aspirante::find(Input::get('idusuario'));
    if($user == null) {
      $user = new \App\Aspirante;
    }

    $user->dpi = Input::get('idusuario');
    $user->nombre = Input::get('nombres');
    $user->apellidos = Input::get('apellidos');

    $user->sexo = Input::get('sexo');
    $user->fechanacimiento = Input::get('fechaNacimiento');
    $user->idmunicipionacimiento = Input::get('idMunicipioNacimiento');
    $user->iddepartamentonacimiento = Input::get('idDepartamentoNacimiento');
    $user->idPaisNacimiento = Input::get('idPaisNacimiento');
    //$user->tiposangre = Input::get('tipoSangre');

    $user->idnacionalidad = Input::get('idNacionalidad');
    $user->telefono = Input::get('telefono');
    $user->telefonotrabajo = Input::get('telTrabajo');
    $user->correo = Input::get('email');
    //$user->nit = Input::get('nit');
    $user->estadocivil = Input::get('estadoCivil');

   // $user->conyugue = Input::get('conyugue');

    $user->direccioncasa = Input::get('direccion');
    $user->zona = Input::get('zona');
    $user->idmunicipiocasa = Input::get('idMunicipioCasa');
    $user->iddepartamentocasa = Input::get('idDepartamentoCasa');
    //$user->codigopostal = Input::get('codigoPostal');

    $user->direcciontrabajo = Input::get('direccionTrabajo');
    $user->zonatrabajo = Input::get('zonaTrabajo');
    $user->iddepartamentotrabajo = Input::get('idDepartamentoTrabajo');
    $user->idmunicipiotrabajo = Input::get('idMunicipioTrabajo');
   // $user->lugar = Input::get('lugarTrabajo');

   // $user->direccionotro = Input::get('direccionOtro');
   // $user->zonaotro = Input::get('zonaOtro');
  //  $user->iddepartamentootro = Input::get('idDepartamentoOtro');
   // $user->idmunicipiootro = Input::get('idMunicipioOtro');
    $user->destinocorreo = Input::get('destino');

    $user->fechagraduacion = Input::get('fechaGraduacion');
    $user->universidadgraduado = Input::get('idUniversidadGraduado');
    $user->universidadincorporado = Input::get('idUniversidadIncorporado');
    //$user->creditos = Input::get('creditos');

    $user->titulotesis = Input::get('tituloTesis');
    $user->telefonocontactoemergencia = Input::get('telefonoContactoEmergencia');
    $user->nombrecontactoemergencia = Input::get('nombreContactoEmergencia');
    $user->carrera_afin = Input::get('ca');

    $user->save();
    DB::commit();
    return response()->json(['mensaje' => 'Registrado Correctamente', 'url'=> route('colegiados.index')]);
  }


  public function getDatosProfesionalesAspirante() {
    $rules = array(
//        'idusuario' => 'required|digits:13',
      'idusuario' => 'required',
      'tipo' => 'required|required|in:P,M'
    );
    $messages = [
      'required' => 'El campo :attribute es obligatorio. Por favor revisar.',
    ];
    $validator = Validator::make(Input::all(), $rules, $messages);
    if ($validator->fails()) {
      $errors = $validator->errors();
      $errors =  json_decode($errors);
      return json_encode(array('error' => 1, 'mensaje' => 'Datos incompletos', 'infoError' => $errors));
    }

    $tipo = Input::get('tipo');
    $aspirante = \App\Aspirante::find(Input::get('idusuario'));
    $retorno = array();
    if($aspirante != null) {
      if($tipo == 'P') {
//          $retorno = \App\Aspirante::find(Input::get('idusuario'))->profesiones()->get();
        $retorno = $aspirante->profesiones()->get();
      } else if($tipo == 'M') {
        $retorno = \App\Aspirante::find(Input::get('idusuario'))->especialidades()->get();
      }
    }

    return json_encode($retorno);
  }

  public function setDatosProfesionalesAspirante() {
    $rules = array(
//        'idusuario' => 'required|integer',
      'idusuario' => 'required',
      'idprofesion' => 'required'
    );

    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return json_encode(array('retorno' => 2, 'mensaje' => 'Profesión o colegiado inválido'));
    }

    $aspirante = \App\Aspirante::find(Input::get('idusuario'));
    if($aspirante == null) {
//        $this->setDatosAspirante();
//        $aspirante = \App\Aspirante::find(Input::get('idusuario'));
    }
Log::info("Morir2 ".print_r($aspirante, true));
    $aspirante->profesiones()->attach(Input::get('idprofesion'));
    return json_encode(array('retorno' => 0, 'mensaje' => 'Profesión guardada correctamente'));
  }

  public function setDatosEspecialidadesAspirante() {
    $rules = array(
      'idusuario' => 'required|integer',
      'idespecialidad' => 'required'
    );

    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return json_encode(array('retorno' => 2, 'mensaje' => 'Profesión o colegiado inválido'));
    }

    $aspirante = \App\Aspirante::find(Input::get('idusuario'));
    $aspirante->especialidades()->attach(Input::get('idespecialidad'));
    return json_encode(array('retorno' => 0, 'mensaje' => 'Especialidad guardada correctamente'));
  }


  public function guardarMontoTimbreAspirante() {
    $rules = array(
//        'idusuario' => 'required|digits:13',
          'idusuario' => 'required|integer',
          'montoTimbre' => 'required'
    );
    $messages = [
      'required' => 'El campo :attribute es obligatorio. Por favor revisar.',
    ];
    $validator = Validator::make(Input::all(), $rules, $messages);
    if ($validator->fails()) {
      $errors = $validator->errors();
      $errors =  json_decode($errors);
      return json_encode(array('error' => 1, 'mensaje' => 'Datos incompletos', 'infoError' => $errors));
    }
    Log::info("CIG. Colegio. El usuario " . Auth::user()->name . " ha guardado el monto de timbre " . print_r(Input::all(), true));
    $user = \App\Aspirante::find(Input::get('idusuario'));
    if($user == null) {
      $this->setDatosAspirante();
      $user = \App\Aspirante::find(Input::get('idusuario'));
    }
    $user->montoTimbre = Input::get('montoTimbre');
    $user->save();
    return json_encode(array('error' => 0, 'mensaje' => 'Datos guardados correctamente.'));
  }

  public function getMontoTimbreAspirante() {
    $rules = array(
//        'idusuario' => 'required|digits:13'
      'idusuario' => 'required'
    );
    $messages = [
      'required' => 'El campo :attribute es obligatorio. Por favor revisar.',
    ];
    $validator = Validator::make(Input::all(), $rules, $messages);
    if ($validator->fails()) {
      $errors = $validator->errors();
      $errors =  json_decode($errors);
      return json_encode(array('error' => 1, 'mensaje' => 'Datos incompletos', 'infoError' => $errors));
    }
    Log::info("CIG. Colegio. El usuario " . Auth::user()->name . " ha consultado el monto de timbre " . Input::get('idusuario'));
    $user = \App\Aspirante::find(Input::get('idusuario'));
    if($user == null) {
      $user = new \App\Aspirante;
    }
    return json_encode(array('error' => 0, 'montoTimbre' => $user->montoTimbre));
  }

  
    public function obtenerFechaTopeMensualidades() {
      $rules = array(
        'idusuario' => 'required|digits:13'
      );
      $messages = [
        'required' => 'El campo :attribute es obligatorio. Por favor revisar.',
      ];
      $validator = Validator::make(Input::all(), $rules, $messages);
      if ($validator->fails()) {
        $errors = $validator->errors();
        $errors =  json_decode($errors);
        return json_encode(array('error' => 1, 'mensaje' => 'Datos incompletos', 'infoError' => $errors));
      }

      $user = \App\Aspirante::find(Input::get('idusuario'));
      if($user == null) {
        $user = new \App\Aspirante;
      }
      return json_encode(array('error' => 0, 'topefechapagocuotas' => $user->topeFechaPagoCuotas));
    }

    public function guardarFechaTopeMensualidades() {
      $rules = array(
        'idusuario' => 'required|digits:13',
        'fechaTopeMensualidades' => 'required|date'
      );
      $messages = [
        'required' => 'El campo :attribute es obligatorio. Por favor revisar.',
      ];
      $validator = Validator::make(Input::all(), $rules, $messages);
      if ($validator->fails()) {
        $errors = $validator->errors();
        $errors =  json_decode($errors);
        return json_encode(array('error' => 1, 'mensaje' => 'Datos incompletos', 'infoError' => $errors));
      }
      Log::info("CIG. Colegio. El usuario " . Auth::user()->name . " ha guardado la fecha de tope del aspirante " . print_r(Input::all(), true));
      $user = \App\Aspirante::find(Input::get('idusuario'));
      if($user == null) {
        $this->setDatosAspirante();
        $user = \App\Aspirante::find(Input::get('idusuario'));
      }
      $user->topeFechaPagoCuotas = Input::get('fechaTopeMensualidades');
      $user->save();
      return json_encode(array('error' => 0, 'mensaje' => 'Datos guardados correctamente.'));
    }

    
    public function asociarColegiado() {
      if (!Hash::check(Input::get('password'), Auth::user()->password)) {
        return json_encode(array('retorno' => 2, 'mensaje' => 'Error de autenticación'));
      }
      $rules = array(
//        'idusuario' => 'required|integer',
        'idusuario' => 'required',
        'colegiado' => 'required|integer',
        'fechaColegiado' => 'required|date',
        'fechaUltimoPagoColegio' => 'required|date',
        'fechaUltimoPagoTimbre' => 'required|date'
      );
      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
        return json_encode(array('retorno' => 2, 'mensaje' => 'Especialidad o colegiado inválido'));
      }
      $colegiado = \App\Cc00::find(Input::get('colegiado'));
      if($colegiado) {
        $respuesta = array('error' => '3', 'mensaje' => 'Colegiado ya existente');
        return json_encode($respuesta);
      }

      DB::beginTransaction();
      $aspirante = \App\Aspirante::find(Input::get('idusuario'));
      Log::info("CIG. Colegio. El usuario " . Auth::user()->name . " ha asociado el colegiado " . Input::get('colegiado') . " al aspirante " . print_r($aspirante, true));
      $colegiado = new \App\Cc00;
      $colegiado->c_cliente = Input::get('colegiado');
      $colegiado->n_cliente= $aspirante->nombre . ' ' . $aspirante->apellidos;
      $colegiado->nombres= $aspirante->nombre;
      $colegiado->apellidos= $aspirante->apellidos;
      $colegiado->telefono= $aspirante->telefono;
      $colegiado->e_mail= $aspirante->correo;
      $colegiado->f_ult_pago= Input::get('fechaUltimoPagoColegio');
      $colegiado->f_ult_timbre= Input::get('fechaUltimoPagoTimbre');
      $colegiado->fecha_col= Input::get('fechaColegiado');
      $colegiado->fallecido= 'N';
      $colegiado->c_depto= $aspirante->iddepartamentonacimiento;
      $colegiado->c_mpo= $aspirante->idmunicipionacimiento;
      $colegiado->direccion= $aspirante->direccionCasa;
      $colegiado->dir_trabajo= $aspirante->direccionTrabajo;
      //$colegiado->contacto1= $aspirante->direccionOtro;
      $colegiado->c_mpocasa= $aspirante->idMunicipioCasa;
      $colegiado->c_deptocasa= $aspirante->idDepartamentoCasa;
      $colegiado->c_mpotrab= $aspirante->idMunicipioTrabajo;
      $colegiado->c_deptotrab= $aspirante->idDepartamentoTrabajo;
      //$colegiado->c_mpootro= $aspirante->idMunicipioOtro;
     // $colegiado->c_deptootro= $aspirante->idDepartamentoOtro;
      $colegiado->zona= $aspirante->zona;
      $colegiado->zona_trabajo= $aspirante->zonatrabajo;
      //$colegiado->zona_otra= $aspirante->zonaotro;
      $colegiado->registro= $aspirante->dpi;
     // $colegiado->nit= $aspirante->nit;
      $colegiado->estado_junta= '01';
      $colegiado->sexo= $aspirante->sexo;
      $colegiado->e_civil= $aspirante->estadocivil;
      $colegiado->destino_correo= $aspirante->destinoCorreo;
      //$colegiado->cod_postal= $aspirante->codigopostal;
      $colegiado->fax= $aspirante->telefonoTrabajo;
      //$colegiado->contacto2= $aspirante->lugar;
      $colegiado->c_pais= $aspirante->idPaisNacimiento;
      $colegiado->fecha_nac= $aspirante->fechaNacimiento;
      //$colegiado->tipo_sangre= $aspirante->tipoSangre;
      $colegiado->max_constancias= 130;
      $colegiado->telefonocontactoemergencia= $aspirante->telefonoContactoEmergencia;
      $colegiado->nombrecontactoemergencia= $aspirante->nombreContactoEmergencia;
      $colegiado->paga_auxilio= 1;
      $colegiado->jubilado= 0;
      $colegiado->fecha_grad= $aspirante->fechaGraduacion;
      $colegiado->c_universidad= $aspirante->universidadGraduado;
      $colegiado->c_universidad1= $aspirante->universidadIncorporado;
      $colegiado->cred_acum= $aspirante->creditos;
      $colegiado->titulo_tesis= $aspirante->tituloTesis;
      $colegiado->descto_colegio= 0;
      $colegiado->descto_timbre= 0;
      $colegiado->n_social= $aspirante->conyugue;
      $colegiado->memo= Input::get('memo');
      $colegiado->observaciones= Input::get('observaciones');
      $colegiado->estado= 'A';
      $colegiado->c_vendedor= '01';
      $colegiado->c_t_cl= 0;
      $colegiado->c_negocio= 1;
      $colegiado->t_pre= 'A';
      $colegiado->topeFechaPagoCuotas= $aspirante->topeFechaPagoCuotas;
      $colegiado->monto_timbre= $aspirante->montoTimbre;
      $colegiado->nacionalidad= $aspirante->idnacionalidad;
      $colegiado->telmovil= $aspirante->telefono;
      $colegiado->carrera_afin= $aspirante->carrera_afin;

      $colegiado->save();
      $query = "INSERT INTO cc00prof(c_cliente,c_profesion,n_profesion) select :colegiado, pa.c_profesion, isnull(titulo_masculino,'') + ' ' + isnull(n_profesion,'') from profesionAspirante pa INNER JOIN profesion p ON pa.c_profesion = p.c_profesion WHERE dpi=:dpi";
      $parametros = array(':colegiado' => Input::get('colegiado'), ':dpi' => Input::get('idusuario'));
      $resultado = DB::insert($query, $parametros);

      $query = "INSERT INTO cc00espec(c_cliente,c_especialidad,n_especialidad) select :colegiado, ea.c_especialidad, isnull(titulo_masculino,'') + ' ' + isnull(n_especialidad,'') from especialidadAspirante ea INNER JOIN especialidad e ON ea.c_especialidad = e.c_especialidad WHERE dpi=:dpi";
      $parametros = array(':colegiado' => Input::get('colegiado'), ':dpi' => Input::get('idusuario'));
      $resultado = DB::insert($query, $parametros);

      DB::commit();

      return json_encode(array('error' => 0, 'mensaje' => 'Colegiado trasladado correctamente'));
    }

    public function getJson(Request $params)
     {
        $query = "SELECT CC.c_cliente as codigo, CC.n_cliente as colegiado,
        IIF ((DATEDIFF(MONTH, CC.f_ult_pago, GETDATE()) <= 3 AND DATEDIFF(MONTH, CC.f_ult_timbre, GETDATE()) <= 3),'Activo',
        (IIF ((cc.f_fallecido is NULL and CC.fallecido = 'N'),'Inactivo','Fallecido'))) as estado,
        cp.n_profesion as carrera
                FROM cc00 CC
                INNER JOIN cc00prof cp ON CC.c_cliente = cp.c_cliente
                UNION
                SELECT C.dpi as codigo, C.nombre as colegiado, estado = 'Aspirante', CONCAT(P.titulo_masculino, ' ', P.n_profesion) as carrera
                    FROM aspirante C
                    INNER JOIN profesionAspirante PA ON PA.dpi = C.dpi
                    INNER JOIN profesion P ON PA.c_profesion = P.c_profesion"; 

        $api_Result['data'] = DB::connection('sqlsrv')->select($query);
        return Response::json( $api_Result );
     }
}
/* "SELECT  C.n_cliente, C.c_cliente, C.estado
        FROM cc00 C
        ";  */ 
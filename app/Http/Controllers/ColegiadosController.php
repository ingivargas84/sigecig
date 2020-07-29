<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use App\EstadoCivil;
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

class ColegiadosController extends Controller
{
    public function index()
    {
        return view ('admin.colegiados.index');
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

        return view ('admin.colegiados.detalles', compact('query', 'uni', 'uniinc', 'muninac','depnac', 'paisnac', 'nacionalidad', 'ecivil', 'sx', 'municasa', 'munitrab', 'deptrab'));
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
    /*  $rules = array(
//        'idusuario' => 'required|digits:13',
      'idusuario' => 'required',
      'nombres' => 'required',
      'apellidos' => 'required',

      'sexo' => 'required|in:M,F',
      'fechaNacimiento' => 'required|date',
      'idDepartamentoCasa' => 'required',
      'idMunicipioCasa' => 'required',

      'email' => 'required',

//        'dpi' => 'required|digits:13',
      'idDepartamentoNacimiento' => 'required',
      'idMunicipioNacimiento' => 'required',
      'idDepartamentoTrabajo' => 'required',
      'idMunicipioTrabajo' => 'required',
      'direccion' => 'required',

      'estadoCivil' => 'required|in:C,D,P,S,U,V',
      'destino' => 'required|in:Casa,Oficina,Otros',
      'codigoPostal' => 'required',
      'telTrabajo' => 'required',
      'lugarTrabajo' => 'required',

      'fechaGraduacion' => 'required|date',
      'idUniversidadGraduado' => 'required',
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
    Log::info("CIG. Colegio. El usuario " . Auth::user()->name . " ha guardado al aspirante " . print_r(Input::all(), true));
 */
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
    return redirect()->route('colegiados.index')->withFlash('Colegiado se creo exitosamente!');
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
    return json_encode(array('retorno' => 0, 'mensaje' => 'Profesión guardada correctamente'));
  }


    public function getJson(Request $params)
     {
        $query = "SELECT dpi, nombre, carrera_afin
        FROM aspirante 
        ";

        $api_Result['data'] = DB::connection('sqlsrv')->select($query);
        return Response::json( $api_Result );
     }
}

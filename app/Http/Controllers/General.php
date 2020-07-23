<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Mail, Excel, PDO, PDF;
use Jenssegers\Date\Date;
use Validator, Redirect;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;


class General extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function aceptarContrasena($token, $colegiado) {

    }


    public function enviarCorreoDesdePortal($destinatarios, $mensaje, $nombreEmisor, $correoEmisor) {
      Mail::send('emails.mensajePortal', ["mensaje" => $mensaje, 'nombreEmisor' => $nombreEmisor, 'correoEmisor' => $correoEmisor], function($message) use ($destinatarios){
        $message->to($destinatarios)->subject('Mensaje de parte del portal');
      });
    }

	protected function carnets() {
        return view('generacionDatosCarnet');
    }

      protected function vistaConvenio() {
        $id = Input::get('id');
        $fechaCol = '2003-11-11';
        $fechaColT = strtotime($fechaCol);
        $fechaInicio = '2007-01-01';
        $fechaInicioT = strtotime($fechaInicio);
        $capitalDebe = '1116.43';
        $cuotas = '12';
        $primerPago = '543.21';
        $capitalPC = 200;
        $interesPC = 240;
        $moraPC = 300;
        $interesConvenioPC = 123;
        $cuotaTimbre = 23;
        $totalAPagar = '12000';

        $numerosLetras = new numerosLetras();
        Date::setLocale('es');

        /*return view('Timbre.conveniopdf')->with(['colegioTimbre'=> 1, 'diaActualL' => $numerosLetras->traducir(date('d')),
      'mesActualL' => Date::now()->format('F'), 'anioActualL' => $numerosLetras->traducir(date('Y')),
      'nombreColegiado' => mb_strtoupper('asdfasdf', 'utf-8'), 'dpiL1' => mb_strtoupper($numerosLetras->traducir('3388', 1), 'utf-8'), 'dpiL2' => strtoupper($numerosLetras->traducir('78654', 1)),
      'dpiL3' => mb_strtoupper($numerosLetras->traducir('0101', 1), 'utf-8'), 'dpi' => '3388 78654 0101', 'colegiadoL' => $numerosLetras->traducir('12345'),
      'colegiado' => '12345', 'direccion' => 'Mi casa casa casa', 'fechaColL' => date('d',$fechaColT) . ' de ' . Date::parse($fechaColT)->format('F') . ' de ' . date('Y',$fechaColT),
      'fechaCol' => date('d/m/Y',$fechaColT), 'mesInicioL' => Date::parse($fechaInicio)->format('F'), 'anioInicioL' => $numerosLetras->traducir(date('Y',$fechaInicioT)),
      'capitalDebeL' => mb_strtoupper($numerosLetras->traducir($capitalDebe, 0, 1), 'utf-8'), 'capitalDebe' => number_format($capitalDebe,2,'.',','),
      'cuotasL' => $numerosLetras->traducir($cuotas, 0, 1), 'cuotas' => $cuotas, 'primerPagoL' => $numerosLetras->traducir($primerPago, 0, 1),
      'primerPago' => number_format($primerPago,2,'.',','), 'capitalPC' => number_format($capitalPC,2,'.',','), 'interesPC' => number_format($interesPC,2,'.',','), 'moraPC' => number_format($moraPC,2,'.',','),
      'interesConvenioPC' => $interesConvenioPC, 'cuotaTimbre' => $cuotaTimbre, 'totalAPagar' => number_format($totalAPagar,2,'.',','), 'totalAPagarL' => $numerosLetras->traducir($totalAPagar, 0, 1)
    ]);*/
    $pdf = PDF::loadView('Timbre.conveniopdf',['colegioTimbre'=> 1, 'diaActualL' => $numerosLetras->traducir(date('d')),
  'mesActualL' => Date::now()->format('F'), 'anioActualL' => $numerosLetras->traducir(date('Y')),
  'nombreColegiado' => mb_strtoupper('asdfasdf', 'utf-8'), 'dpiL1' => mb_strtoupper($numerosLetras->traducir('3388', 1), 'utf-8'), 'dpiL2' => strtoupper($numerosLetras->traducir('78654', 1)),
  'dpiL3' => mb_strtoupper($numerosLetras->traducir('0101', 1), 'utf-8'), 'dpi' => '3388 78654 0101', 'colegiadoL' => $numerosLetras->traducir('12345'),
  'colegiado' => '12345', 'direccion' => 'Mi casa casa casa', 'fechaColL' => date('d',$fechaColT) . ' de ' . Date::parse($fechaCol)->format('F') . ' de ' . date('Y',$fechaColT),
  'fechaCol' => date('d/m/Y',$fechaColT), 'mesInicioL' => Date::parse($fechaInicio)->format('F'), 'anioInicioL' => $numerosLetras->traducir(date('Y',$fechaInicioT)),
  'capitalDebeL' => mb_strtoupper($numerosLetras->traducir($capitalDebe, 0, 1), 'utf-8'), 'capitalDebe' => number_format($capitalDebe,2,'.',','),
  'cuotasL' => $numerosLetras->traducir($cuotas, 0, 1), 'cuotas' => $cuotas, 'primerPagoL' => $numerosLetras->traducir($primerPago, 0, 1),
  'primerPago' => number_format($primerPago,2,'.',','), 'capitalPC' => number_format($capitalPC,2,'.',','), 'interesPC' => number_format($interesPC,2,'.',','), 'moraPC' => number_format($moraPC,2,'.',','),
  'interesConvenioPC' => $interesConvenioPC, 'cuotaTimbre' => $cuotaTimbre, 'totalAPagar' => number_format($totalAPagar,2,'.',','), 'totalAPagarL' => $numerosLetras->traducir($totalAPagar, 0, 1)
  ])->setPaper('letter');
  return $pdf->download('convenio.pdf');
      }

    protected function vistaEspecialidad() {
      $query = "SELECT id_nivel id, descripcion FROM nivel_especialidad ORDER BY descripcion";
      $resultado = DB::connection('sqlsrv')->select($query);
      $this->utf8_encode_deep($resultado);
      $niveles = array();
      foreach($resultado as $fila) {
        $niveles[$fila->id] = $fila->descripcion;
      }
          return view('General.especialidad')->with(['niveles'=> $niveles]);;
    }

    protected function vistaProfesion() {
      return view('General.profesion');
    }

    protected function vistaBusquedaEspecialidad() {
      return view('General.busquedaMaestria');
    }

    protected function vistaBusquedaProfesion() {
      return view('General.busquedaProfesion');
    }

      protected function busquedaEspecialidad() {
        $nombre = Input::get('nombre');
        return json_encode($this->busquedaEspecialidadRaw($nombre));
      }

      protected function busquedaProfesion() {
        $nombre = Input::get('nombre');
        return json_encode($this->busquedaProfesionRaw($nombre));
      }

      protected function busquedaEspecialidadRaw($busqueda) {
        $nombre = $busqueda;
        $nombrePreparado = str_replace(" ","%",strtolower(trim($nombre)));
        $query = "SELECT c_especialidad id, n_especialidad nombre FROM especialidad WHERE lower(n_especialidad) COLLATE SQL_LATIN1_GENERAL_CP1_CI_AI like '%' + :nombre + '%' ORDER BY n_especialidad";
        $parametros = array(':nombre' => $nombrePreparado);
    		$resultado = DB::connection('sqlsrv')->select($query, $parametros);
        $this->utf8_encode_deep($resultado);
        return $resultado;
      }

      protected function busquedaProfesionRaw($busqueda) {
        $nombre = $busqueda;
        $nombrePreparado = str_replace(" ","%",strtolower(trim($nombre)));
        $query = "SELECT c_profesion id, isnull(titulo_masculino,'') + ' ' + isnull(n_profesion,'') nombre FROM profesion WHERE (lower(isnull(n_profesion,'') + ' ' + isnull(titulo_masculino,'')) COLLATE SQL_LATIN1_GENERAL_CP1_CI_AI like '%' + :nombre + '%') OR (lower(isnull(n_profesion,'') + ' ' + isnull(titulo_femenino,'')) COLLATE SQL_LATIN1_GENERAL_CP1_CI_AI like '%' + :nombre + '%') ORDER BY n_profesion + ' ' + titulo_masculino";
        $parametros = array(':nombre' => $nombrePreparado);
    		$resultado = DB::connection('sqlsrv')->select($query, $parametros);
        $this->utf8_encode_deep($resultado);
        return $resultado;
      }

      protected function obtenerEspecialidad() {
        $id = Input::get('id');
        $query = "SELECT c_especialidad id, n_especialidad nombre, id_nivel nivel FROM especialidad WHERE c_especialidad = :id";
        $parametros = array(':id' => $id);
    		$resultado = DB::connection('sqlsrv')->select($query, $parametros);
        $resultadoR = null;
        foreach($resultado as $fila) {
          $resultadoR = $fila;
        }
        if(!$resultadoR) {
          $respuesta = array('error' => '1', 'mensaje' => 'Datos no encontrados');
          return json_encode($respuesta);
        }
        $this->utf8_encode_deep($resultadoR);
        return json_encode($resultadoR);
      }

      protected function guardarEspecialidad() {
        $id = Input::get('id');
        $nombre = Input::get('nombre');
        $nivel = Input::get('nivel');
        $query = "SELECT 1 d FROM especialidad WHERE c_especialidad = :id";
    		$parametros = array(':id' => $id);
    		$users = DB::connection('sqlsrv')->select($query, $parametros);
    		$instructorR = null;
    		foreach($users as $instructor) {
    			$instructorR = $instructor;
    		}
        if(!$instructorR) {
          $instruccion = "INSERT INTO especialidad(c_especialidad, n_especialidad, id_nivel) VALUES(:id, :nombre, :nivel)";
          $parametros = array(':id' => $id, ':nombre' => $nombre, ':nivel' => $nivel);
          $resultadoInsert = DB::insert($instruccion, $parametros);
    			$mensaje = 'Nueva especialidad guardada satisfactoriamente';
        } else {
          $instruccion = "UPDATE especialidad SET n_especialidad = :nombre, id_nivel = :nivel WHERE c_especialidad = :id";
          $parametros = array(':id' => $id, ':nombre' => $nombre, ':nivel' => $nivel);
          $resultadoInsert = DB::update($instruccion, $parametros);
    			$mensaje = 'Especialidad guardada satisfactoriamente';
        }

        $respuesta = array('a' => $resultadoInsert, 'mensaje' => $mensaje);
        return json_encode($respuesta);
      }


      protected function obtenerProfesion() {
        $id = Input::get('id');
        $query = "SELECT c_profesion id, n_profesion nombre, titulo_masculino, titulo_femenino FROM profesion WHERE c_profesion = :id";
        $parametros = array(':id' => $id);
    		$resultado = DB::connection('sqlsrv')->select($query, $parametros);
        $resultadoR = null;
        foreach($resultado as $fila) {
          $resultadoR = $fila;
        }
        if(!$resultadoR) {
          $respuesta = array('error' => '1', 'mensaje' => 'Datos no encontrados');
          return json_encode($respuesta);
        }
        $this->utf8_encode_deep($resultadoR);
        return json_encode($resultadoR);
      }

      protected function guardarProfesion() {
        $id = Input::get('id');
        $nombre = Input::get('nombre');
        $titulo_masculino = Input::get('titulo_masculino');
        $titulo_femenino = Input::get('titulo_femenino');
        $query = "SELECT 1 d FROM profesion WHERE c_profesion = :id";
    		$parametros = array(':id' => $id);
    		$users = DB::connection('sqlsrv')->select($query, $parametros);
    		$instructorR = null;
    		foreach($users as $instructor) {
    			$instructorR = $instructor;
    		}
        if(!$instructorR) {
          $instruccion = "INSERT INTO profesion(c_profesion, n_profesion, titulo_masculino, titulo_femenino) VALUES(:id, :nombre, :titulo_masculino, :titulo_femenino)";
          $parametros = array(':id' => $id, ':nombre' => $nombre, ':titulo_femenino' => $titulo_femenino, ':titulo_masculino' => $titulo_masculino);
          $resultadoInsert = DB::insert($instruccion, $parametros);
    			$mensaje = 'Nueva profesión guardada satisfactoriamente';
        } else {
          $instruccion = "UPDATE profesion SET n_profesion = :nombre, titulo_masculino = :titulo_masculino, titulo_femenino = :titulo_femenino WHERE c_profesion = :id";
          $parametros = array(':id' => $id, ':nombre' => $nombre, ':titulo_femenino' => $titulo_femenino, ':titulo_masculino' => $titulo_masculino);
          $resultadoInsert = DB::update($instruccion, $parametros);
    			$mensaje = 'Profesión modificada satisfactoriamente';
        }

        $respuesta = array('a' => $resultadoInsert, 'mensaje' => $mensaje);
        return json_encode($respuesta);
      }

    protected function prueba1($colegiado = null) {
      return view('prueba')->with(['colegiado' => $colegiado]);
    }

      protected function prueba1post($colegiado = null) {
        $rules = array(
          'g-recaptcha-response' => 'required|recaptcha',
          'colegiado' => 'required|integer',
          'nombre' => 'required',
          'correo' => 'required|email'
        );

        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
          return view('prueba')->withErrors($validator)->withInput(Input::all());
        } else {
          $query = "SELECT e_mail correo FROM cc00 WHERE c_cliente = :colegiado";
          $parametros = array('colegiado' => Input::get('colegiado'));
          $datos = DB::connection('sqlsrv')->select($query, $parametros);
          $resultado = null;
          foreach($datos as $fila) {
            $resultado = $fila->correo;
          }

          if(!empty($resultado)) {
            $correos = explode(",",$resultado);
            /*var_dump($correos);
            return 1;*/
            $this->enviarCorreoDesdePortal($correos, Input::get('mensaje'), Input::get('nombre'), Input::get('correo'));
          }
          return view('prueba')->with(array('mensaje' => 'Éxito'));
        }
        return view('prueba')->with(array('mensaje' => 'Éxito'));
      }

      function multiexplode ($delimiters,$string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

	public function generarCSVTarjeta() {
		$query = "SET LANGUAGE Spanish;";
		DB::connection('sqlsrv')->select($query);

		$query = "SELECT CASE WHEN DATEDIFF(month, c.f_ult_pago, GETDATE()) > 0 THEN DATEDIFF(month, c.f_ult_pago, GETDATE()) ELSE 1 END cuotas,c.n_cliente, c.c_cliente, t.tarjeta, t.fecha_expiracion, CASE WHEN DATEDIFF(month, c.f_ult_pago, GETDATE()) > 0 THEN 115.75 * DATEDIFF(month, c.f_ult_pago, GETDATE()) ELSE 115.75 END monto, CONVERT(varchar(2), getdate(), 103) + CONVERT(varchar(2), getdate(), 101) + CAST(DATEPART(yyyy, GETDATE()) as varchar) fecha,t.correo, 'Cobro ' + CAST(DateName(mm, GETDATE()) as varchar) + ' ' + cast(DATEPART(yyyy, GETDATE()) as varchar) as motivo FROM tarjeta_colegiado t INNER JOIN cc00 c ON c.c_cliente = t.c_cliente WHERE t.activo = 1 AND (DATEDIFF(month, c.f_ult_pago, GETDATE()) <= 3 and DATEDIFF(month, c.f_ult_timbre, GETDATE()) <= 3) AND GETDATE() >= t.fecha_inicio";
		//$query = "SELECT CASE WHEN DATEDIFF(month, c.f_ult_pago, convert(date,'2017-04-30')) > 0 THEN DATEDIFF(month, c.f_ult_pago, convert(date,'2017-04-30')) ELSE 1 END cuotas,c.n_cliente, c.c_cliente, t.tarjeta, t.fecha_expiracion, CASE WHEN DATEDIFF(month, c.f_ult_pago, convert(date,'2017-04-30')) > 0 THEN 115.75 * DATEDIFF(month, c.f_ult_pago, convert(date,'2017-04-30')) ELSE 115.75 END monto, CONVERT(varchar(2), convert(date,'2017-04-30'), 103) + CONVERT(varchar(2), convert(date,'2017-04-30'), 101) + CAST(DATEPART(yyyy, convert(date,'2017-04-30')) as varchar) fecha,t.correo, 'Cobro ' + CAST(DateName(mm, convert(date,'2017-04-30')) as varchar) + ' ' + cast(DATEPART(yyyy, convert(date,'2017-04-30')) as varchar) as motivo FROM tarjeta_colegiado t INNER JOIN cc00 c ON c.c_cliente = t.c_cliente WHERE t.activo = 1 AND (DATEDIFF(month, c.f_ult_pago, convert(date,'2017-04-30')) <= 3 and DATEDIFF(month, c.f_ult_timbre, convert(date,'2017-04-30')) <= 3) AND convert(date,'2017-04-30') >= t.fecha_inicio AND c.c_cliente NOT IN ('11327','12626','1453','1660','1694','1775','1889','2369','2808','3299','3353','3354','3576','5183','5216','590','6499','6846','7424','8253','923','2451')";
		//$query = "SELECT CASE WHEN DATEDIFF(month, c.f_ult_pago, convert(date,'2016-12-31')) > 0 THEN DATEDIFF(month, c.f_ult_pago, convert(date,'2016-12-31')) ELSE 1 END cuotas,c.n_cliente, c.c_cliente, t.tarjeta, t.fecha_expiracion, CASE WHEN DATEDIFF(month, c.f_ult_pago, convert(date,'2016-12-31')) > 0 THEN 115.75 * DATEDIFF(month, c.f_ult_pago, convert(date,'2016-12-31')) ELSE 115.75 END monto, CONVERT(varchar(2), convert(date,'2016-12-31'), 103) + CONVERT(varchar(2), convert(date,'2016-12-31'), 101) + CAST(DATEPART(yyyy, convert(date,'2016-12-31')) as varchar) fecha,t.correo, 'Cobro ' + CAST(DateName(mm, convert(date,'2016-12-31')) as varchar) + ' ' + cast(DATEPART(yyyy, convert(date,'2016-12-31')) as varchar) as motivo FROM tarjeta_colegiado t INNER JOIN cc00 c ON c.c_cliente = t.c_cliente WHERE t.activo = 1 AND (DATEDIFF(month, c.f_ult_pago, convert(date,'2016-12-31')) <= 3 and DATEDIFF(month, c.f_ult_timbre, convert(date,'2016-12-31')) <= 3) AND GETDATE() >= t.fecha_inicio";
		$datos = DB::connection('sqlsrv')->select($query);

		$headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
        ,   'Content-type'        => 'text/csv'
        ,   'Content-Disposition' => 'attachment; filename=tarjetas.csv'
        ,   'Expires'             => '0'
        ,   'Pragma'              => 'public'
		];
		$function_generate = function() use ($datos){
			$handle = fopen("php://output", 'w');
			$contador = 1;
			$texto = "";
			foreach($datos as $dato) {

				//$dato->n_cliente = utf8_encode($dato->n_cliente);
				fputcsv($handle, array(1, $dato->n_cliente, $dato->c_cliente, $dato->tarjeta,$dato->fecha_expiracion,$dato->monto,$dato->fecha,$dato->correo,$dato->motivo));
				$contador++;
				//fputcsv($handle, array());
			}
			fclose($handle);
		};
		//return print_r($datos, true);
		return \Response::stream($function_generate, 200, $headers);
		//return $function_generate;
	}

  public function generarCSVBaseBAC() {
		$query = "SET LANGUAGE Spanish;";
		DB::connection('sqlsrv')->select($query);

		$query = "SELECT CAST(c.c_cliente AS INT) colegiado,REPLACE(cast(REPLACE(c.n_cliente,'´','') as varchar(max)) collate SQL_Latin1_General_Cp1251_CS_AS,'?','') nombre,CONVERT(VARCHAR(10),c.f_ult_pago,120) fechaultimopago,CONVERT(VARCHAR(10),c.f_ult_timbre,120) fechaultimotimbre,115.75 montocolegio,CASE WHEN c.monto_timbre is NULL THEN 0 ELSE c.monto_timbre end montotimbre,115.75 + CASE WHEN c.monto_timbre is NULL THEN 0 ELSE c.monto_timbre end montototal FROM cc00 c where (DATEDIFF(month, c.f_ult_pago, GETDATE()) <= 3 and DATEDIFF(month, c.f_ult_timbre, GETDATE()) <= 3) and monto_timbre>0 AND c.topefechapagocuotas IS NULL AND CAST(c.c_cliente AS INT) < 999999";
		$datos = DB::connection('sqlsrv')->select($query);

		$headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
        ,   'Content-type'        => 'text/csv'
        ,   'Content-Disposition' => 'attachment; filename=tarjetas.csv'
        ,   'Expires'             => '0'
        ,   'Pragma'              => 'public'
		];
		$function_generate = function() use ($datos){
			$handle = fopen("php://output", 'w');
			$contador = 1;
			$texto = "";
			foreach($datos as $dato) {

				//$dato->n_cliente = utf8_encode($dato->n_cliente);
        fputs($handle, implode(array($dato->colegiado, $dato->nombre, $dato->fechaultimopago, $dato->fechaultimotimbre,$dato->montocolegio,$dato->montotimbre,$dato->montototal), ',')."\n");
				//fputcsv($handle, array($dato->colegiado, $dato->nombre, $dato->fechaultimopago, $dato->fechaultimotimbre,$dato->montocolegio,$dato->montotimbre,$dato->montototal),',',' ');
				$contador++;
				//fputcsv($handle, array());
			}
			fclose($handle);
		};
		//return print_r($datos, true);
		return \Response::stream($function_generate, 200, $headers);
		//return $function_generate;
	}

  public function utf8_encode_deep(&$input) {
    return 1;
    if (is_string($input)) {
      $input = utf8_encode($input);
    } else if (is_array($input)) {
      foreach ($input as &$value) {
        $this->utf8_encode_deep($value);
      }

      unset($value);
    } else if (is_object($input)) {
      $vars = array_keys(get_object_vars($input));

      foreach ($vars as $var) {
        $this->utf8_encode_deep($input->$var);
      }
    }
    return 1;
  }


  public function utf8_decode_deep(&$input) {
    return 1;
    if (is_string($input)) {
      $input = utf8_decode($input);
    } else if (is_array($input)) {
      foreach ($input as &$value) {
        $this->utf8_decode_deep($value);
      }

      unset($value);
    } else if (is_object($input)) {
      $vars = array_keys(get_object_vars($input));

      foreach ($vars as $var) {
        $this->utf8_decode_deep($input->$var);
      }
    }
    return 1;
  }

	public function generarCSVCarnet() {
		$colegiado = Input::get('idusuario');
		$query = "SET LANGUAGE Spanish;";
		DB::connection('sqlsrv')->select($query);

		$query = "UPDATE claves_colegiado SET fechaFinVigencia = GETDATE() WHERE colegiado = :colegiado AND fechaFinVigencia is null";
		$parametros = array(':colegiado' => $colegiado);
		$seleccion = DB::update($query, $parametros);

		$query = "INSERT INTO claves_colegiado(colegiado, clave, fechaInicioVigencia, fechaFinVigencia) VALUES(:colegiado, CONVERT(varchar(255), NEWID()), GETDATE(), NULL)";
		$parametros = array(':colegiado' => $colegiado);
		$seleccion = DB::insert($query, $parametros);

		$query = "select * from (SELECT CAST(c.c_cliente AS INTEGER) NUMERO_DE_COLEGIADO, NOMBRES, APELLIDOS, registro DPI, cp.n_profesion PROFESION, dbo.f_maestrias(c.c_cliente) MAESTRIA_O_DOCTORADO, 'P'+c.c_cliente+'.jpg' FOTO1,'S'+c.c_cliente+'.jpg' FIRMAS,
		RIGHT('0' + RTRIM(DAY(fecha_col)), 2) DIA, RIGHT('0' + RTRIM(MONTH(fecha_col)), 2) MES, DATEPART(yyyy,fecha_col) ANIO, u.n_universidad UNIVERSIDAD, cc.clave CODIGO FROM cc00 c INNER JOIN claves_colegiado cc ON cc.colegiado = c.c_cliente AND (DATEDIFF(month, c.f_ult_pago, GETDATE()) <=  3 and DATEDIFF(month, c.f_ult_timbre, GETDATE()) <= 3) AND cc.fechaFinVigencia IS NULL INNER JOIN universidades u ON c.c_universidad = u.c_universidad INNER JOIN universidades u1 ON c.c_universidad1 = u1.c_universidad INNER JOIN cc00prof cp ON c.c_cliente = cp.c_cliente) d
		where NUMERO_DE_COLEGIADO between :colegiado and :colegiado";
		$parametros = array(':colegiado' => $colegiado);
		$seleccion = DB::connection('sqlsrv')->select($query, $parametros);


		$headers = [
		'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
		,   'Content-type'        => 'text/csv'
		,   'Content-Disposition' => 'attachment; filename=carnet.csv'
		,   'Expires'             => '0'
		,   'Pragma'              => 'public'
		];

		$function_generate = function() use ($seleccion){
			$handle = fopen("php://output", 'w');
			$contador = 1;
			$texto = "";
//			fputcsv($handle, array('ID', 'COLEGIADO', 'NOMBRES', 'APELLIDOS','DPI','PROFESION','ESPECIALIZACION','FOTO','FIRMAS','DIA','MES',utf8_decode('AÑO'),'UNIVERSIDAD','CODIGO_DE_BARRA'));
			fputcsv($handle, array('FOTO', 'NOMBRES', 'APELLIDOS','DPI', 'FIRMA', 'ESPECIALIZACION', 'UNIVERSIDAD','DIA','MES',utf8_decode('AÑO'),'COLEGIADO','PROFESION'));
			foreach($seleccion as $dato) {
//				fputcsv($handle, array($contador, $dato->NUMERO_DE_COLEGIADO, utf8_decode($dato->NOMBRES),utf8_decode($dato->APELLIDOS),$dato->DPI,utf8_decode($dato->PROFESION),utf8_decode($dato->MAESTRIA_O_DOCTORADO),$dato->FOTO1,$dato->FIRMAS,$dato->DIA,$dato->MES,$dato->ANIO,utf8_decode($dato->UNIVERSIDAD),$dato->CODIGO));
				fputcsv($handle, array($dato->FOTO1, utf8_decode($dato->NOMBRES),utf8_decode($dato->APELLIDOS),$dato->DPI,$dato->FIRMAS,utf8_decode($dato->MAESTRIA_O_DOCTORADO), utf8_decode($dato->UNIVERSIDAD), $dato->DIA,$dato->MES,$dato->ANIO,$dato->NUMERO_DE_COLEGIADO, utf8_decode($dato->PROFESION)));
				$contador++;
			}
			fclose($handle);
		};
		return \Response::stream($function_generate, 200, $headers);
	}

  public function generarCSVCarnetRango() {
		$colegiado1 = Input::get('idusuario1');
    $colegiado2 = Input::get('idusuario2');
		$query = "SET LANGUAGE Spanish;";
		DB::connection('sqlsrv')->select($query);

		$query = "UPDATE claves_colegiado SET fechaFinVigencia = GETDATE() WHERE colegiado BETWEEN cast(:colegiado1 as int) AND cast(:colegiado2 as int) AND fechaFinVigencia is null";
		$parametros = array(':colegiado1' => $colegiado1,':colegiado2' => $colegiado2);
		$seleccion = DB::update($query, $parametros);

		$query = "INSERT INTO claves_colegiado(colegiado, clave, fechaInicioVigencia, fechaFinVigencia) SELECT c_cliente, CONVERT(varchar(255), NEWID()) descripcion, GETDATE() fecha, NULL f FROM cc00 WHERE c_cliente BETWEEN cast(:colegiado1 as int) AND cast(:colegiado2 as int)";
		$parametros = array(':colegiado1' => $colegiado1,':colegiado2' => $colegiado2);
		$seleccion = DB::insert($query, $parametros);

		$query = "select * from (SELECT CAST(c.c_cliente AS INTEGER) NUMERO_DE_COLEGIADO, NOMBRES, APELLIDOS, registro DPI, cp.n_profesion PROFESION, dbo.f_maestrias(c.c_cliente) MAESTRIA_O_DOCTORADO, 'P'+c.c_cliente+'.jpg' FOTO1,'S'+c.c_cliente+'.jpg' FIRMAS,
		RIGHT('0' + RTRIM(DAY(fecha_col)), 2) DIA, RIGHT('0' + RTRIM(MONTH(fecha_col)), 2) MES, DATEPART(yyyy,fecha_col) ANIO, u.n_universidad UNIVERSIDAD, cc.clave CODIGO FROM cc00 c INNER JOIN claves_colegiado cc ON cc.colegiado = c.c_cliente AND (DATEDIFF(month, c.f_ult_pago, GETDATE()) <=  3 and DATEDIFF(month, c.f_ult_timbre, GETDATE()) <= 3) AND cc.fechaFinVigencia IS NULL INNER JOIN universidades u ON c.c_universidad = u.c_universidad INNER JOIN universidades u1 ON c.c_universidad1 = u1.c_universidad INNER JOIN cc00prof cp ON c.c_cliente = cp.c_cliente) d
		where NUMERO_DE_COLEGIADO between cast(:colegiado1 as int) AND cast(:colegiado2 as int) ORDER BY NUMERO_DE_COLEGIADO";
		$parametros = array(':colegiado1' => $colegiado1,':colegiado2' => $colegiado2);
		$seleccion = DB::connection('sqlsrv')->select($query, $parametros);


		$headers = [
		'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
		,   'Content-type'        => 'text/csv'
		,   'Content-Disposition' => 'attachment; filename=tarjetas.csv'
		,   'Expires'             => '0'
		,   'Pragma'              => 'public'
		];

		$function_generate = function() use ($seleccion){
			$handle = fopen("php://output", 'w');
			$contador = 1;
			$texto = "";
//			fputcsv($handle, array('ID', 'COLEGIADO', 'NOMBRES', 'APELLIDOS','DPI','PROFESION','ESPECIALIZACION','FOTO','FIRMAS','DIA','MES',utf8_decode('AÑO'),'UNIVERSIDAD','CODIGO_DE_BARRA'));
			fputcsv($handle, array('FOTO', 'NOMBRES', 'APELLIDOS','DPI', 'FIRMA', 'ESPECIALIZACION', 'UNIVERSIDAD','DIA','MES',utf8_decode('AÑO'),'COLEGIADO','PROFESION'));
			foreach($seleccion as $dato) {
//				fputcsv($handle, array($contador, $dato->NUMERO_DE_COLEGIADO, utf8_decode($dato->NOMBRES),utf8_decode($dato->APELLIDOS),$dato->DPI,utf8_decode($dato->PROFESION),utf8_decode($dato->MAESTRIA_O_DOCTORADO),$dato->FOTO1,$dato->FIRMAS,$dato->DIA,$dato->MES,$dato->ANIO,utf8_decode($dato->UNIVERSIDAD),$dato->CODIGO));
				fputcsv($handle, array($dato->FOTO1, utf8_decode($dato->NOMBRES),utf8_decode($dato->APELLIDOS),$dato->DPI,$dato->FIRMAS,utf8_decode($dato->MAESTRIA_O_DOCTORADO), utf8_decode($dato->UNIVERSIDAD), $dato->DIA,$dato->MES,$dato->ANIO,$dato->NUMERO_DE_COLEGIADO, utf8_decode($dato->PROFESION)));
				$contador++;
			}
			fclose($handle);
		};
		return \Response::stream($function_generate, 200, $headers);
	}

  private function nombremes($mes){
    setlocale(LC_TIME, 'es_GT.UTF-8');
    $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000));
    return $nombre;
  }


	public function correo_por_inactivarse() {
    $query = "SELECT * from (select CAST(c_cliente AS INT) colegiado, n_cliente, telefono, CAST(f_ult_pago AS DATE) f_ult_pago, CAST(f_ult_timbre AS DATE) f_ult_timbre from cc00 c where (DATEDIFF(month, c.f_ult_pago, DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))) = 3 or DATEDIFF(month, c.f_ult_timbre, DATEADD(s,-1,DATEADD(mm, DATEDIFF(m,0,GETDATE())+1,0))) = 3) and (DATEDIFF(month, c.f_ult_pago, GETDATE()) <= 3 and DATEDIFF(month, c.f_ult_timbre, GETDATE()) <= 3) and c.fallecido='N') d order by colegiado";

    $users = DB::connection('sqlsrv')->select($query);
    $a = Excel::create('Listado_por_inactivarse_'.$this->nombremes(date('n')).'_'.date('Y'), function($excel) use($users) {

      $excel->sheet('Lista de colegiados', function($sheet) use($users) {

        $sheet->cell('A1', function($cell) {
          $cell->setValue("Colegiado");
        });


        $sheet->cell('B1', function($cell) {
          $cell->setValue("Nombre");
        });

        $sheet->cell('C1', function($cell) {
          $cell->setValue("Teléfono");
        });

        $sheet->cell('D1', function($cell) {
          $cell->setValue("Fecha de último pago de colegiatura");
        });

        $sheet->cell('E1', function($cell) {
          $cell->setValue("Fecha de último pago de timbre");
        });

        $i = 2;
        foreach($users as $user) {
          $user->n_cliente = $user->n_cliente;
          $sheet->cell('A'.$i, function($cell) use($user) {
            $cell->setValue($user->colegiado);
          });
          $sheet->cell('B'.$i, function($cell) use($user) {
            $cell->setValue($user->n_cliente);
          });
          $sheet->cell('C'.$i, function($cell) use($user) {
            $cell->setValue($user->telefono);
          });
          $sheet->cell('D'.$i, function($cell) use($user) {
            $cell->setValue($user->f_ult_pago);
          });
          $sheet->cell('E'.$i, function($cell) use($user) {
            $cell->setValue($user->f_ult_timbre);
          });
          $i++;
        }


      });
    })->store('xlsx', false, true);
    $sent = Mail::send('welcome2', array('key' => 'value'), function($message) use($a)
{
    $message->from('administrator@sistemacig.xyz', 'Sistema interno CIG');
    $message->to('info@cig.org.gt', 'Info CIG')->subject('Colegiados por inactivarse');
    $message->attach($a['full']);
});
}

public function correoCumpleaneros() {
  $query = "SELECT * from (select c_cliente, n_cliente, telefono, e_mail,  fecha_nac, datepart(day,fecha_nac) dia, datepart(year,getdate())-datepart(year,fecha_nac) edad from cc00 c where (DATEDIFF(month, c.f_ult_pago, GETDATE()) <= 3 and DATEDIFF(month, c.f_ult_timbre, GETDATE()) <= 3) and datepart(month,fecha_nac)=:mes ) d order by dia";
  $parametros = array(':mes' => date('n'));
  $users = DB::connection('sqlsrv')->select($query, $parametros);
  $a = Excel::create('Cumpleañeros_'.$this->nombremes(date('n')).'_'.date('Y'), function($excel) use($users) {

    $excel->sheet('Lista de colegiados', function($sheet) use($users) {

      $sheet->cell('A1', function($cell) {
        $cell->setValue("Colegiado");
      });


      $sheet->cell('B1', function($cell) {
        $cell->setValue("Nombre");
      });

      $sheet->cell('C1', function($cell) {
        $cell->setValue("Teléfono");
      });

      $sheet->cell('D1', function($cell) {
        $cell->setValue("Correo");
      });

      $sheet->cell('E1', function($cell) {
        $cell->setValue("Fecha de nacimiento");
      });

      $sheet->cell('F1', function($cell) {
        $cell->setValue("Día");
      });

      $sheet->cell('G1', function($cell) {
        $cell->setValue("Edad");
      });

      $i = 2;
      foreach($users as $user) {
        $user->n_cliente = $user->n_cliente;
        $sheet->cell('A'.$i, function($cell) use($user) {
          $cell->setValue($user->c_cliente);
        });
        $sheet->cell('B'.$i, function($cell) use($user) {
          $cell->setValue($user->n_cliente);
        });
        $sheet->cell('C'.$i, function($cell) use($user) {
          $cell->setValue($user->telefono);
        });
        $sheet->cell('D'.$i, function($cell) use($user) {
          $cell->setValue($user->e_mail);
        });
        $sheet->cell('E'.$i, function($cell) use($user) {
          $cell->setValue($user->fecha_nac);
        });
        $sheet->cell('F'.$i, function($cell) use($user) {
          $cell->setValue($user->dia);
        });
        $sheet->cell('G'.$i, function($cell) use($user) {
          $cell->setValue($user->edad);
        });
        $i++;
      }


    });
  })->store('xlsx', false, true);
  $sent = Mail::send('welcome2', array('key' => 'value'), function($message) use($a)
{
  $message->from('usuariocig@sistemacig.xyz', 'Sistema interno CIG');
  $message->to('info@cig.org.gt', 'Info CIG')->subject('Colegiados por inactivarse');
//  $message->to('desarrollo@cig.org.gt', 'Desarrollo')->subject('Cumpleañeros mes de '.$this->nombremes(date('n')));
  $message->attach($a['full']);
});
}

public function getListaMunicipios() {
  $term = Input::get('valMunicipio');
  $idDepartamento = Input::get('idDepartamento');
  $idPais = Input::get('idPais');
  $query = "SELECT c_mpo codigo, n_mpo nombre FROM mpo WHERE UPPER(n_mpo) LIKE UPPER('%'+:term+'%')";
  $parametros = array(':term' => $term);
  if(!empty($idDepartamento)) {
    $query .= " AND c_depto = :idDepartamento";
    $parametros[':idDepartamento'] = $idDepartamento;
  }
  if(!empty($idPais)) {
    $query .= " AND c_pais = :idPais";
    $parametros[':idPais'] = $idPais;
  }

  $instructores = DB::connection('sqlsrv')->select($query, $parametros);

  $instructores_array = array();
  foreach($instructores as $instructor) {
    $instructor->nombre = $instructor->nombre;
    $instructores_array[] = array("value" => $instructor->codigo, "label" => $instructor->nombre);
  }
  return json_encode($instructores_array);
}

public function getListaDepartamentos() {
  $term = Input::get('valDepartamento');
  $idPais = Input::get('idPais');
  $query = "SELECT c_depto codigo, n_depto nombre FROM deptos WHERE UPPER(n_depto) LIKE UPPER('%'+:term+'%')";
  $parametros = array(':term' => $term);
  if(!empty($idPais)) {
    $query .= " AND c_pais = :idPais";
    $parametros[':idPais'] = $idPais;
  }

  $instructores = DB::connection('sqlsrv')->select($query, $parametros);
  $instructores_array = array();
  foreach($instructores as $instructor) {
    $instructor->nombre = $instructor->nombre;
    $instructores_array[] = array("value" => $instructor->codigo, "label" => $instructor->nombre);
  }
  return json_encode($instructores_array);
}

public function getListaPaises() {
  $term = Input::get('valPais');
  $query = "SELECT c_pais codigo, n_pais nombre FROM pais WHERE UPPER(n_pais) LIKE UPPER('%'+:term+'%')";
  $parametros = array(':term' => $term);
  $instructores = DB::connection('sqlsrv')->select($query, $parametros);
  $instructores_array = array();
  foreach($instructores as $instructor) {
    $instructor->nombre = $instructor->nombre;
    $instructores_array[] = array("value" => $instructor->codigo, "label" => $instructor->nombre);
  }
  return json_encode($instructores_array);
}

public function getListaUniversidades() {
  $term = Input::get('valUniversidad');
  $query = "SELECT c_universidad codigo, n_universidad nombre FROM universidades WHERE UPPER(n_universidad) LIKE UPPER('%'+:term+'%')";
  $parametros = array(':term' => $term);
  $instructores = DB::connection('sqlsrv')->select($query, $parametros);
  $instructores_array = array();
  foreach($instructores as $instructor) {
    $instructor->nombre = $instructor->nombre;
    $instructores_array[] = array("value" => $instructor->codigo, "label" => $instructor->nombre);
  }
  return json_encode($instructores_array);
}

public function getDepartamentoPais() {
  $idMunicipio = Input::get('idMunicipio');
  $query = "SELECT d.c_depto codigodepartamento, d.n_depto departamento, p.c_pais codigopais, p.n_pais pais FROM mpo m INNER JOIN deptos d ON m.c_depto = d.c_depto INNER JOIN pais p ON m.c_pais = p.c_pais WHERE m.c_mpo = :idMunicipio";
  $parametros = array(':idMunicipio' => $idMunicipio);
  $resultado = DB::connection('sqlsrv')->select($query, $parametros);
  $resultadoR = null;
  foreach($resultado as $fila) {
    $resultadoR = $fila;
  }
  $resultadoR->departamento = $resultadoR->departamento;
  $resultadoR->pais = $resultadoR->pais;
  return json_encode($resultadoR);
}

public function getPais() {
  $idDepartamento = Input::get('idDepartamento');
  $query = "SELECT p.c_pais codigopais, p.n_pais pais FROM deptos d INNER JOIN pais p ON d.c_pais = p.c_pais WHERE d.c_depto = :idDepartamento";
  $parametros = array(':idDepartamento' => $idDepartamento);
  $resultado = DB::connection('sqlsrv')->select($query, $parametros);
  $resultadoR = null;
  foreach($resultado as $fila) {
    $resultadoR = $fila;
  }
  $resultadoR->pais = $resultadoR->pais;
  return json_encode($resultadoR);
}

public function pruebaexcel() {

      $a = Excel::create('Listado_curso', function($excel) {

        $excel->sheet('Lista de colegiados', function($sheet) {

          $sheet->cell('A1', function($cell) {
            $cell->setValue("Colegiado");
          });


          $sheet->cell('B1', function($cell) {
            $cell->setValue("Nombre");
          });

          $sheet->cell('C1', function($cell) {
            $cell->setValue("Apellidos");
          });


        });
      })->store('xlsx', false, true);
      return $a['full'];
}

public function actualizarVisanet() {
  try{
//        $conn = new PDO('mysql:host=50.62.209.117;dbname=cig_DB1', 'CIGUser1', '$Cjg_GUaT3m7LA');
        $conn = new PDO('mysql:host=192.168.1.16;dbname=cig_DB1', 'CIGUser1', '$Cjg_GUaT3m7LA');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $gsent = $conn->prepare("CALL Sesion_Usuarios()");
        $gsent->execute();
  } catch(PDOException $e){
        echo "ERROR: " . $e->getMessage();
  }

}


public function busquedaEspecialidadAutocomplete() {
  $term = Input::get('term');
  $resultado = $this->busquedaEspecialidadRaw($term);
  $resultado_array = array();
  foreach($resultado as $fila) {
    $resultado_array[] = array("value" => $fila->id, "label" => $fila->nombre);
  }
  return json_encode($resultado_array);
}

public function busquedaProfesionAutocomplete() {
  $term = Input::get('term');
  $resultado = $this->busquedaProfesionRaw($term);
  $resultado_array = array();
  foreach($resultado as $fila) {
    $resultado_array[] = array("value" => $fila->id, "label" => $fila->nombre);
  }
  return json_encode($resultado_array);
}

public function pruebapdf() {
  $query = "SELECT n_especialidad especialidad FROM cc00espec WHERE c_cliente='5520'";
  $resultado = DB::connection('sqlsrv')->select($query);
  $this->utf8_encode_deep($resultado);
  $resultadoString = "<ul>";
  foreach($resultado as $fila) {
    $resultadoString .= "<li>" . $fila->especialidad . "</li>";
  }
  $resultadoString .= "</ul>";
    $pdf = PDF::loadHTML('<h1>Test</h1>' . $resultadoString);
return $pdf->download('invoice.pdf');
}

public function correoActivos() {
  $query = "SELECT * from (select cast(c_cliente as int) colegiado, n_cliente, dbo.f_profesiones(c.c_cliente) profesion, d.n_votacion from cc00 c LEFT JOIN deptos1 d ON c.c_deptotrab = d.c_depto where (DATEDIFF(month, c.f_ult_pago, GETDATE()) <= 3 and DATEDIFF(month, c.f_ult_timbre, GETDATE()) <= 3) ) d order by colegiado";
  $users = DB::connection('sqlsrv')->select($query);
  $a = Excel::create('Activos_'.$this->nombremes(date('n')).'_'.date('Y'), function($excel) use($users) {

    $excel->sheet('Lista de colegiados', function($sheet) use($users) {

      $sheet->cell('A1', function($cell) {
        $cell->setValue("Colegiado");
      });


      $sheet->cell('B1', function($cell) {
        $cell->setValue("Nombre");
      });

      $sheet->cell('C1', function($cell) {
        $cell->setValue("Profesiones");
      });

      $sheet->cell('D1', function($cell) {
        $cell->setValue("Lugar votacion");
      });

      $i = 2;
      foreach($users as $user) {
        $user->n_cliente = $user->n_cliente;
        $sheet->cell('A'.$i, function($cell) use($user) {
          $cell->setValue($user->colegiado);
        });
        $sheet->cell('B'.$i, function($cell) use($user) {
          $cell->setValue($user->n_cliente);
        });
        $sheet->cell('C'.$i, function($cell) use($user) {
          $cell->setValue($user->profesion);
        });
        $sheet->cell('D'.$i, function($cell) use($user) {
          $cell->setValue($user->n_votacion);
        });
        $i++;
      }


    });
  })->store('xlsx', false, true);
  $sent = Mail::send('welcome2', array('key' => 'value'), function($message) use($a)
{
  $message->from('usuariocig@sistemacig.xyz', 'Sistema interno CIG');
  $message->to('desarrollo@cig.org.gt', 'Desarrollo');
  $message->to('informatica@cig.org.gt', 'Computo CIG');
  $message->to('tribunalelectoral@cig.org.gt', 'Tribunal Electoral');
  //$message->to('@cig.org.gt', 'Info CIG');
  $message->subject('Colegiados activos');
//  $message->to('desarrollo@cig.org.gt', 'Desarrollo')->subject('Cumpleañeros mes de '.$this->nombremes(date('n')));
  $message->attach($a['full']);
});
}

public function padronSeparado() {
  $query = "SELECT * from (select cast(c_cliente as int) colegiado, n_cliente, dbo.f_profesiones(c.c_cliente) profesion, d.n_votacion, d.n_depto from cc00 c LEFT JOIN deptos1 d ON c.c_deptotrab = d.c_depto where (DATEDIFF(month, c.f_ult_pago, GETDATE()) <= 3 and DATEDIFF(month, c.f_ult_timbre, GETDATE()) <= 3) ) d order by d.n_depto";
  $users = DB::connection('sqlsrv')->select($query);
  $a = Excel::create('Activos_'.$this->nombremes(date('n')).'_'.date('Y'), function($excel) use($users) {
    foreach($users as $user) {
      $excel->sheet('Lista de colegiados', function($sheet) use($users) {

        $sheet->cell('A1', function($cell) {
          $cell->setValue("Colegiado");
        });


        $sheet->cell('B1', function($cell) {
          $cell->setValue("Nombre");
        });

        $sheet->cell('C1', function($cell) {
          $cell->setValue("Profesiones");
        });

        $sheet->cell('D1', function($cell) {
          $cell->setValue("Lugar votacion");
        });

        $i = 2;

          $user->n_cliente = $user->n_cliente;
          $sheet->cell('A'.$i, function($cell) use($user) {
            $cell->setValue($user->colegiado);
          });
          $sheet->cell('B'.$i, function($cell) use($user) {
            $cell->setValue($user->n_cliente);
          });
          $sheet->cell('C'.$i, function($cell) use($user) {
            $cell->setValue($user->profesion);
          });
          $sheet->cell('D'.$i, function($cell) use($user) {
            $cell->setValue($user->n_votacion);
          });
          $i++;



      });
    }
  })->store('xlsx', false, true);
  $sent = Mail::send('welcome2', array('key' => 'value'), function($message) use($a)
{
  $message->from('usuariocig@sistemacig.xyz', 'Sistema interno CIG');
  $message->to('desarrollo@cig.org.gt', 'Desarrollo');
  $message->to('computo@cig.org.gt', 'Computo CIG');
  //$message->to('tribunalelectoral@cig.org.gt', 'Tribunal Electoral');
  //$message->to('@cig.org.gt', 'Info CIG');
  $message->subject('Colegiados activos');
//  $message->to('desarrollo@cig.org.gt', 'Desarrollo')->subject('Cumpleañeros mes de '.$this->nombremes(date('n')));
  $message->attach($a['full']);
});
}


public function getExcelColegiados() {
  $query = "SELECT CAST(c.c_cliente AS INT) colegiado, c.nombres, c.apellidos,
  dbo.f_profesiones(c.c_cliente) profesion, u.n_universidad universidad, c.registro, c.telefono, c.e_mail, CAST(c.fecha_col AS DATE) fechacol
  WHERE CAST(c.c_cliente AS INT) BETWEEN :minimo AND :maximo ORDER BY CAST(c.c_cliente AS INT)
  ";
  $parametros = array(':minimo' => $minimo, ':maximo' => $maximo);
  $users = DB::connection('sqlsrv')->select($query, $parametros);
  $a = Excel::create('Listado del '.$minimo. ' al ' . $maximo, function($excel) use($users) {

    $excel->sheet('Listado del '.$minimo. ' al ' . $maximo, function($sheet) use($users) {

      $sheet->cell('A1', function($cell) {
        $cell->setValue("Colegiado");
      });


      $sheet->cell('B1', function($cell) {
        $cell->setValue("Nombre");
      });

      $sheet->cell('C1', function($cell) {
        $cell->setValue("Apellidos");
      });

      $sheet->cell('D1', function($cell) {
        $cell->setValue("Profesión");
      });

      $sheet->cell('E1', function($cell) {
        $cell->setValue("Universidad");
      });

      $sheet->cell('F1', function($cell) {
        $cell->setValue("DPI");
      });

      $sheet->cell('G1', function($cell) {
        $cell->setValue("Teléfono");
      });

      $sheet->cell('H1', function($cell) {
        $cell->setValue("Correo");
      });

      $sheet->cell('F1', function($cell) {
        $cell->setValue("Fecha de colegiado");
      });

      $i = 2;
      foreach($users as $user) {
        $user->nombres = $user->nombres;
        $user->apellidos = $user->apellidos;
        $sheet->cell('A'.$i, function($cell) use($user) {
          $cell->setValue($user->colegiado);
        });
        $sheet->cell('B'.$i, function($cell) use($user) {
          $cell->setValue($user->nombres);
        });
        $sheet->cell('C'.$i, function($cell) use($user) {
          $cell->setValue($user->apellidos);
        });
        $sheet->cell('D'.$i, function($cell) use($user) {
          $cell->setValue($user->profesion);
        });
        $sheet->cell('E'.$i, function($cell) use($user) {
          $cell->setValue($user->universidad);
        });
        $sheet->cell('F'.$i, function($cell) use($user) {
          $cell->setValue($user->registro);
        });
        $sheet->cell('G'.$i, function($cell) use($user) {
          $cell->setValue($user->telefono);
        });
        $sheet->cell('G'.$i, function($cell) use($user) {
          $cell->setValue($user->telefono);
        });
        $i++;
      }


    });
  })->store('xlsx', false, true);
  $sent = Mail::send('welcome2', array('key' => 'value'), function($message) use($a)
{
  $message->from('administrator@sistemacig.xyz', 'Sistema interno CIG');
  $message->to('info@cig.org.gt', 'Info CIG')->subject('Colegiados por inactivarse');
  $message->attach($a['full']);
});
}


public function concexcel($id) {
//	return (new InvoicesExport2)->forYear(2332)->download('invoices.xlsx');
	return Excel::download(new InvoicesExport3(2332), 'export.xlsx');
}

/*require_once "Mail.php";


		$from = "Administrador <administrator@sistemacig.xyz>";
$to = "sdf <claj314@gmail.com>";
$subject = "Prueba de correo\r\n\r\n";
$body = "Mensaje desde PHP.";

$host = "mail.sistemacig.xyz";
$username = "usuariocig";
$password = "usuariocig123!!1";

$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'auth' => true,
    'username' => $username,
    'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
} else {
  echo("<p>Message successfully sent!</p>");
}*/
}

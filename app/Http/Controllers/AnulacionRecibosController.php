<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Mail\SolicitudAnulacionRecibo;
use Carbon\Carbon;
use App\User;
use Mail;
use Validator;

class AnulacionRecibosController extends Controller
{
    public function solicitudAnulacion(Request $request)
    {
        $id = $this->detelleRecibo(intval($request->recibo));
        return $id;
    }

    public function index()
    {
        return view('admin.anulacionrecibo.index');
    }

    public function getJson(Request $params)
    {
        $idCajero = Auth::user()->id;
        $query = "SELECT a.id as id, a.recibo_id as recibo, rc.numero_de_identificacion as colegiado, rc.nombre, u.name as cajero, a.fecha_solicitud as fecha_respuesta, ea.estado_recibo as estado
        FROM sigecig_anulacion a
        INNER JOIN sigecig_recibo_maestro rc ON a.recibo_id = rc.id
        INNER JOIN sigecig_users u ON a.usuario_cajero_id = u.id
        INNER JOIN sigecig_estados_anulacion_recibos ea ON a.estado_recibo_id = ea.id
        WHERE usuario_cajero_id = $idCajero";

        $api_Result['data'] = DB::select($query);
        return Response::json( $api_Result );
    }

    public function tracking($id)
    {
        $id = intval($id);
        $consulta = \App\Anulacion::select('sigecig_anulacion.fecha_solicitud','sigecig_anulacion.fecha_aprueba_rechazo','e.estado_recibo','u1.name as cajero','u2.name as conta')->where('sigecig_anulacion.id',$id)
                    ->leftjoin('sigecig_estados_anulacion_recibos as e', 'sigecig_anulacion.estado_recibo_id', '=', 'e.id')
                    ->leftjoin('sigecig_users as u1', 'sigecig_anulacion.usuario_cajero_id', '=', 'u1.id')
                    ->leftjoin('sigecig_users as u2', 'sigecig_anulacion.usuario_aprueba_rechaza', '=', 'u2.id')->get()->first();

        return view('admin.anulacionrecibo.tracking', compact('consulta'));
    }

    public function detalleRecibo($id)
    {
        $id = intval($id);

        $idCajero = Auth::user()->id;
        $consultaSede = "SELECT ss.nombre_sede FROM sigecig_cajas sc INNER JOIN sigecig_subsedes ss ON sc.subsede = ss.id WHERE sc.cajero = $idCajero";
        $sede = DB::select($consultaSede);

        //detalles del recibo
        $query= "SELECT rd.id, rd.codigo_compra, tp.tipo_de_pago, rd.cantidad, rd.total
                FROM sigecig_recibo_detalle rd
                INNER JOIN sigecig_tipo_de_pago tp ON rd.codigo_compra = tp.codigo
                WHERE rd.numero_recibo = $id";
        $detalles = DB::select($query);
        //datos del recibo maestro
        $consulta= "SELECT m.*, s.serie_recibo as serie FROM sigecig_recibo_maestro m INNER JOIN sigecig_serie_recibo s ON m.serie_recibo_id = s.id WHERE numero_recibo = $id";
        $datos = DB::select($consulta);

        if (sizeof($datos) != null){
            if ($datos[0]->tipo_de_cliente_id == 1) {
                $cliente = 'colegiado';
                $codigo = \App\CC00::where('c_cliente',$datos[0]->numero_de_identificacion)->get()->first();
            }
            if ($datos[0]->tipo_de_cliente_id == 2) {
                $cliente = 'particular';
                $codigo = $datos[0]->numero_de_identificacion;
            }

            if ($datos[0]->tipo_de_cliente_id == 3) {
                $cliente = 'empresa';
                $codigo = \App\SQLSRV_Empresa::where('nit',$datos[0]->numero_de_identificacion)->get()->first();
            }

            return view('admin.anulacionrecibo.recibodetalle', compact('datos','detalles','cliente','id','codigo','sede'));
        } else {
            return 'Cadena Vacia - No existe este número de recibo: <b>'.$id.'</b>';
        }
    }

    public function peticionSolicitudAnulacion(Request $request)
    {
        $id = intval($request->recibo);

        $idCajero = Auth::user()->id;
        $consultaSede = "SELECT ss.nombre_sede FROM sigecig_cajas sc INNER JOIN sigecig_subsedes ss ON sc.subsede = ss.id WHERE sc.cajero = $idCajero";
        $sede = DB::select($consultaSede);

        //detalles del recibo
        $query= "SELECT rd.id, rd.codigo_compra, tp.tipo_de_pago, rd.cantidad, rd.total
                FROM sigecig_recibo_detalle rd
                INNER JOIN sigecig_tipo_de_pago tp ON rd.codigo_compra = tp.codigo
                WHERE rd.numero_recibo = $id";
        $detalles = DB::select($query);
        //datos del recibo maestro
        $consulta= "SELECT m.*, s.serie_recibo as serie FROM sigecig_recibo_maestro m INNER JOIN sigecig_serie_recibo s ON m.serie_recibo_id = s.id WHERE numero_recibo = $id";
        $datos = DB::select($consulta);

        if (sizeof($datos) != null){
            if ($datos[0]->estado_recibo_id == 1) {
                if ($datos[0]->tipo_de_cliente_id == 1) {
                    $cliente = 'colegiado';
                    $codigo = \App\CC00::where('c_cliente',$datos[0]->numero_de_identificacion)->get()->first();
                }
                if ($datos[0]->tipo_de_cliente_id == 2) {
                    $cliente = 'particular';
                    $codigo = $datos[0]->numero_de_identificacion;
                }

                if ($datos[0]->tipo_de_cliente_id == 3) {
                    $cliente = 'empresa';
                    $codigo = \App\SQLSRV_Empresa::where('nit',$datos[0]->numero_de_identificacion)->get()->first();
                }

                return view('admin.anulacionrecibo.detallereciboanulacion', compact('datos','detalles','cliente','id','codigo','sede'));
            } elseif ($datos[0]->estado_recibo_id == 2) {
                return 'Recibo en Revision -  número de recibo <b>'.$id.'</b> ya cuenta con una solicitud pendiente!';
            }
        } else {
            return 'Cadena Vacia - No existe este número de recibo: <b>'.$id.'</b>';
        }
    }

    public function saveSolicitudAnulacion(Request $request)
    {
        $guardar = new \App\Anulacion;
        $guardar->fecha_solicitud = now();
        $guardar->razon_solicitud = $request->solicitud;
        $guardar->usuario_cajero_id = $request->idCajero;
        $guardar->recibo_id = $request->numeroRecibo;
        $guardar->estado_recibo_id = 1;
        $guardar->save();

        $recibo = \App\Recibo_Maestro::where('numero_recibo',$request->numeroRecibo)->orderBy('id', 'DESC')->first(); //Actualizacion de estado al recibo Maestro
        $recibo->estado_recibo_id = 2;
        $recibo->update();

        $idAnulacion = $guardar->id;
        $idCajero = Auth::user()->id;
        $tipo = 'solicitud';
        $reciboMaestro = $guardar->recibo_id;
        $cajero = Auth::user()->name;
        $link = 'http://localhost:8000/respuestaSolicitudAnulacion?id='.$idAnulacion;
        $envio = 'cajero';
        $fecha_actual = date_format(Now(), 'd-m-Y');
        $infoCorreoRecibo = new \App\Mail\SolicitudAnulacionRecibo($fecha_actual, $reciboMaestro, $tipo, $cajero, $link);
        $infoCorreoRecibo->subject('Anulacion de Recibo Electrónico No.' . $reciboMaestro);
        $infoCorreoRecibo->from('cigenlinea@cig.org.gt', 'CIG');
        Mail::to('desarrollo1@cig.org.gt')->send($infoCorreoRecibo);

        return redirect()->route('dashboard')->withFlash('Solicitud de Anulación se creo exitosamente!');
    }

    public function respuestaSolicitudAnulacion(Request $request)
    {
        $idAnulacion = intval($request->id);
        $solicitud = \App\Anulacion::where('id',$idAnulacion)->get()->first();

        if (!empty($solicitud)) {
            // datos del cajero que realiza la solicitud
            $idMaestro = $solicitud->recibo_id;
            $idCajero = $solicitud->usuario_cajero_id;
            $consultaSede = "SELECT ss.nombre_sede, us.name FROM sigecig_cajas sc INNER JOIN sigecig_subsedes ss ON sc.subsede = ss.id INNER JOIN sigecig_users us ON sc.cajero = us.id WHERE sc.cajero = $idCajero";
            $datosCajero = DB::select($consultaSede);

            //detalles del recibo
            $query= "SELECT rd.id, rd.codigo_compra, tp.tipo_de_pago, rd.cantidad, rd.total
                    FROM sigecig_recibo_detalle rd
                    INNER JOIN sigecig_tipo_de_pago tp ON rd.codigo_compra = tp.codigo
                    WHERE rd.numero_recibo = $idMaestro";
            $detalles = DB::select($query);
            //datos del recibo maestro
            $consulta= "SELECT m.*, s.serie_recibo as serie FROM sigecig_recibo_maestro m INNER JOIN sigecig_serie_recibo s ON m.serie_recibo_id = s.id WHERE numero_recibo = $idMaestro";
            $datos = DB::select($consulta);

            if (sizeof($datos) != null){
                if ($datos[0]->tipo_de_cliente_id == 1) {
                    $cliente = 'colegiado';
                    $codigo = \App\CC00::where('c_cliente',$datos[0]->numero_de_identificacion)->get()->first();
                }
                if ($datos[0]->tipo_de_cliente_id == 2) {
                    $cliente = 'particular';
                    $codigo = $datos[0]->numero_de_identificacion;
                }
                if ($datos[0]->tipo_de_cliente_id == 3) {
                    $cliente = 'empresa';
                    $codigo = \App\SQLSRV_Empresa::where('nit',$datos[0]->numero_de_identificacion)->get()->first();
                }

                // datos del contador
                if ($solicitud->fecha_aprueba_rechazo == null) {
                    $tieneRespuesta = 'no';
                    $idContador = Auth::user()->id;
                    $nombreContador = Auth::user()->name;
                } else {
                    $tieneRespuesta = 'si';
                    $contador = \App\User::where('id',$solicitud->usuario_aprueba_rechaza)->get()->first();
                    $idContador = $contador->id;
                    $nombreContador = $contador->name;
                }

                return view('admin.anulacionrecibo.respuestaanulaciondetalle', compact('solicitud','datos','detalles','cliente','idMaestro','codigo','datosCajero','idAnulacion','idContador','nombreContador','tieneRespuesta'));
            } else {
                return 'Cadena Vacia - No existe este número de solicitud de Anulación: <b>'.$idAnulacion.'</b>';
            }
        } else {
            return 'Cadena Vacia - No existe este número de solicitud de Anulación: <b>'.$idAnulacion.'</b>';
        }
    }

    public function saveRespuestaAnulacion(Request $request)
    {
        // $this->regresoRecibo($request);

        $id = $request->idAnulacion;
        $idRecibo = $request->numeroRecibo;
        $anulacion = \App\Anulacion::where('id',$id)->orderBy('id', 'DESC')->first();

        $anulacion->estado_recibo_id = $request->tipoRespuesta;
        $anulacion->fecha_aprueba_rechazo = now();
        $anulacion->usuario_aprueba_rechaza = Auth::user()->id;
        $anulacion->razon_rechazo = $request->respuesta;
        $anulacion->update();

        $recibo = \App\Recibo_Maestro::where('numero_recibo',$idRecibo)->orderBy('id', 'DESC')->first(); //Actualizacion de estado al recibo Maestro
        if ( $request->tipoRespuesta == 2) {
            $cajero = 'Aceptada';
            $recibo->estado_recibo_id = 3;
            $recibo->update();

            $this->regresoRecibo($request);

        } else {
            $cajero = 'Rechazada';
            $recibo->estado_recibo_id = 1;
            $recibo->update();
        }

        $idAnulacion = $id;
        $idCajero = Auth::user()->id;
        $tipo = 'respuesta';
        $reciboMaestro = $request->numeroRecibo;
        // $cajero = Auth::user()->name;
        $link = 'http://localhost:8000/respuestaSolicitudAnulacion?id='.$id;
        $fecha_actual = date_format(Now(), 'd-m-Y');
        $infoCorreoRecibo = new \App\Mail\SolicitudAnulacionRecibo($fecha_actual, $reciboMaestro, $tipo, $cajero, $link);
        $infoCorreoRecibo->subject('Respuesta de Anulación de Recibo Electrónico No.' . $reciboMaestro);
        $infoCorreoRecibo->from('cigenlinea@cig.org.gt', 'CIG');
        Mail::to('desarrollo1@cig.org.gt')->send($infoCorreoRecibo);

        return redirect()->route('dashboard')->withFlash('Solicitud de Anulación se creo exitosamente!');
    }

    public function regresoRecibo($request)
    {
        $idRecibo = $request->numeroRecibo;

        $recibo = \App\Recibo_Maestro::where('numero_recibo',$idRecibo)->get()->first();

        $query = "SELECT * FROM sigecig_recibo_detalle WHERE numero_recibo = $idRecibo";
        $array = DB::select($query);

        if ( $recibo->tipo_de_cliente_id = 1) {
            $colegiado = $recibo->numero_de_identificacion;
            $datosColegiado = \App\CC00::where('c_cliente',$colegiado)->get()->first();

            $cantMensualidadColegiatura = 0;
            $cantPrecioTimbre = 0;
            $montoTimbre = 0;
            for ($i = 0; $i < sizeof($array); $i++) {
                $dato=$array[$i]->codigo_compra;
                if ($dato == 'COL092'){
                    $cantMensualidadColegiatura += $array[$i]->cantidad;
                    $this->regresoEstadoDeCuenta($array[$i], $request);
                }
                if ( substr($dato,0,2) == 'TC' || substr($dato,0,2) == 'TE' || substr($array[$i][1],0,3) == 'TIM'){
                    $this->regresoTimbres($array[$i], $request);
                    $this->regresoEstadoDeCuenta($array[$i], $request);
                    $cantPrecioTimbre += $array[$i]->total;
                }
            }

            if ($cantMensualidadColegiatura != 0) {
                $valMesesASumar = $cantMensualidadColegiatura;
                $fechaPagoColegio = new Carbon($datosColegiado->f_ult_pago);
                $nuevaFecha = $fechaPagoColegio->startofMonth()->subMonths($valMesesASumar-1)->subSeconds(1)->toDateTimeString();
                $nuevaFecha = date('Y-m-d h:i:s', strtotime($nuevaFecha));
                $query = "UPDATE cc00 SET f_ult_pago = :nuevaFecha WHERE c_cliente = :colegiado";
                $parametros = array(
                    ':nuevaFecha' => $nuevaFecha, ':colegiado' => $colegiado
                );
                $result = DB::connection('sqlsrv')->update($query, $parametros);
            }

            if($cantPrecioTimbre != 0){
                $montoTimbre = $datosColegiado->monto_timbre;
                $cantMensualidades = $cantPrecioTimbre / $montoTimbre;
                $fechaPagoTimbre = new Carbon($datosColegiado->f_ult_timbre);
                $nuevaFecha = $fechaPagoTimbre->startofMonth()->subMonths($cantMensualidades-1)->subSeconds(1)->toDateTimeString();
                $nuevaFecha = date('Y-m-d h:i:s', strtotime($nuevaFecha));
                $query = "UPDATE cc00 SET f_ult_timbre = :nuevaFecha WHERE c_cliente = :colegiado";
                $parametros = array(
                    ':nuevaFecha' => $nuevaFecha, ':colegiado' => $colegiado
                );
                $result = DB::connection('sqlsrv')->update($query, $parametros);
            }

        } else {

        }
    }

    public function regresoTimbres($array, $request)
    {
        $tipoPago = \App\TipoDePago::where('codigo',$array->codigo_compra)->get()->first();
        if ($tipoPago->categoria_id == 1){
            $numeracion = \App\VentaDeTimbres::where('recibo_detalle_id',$array->id)->get()->first();
            $tipoProducto = \App\TiposDeProductos::where('tipo_de_pago_id',$tipoPago->id)->get()->first();
            $cajaBodega = \App\Cajas::where('cajero',$request->idCajero)->get()->first();

            $ingresoPro = new \App\IngresoProducto;
            $ingresoPro->timbre_id          = $tipoProducto->timbre_id;
            $ingresoPro->cantidad           = $array->cantidad;
            $ingresoPro->numeracion_inicial = $numeracion->numeracion_inicial;
            $ingresoPro->numeracion_final   = $numeracion->numeracion_final;
            $ingresoPro->bodega_id          = $cajaBodega->bodega;
            $ingresoPro->save();
        }
    }

    public function regresoEstadoDeCuenta($array, $request)
    {
        $tipoPago = \App\TipoDePago::where('codigo',$array->codigo_compra)->get()->first();

        $estadoDetalle = \App\EstadoDeCuentaDetalle::where('recibo_id',$array->id)->get()->first();
        $estadoDetalle->estado_id = 2;
        $estadoDetalle->update();
    }
}

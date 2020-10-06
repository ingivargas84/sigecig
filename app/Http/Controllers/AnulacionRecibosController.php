<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
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
        $query = "SELECT a.recibo_id as recibo, rc.numero_de_identificacion as colegiado, rc.nombre, u.name as cajero, a.fecha_solicitud as fecha_respuesta, ea.estado_recibo as estado
        FROM sigecig_anulacion a
        INNER JOIN sigecig_recibo_maestro rc ON a.recibo_id = rc.id
        INNER JOIN sigecig_users u ON a.usuario_cajero_id = u.id
        INNER JOIN sigecig_estados_anulacion_recibos ea ON a.estado_recibo_id = ea.id
        WHERE usuario_cajero_id = $idCajero";

        $api_Result['data'] = DB::select($query);
        return Response::json( $api_Result );
    }

    public function tracking()
    {
        return view('admin.anulacionrecibo.tracking');
    }

    public function detelleRecibo(Request $request)
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

        $tipo = $request->tipoDeCliente;
        $reciboMaestro = $guardar->recibo_id;
        $fecha_actual = date_format(Now(), 'd-m-Y');
        $infoCorreoRecibo = new \App\Mail\EnvioReciboElectronico($fecha_actual, $reciboMaestro, $tipo);
        $infoCorreoRecibo->subject('Anulacion de Recibo Electrónico No.' . $reciboMaestro->numero_recibo);
        $infoCorreoRecibo->from('cigenlinea@cig.org.gt', 'CIG');
        Mail::to('desarrollo1@cig.org.gt')->send($infoCorreoRecibo);

        return redirect()->route('dashboard')->withFlash('Solicitud de Anulación se creo exitosamente!');
    }
}

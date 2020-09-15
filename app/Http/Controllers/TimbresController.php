<?php

namespace App\Http\Controllers;

use App\Bodegas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use \App\Cajas;
use App\IngresoProducto;
use \App\Subsedes;
use \App\User;
use \App\SigecigTimbres;
use \App\Recibo_Maestro;
use App\TipoDePago;
use App\TiposDeProductos;
use App\TraspasoDetalle;
use App\TraspasoMaestro;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;
use NumeroALetras;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TimbresController extends Controller
{
    public function reporteTimbres(Request $request){

        ////

        $user = Auth::User();
        $fechaInicial=Carbon::parse($request->fechaInicial)->startOfDay()->toDateString();
        $fechaFinal=Carbon::parse($request->fechaFinal)->endOfDay()->toDateString();
        $diaAnteriorInicial=Carbon::parse($request->fechaInicial)->startOfDay()->subSecond()->toDateString();
        $tipoPagos= TipoDePago::where('categoria_id',1)->get();
        $caja = Cajas::where('id',$request->cajaActiva)->get()->first();
        // $bodega = Bodegas::where('i')
        $subsede = Subsedes::select('id','nombre_sede')->where('id',$caja->subsede)->get()->first();
        $cajero = User::select('name','id')->where('id',$caja->cajero)->get()->first();

        //tipo de pago general
        $pagos = SigecigTimbres::all();
        $arrayDatos = array();
        foreach ($pagos as $key => $pago) {
            $producto = TiposDeProductos::where('timbre_id',$pago->id)->get()->first();
            $precio = TipoDePago::select('precio_colegiado')->where('id',$producto->tipo_de_pago_id)->get()->first();
            $detalle = new \stdClass();
            $remesa=0;
            $valorRemesa = 0;
            $cantidad=0;
            $valorExistenciaAnterior = 0;
            $timbresVendidos = 0;
            $valorTimbresVendidos = 0;
            $saldoActual = 0;
            $valorSaldoActual = 0;
            $totalGeneralExistenciaAnterior = 0;
            $totalGeneralValorExistenciaAnterior=0;
            $totalGeneralRemesa= 0;
            $totalGeneralValorRemesa=0;
            $totalGeneralVentaActual=0;
            $totalGeneralValorVentaActual = 0;
            $totalGeneralSaldoActual = 0;
            $totalGeneralValorSaldoActual = 0;
            $existencias = IngresoProducto::select('timbre_id','cantidad')->where('timbre_id',$pago->id)->where('bodega_id',$caja->bodega)->where('cantidad','!=', 0)
            ->where('created_at','<',$fechaInicial)->get();

            $queryTipoPagos= "SELECT tipoPago.codigo
            FROM sigecig_tipo_de_pago tipoPago
            INNER JOIN sigecig_tipos_de_productos tipoProducto ON tipoProducto.tipo_de_pago_id = tipoPago.id
            WHERE tipoProducto.timbre_id = $pago->id;";
            $tipoPagosCategorias = DB::select($queryTipoPagos);
            foreach ($tipoPagosCategorias as $key => $tipoPagosCategoria) {
                $ventaTimbres= "SELECT reciboDetalle.cantidad, reciboDetalle.codigo_compra, reciboDetalle.total
                FROM sigecig_recibo_maestro reciboMaestro
                INNER JOIN sigecig_recibo_detalle reciboDetalle ON reciboDetalle.numero_recibo = reciboMaestro.numero_recibo
                WHERE reciboMaestro.usuario = $caja->cajero AND reciboDetalle.codigo_compra = '$tipoPagosCategoria->codigo'
                AND DATE(reciboDetalle.created_at) BETWEEN CAST('$fechaInicial' AS DATE) AND CAST('$fechaFinal' AS DATE);";
                $ventaMaestro = DB::select($ventaTimbres);
                if (!empty($ventaMaestro)) {
                    foreach ($ventaMaestro as $key => $venta) {
                        $timbresVendidos += $venta->cantidad;
                    }
                }
            }

            $query= "SELECT traspasoMaestro.id, traspasoDetalle.cantidad_a_traspasar
            FROM sigecig_traspaso_maestro traspasoMaestro
            INNER JOIN sigecig_traspaso_detalle traspasoDetalle ON traspasoDetalle.traspaso_maestro_id = traspasoMaestro.id
            WHERE traspasoMaestro.bodega_destino_id = $caja->bodega AND traspasoDetalle.tipo_pago_timbre_id = $pago->id
            AND DATE(traspasoDetalle.created_at) BETWEEN CAST('$fechaInicial' AS DATE) AND CAST('$fechaFinal' AS DATE);";
            $traspasos = DB::select($query);
            if (!empty($traspasos)) {
                foreach ($traspasos as $key => $traspaso) {
                    $remesa +=  $traspaso->cantidad_a_traspasar;

                }
            }

            if (!empty($existencias)) {
                $cantidad = $existencias->sum('cantidad');
            }

            $saldoActual = $cantidad + $remesa - $timbresVendidos;
            $detalle->existenciaAnterior = $cantidad;
            $detalle->valorExistenciaAnterior = $cantidad *  $precio->precio_colegiado;
            $detalle->timbre_id = $pago->id;
            $detalle->descripcion = $pago->descripcion;
            $detalle->remesas = $remesa;
            $detalle->valorRemesa = $remesa * $precio->precio_colegiado;
            $detalle->ventaActual = $timbresVendidos;
            $detalle->valorVentaActual = $timbresVendidos *  $precio->precio_colegiado ;
            $detalle->saldoActual = $saldoActual;
            $detalle->valorSaldoActual = $saldoActual *  $precio->precio_colegiado;
            $arrayDatos[]= $detalle;
        }
        $arrayTotales= array();
        foreach ($arrayDatos as $key => $dato) {
            $totalGeneralExistenciaAnterior += $dato->existenciaAnterior;
            $totalGeneralValorExistenciaAnterior += $dato->valorExistenciaAnterior;
            $totalGeneralRemesa += $dato->remesas;
            $totalGeneralValorRemesa += $dato->valorRemesa;
            $totalGeneralVentaActual += $dato->ventaActual;
            $totalGeneralValorVentaActual += $dato->valorVentaActual;
            $totalGeneralSaldoActual += $dato->saldoActual;
            $totalGeneralValorSaldoActual += $dato->valorSaldoActual;
        }
        $arrayTotales=['totalGeneralExistenciaAnterior'=>$totalGeneralExistenciaAnterior,'totalGeneralValorExistenciaAnterior'=>$totalGeneralValorExistenciaAnterior,
        'totalGeneralRemesa'=>$totalGeneralRemesa,'totalGeneralValorRemesa'=>$totalGeneralValorRemesa,'totalGeneralVentaActual'=>$totalGeneralVentaActual,
        'totalGeneralValorVentaActual'=>$totalGeneralValorVentaActual,'totalGeneralSaldoActual'=>$totalGeneralSaldoActual,'totalGeneralValorSaldoActual'=>$totalGeneralValorSaldoActual];


        $query= "SELECT caja.id as id_caja,caja.nombre_caja, colaborador.nombre, usuario.id as id_usuario, reciboMaestro.numero_recibo,
        reciboMaestro.numero_de_identificacion, reciboMaestro.nombre, reciboDetalle.codigo_compra, reciboDetalle.cantidad, reciboDetalle.precio_unitario,
        reciboDetalle.total, tipoPago.tipo_de_pago, reciboDetalle.created_at, ventaDetalle.numeracion_inicial, ventaDetalle.numeracion_final
        FROM sigecig_cajas caja
        INNER JOIN sigecig_colaborador colaborador ON colaborador.usuario = caja.cajero
        INNER JOIN sigecig_users usuario ON usuario.id = colaborador.usuario
        INNER JOIN sigecig_recibo_maestro reciboMaestro ON reciboMaestro.usuario = usuario.id
        INNER JOIN sigecig_recibo_detalle reciboDetalle ON reciboDetalle.numero_recibo = reciboMaestro.numero_recibo
        INNER JOIN sigecig_tipo_de_pago tipoPago ON tipoPago.codigo = reciboDetalle.codigo_compra
        INNER JOIN sigecig_venta_de_timbres ventaDetalle ON ventaDetalle.recibo_detalle_id = reciboDetalle.id
        WHERE caja.id = $request->cajaActiva AND DATE(reciboDetalle.created_at) BETWEEN CAST('$request->fechaInicial' AS DATE) AND CAST('$request->fechaFinal' AS DATE)
        ORDER BY reciboDetalle.created_at ASC;";
        $datos = DB::select($query);
        $total=0;
        foreach ($datos as $key => $dato) {
            $total += $dato->total;
        }
        return \PDF::loadView('admin.timbres.pdf-reporte-timbres',compact('datos','cajero','fechaInicial','fechaFinal','subsede','total','arrayDatos','arrayTotales','user'))
        ->setPaper('legal', 'landscape')
        ->stream('Traspaso.pdf');

    //    return view('admin.timbres.pdf-reporte-timbres',compact('datos','cajero','fechaInicial','fechaFinal','subsede','total','arrayDatos'));


    }
    public function getCajas(){
        $cajas = \App\Cajas::select('id','nombre_caja')->where('estado',1)->get();
        return Response::json($cajas);
    }
}

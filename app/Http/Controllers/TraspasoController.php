<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\TraspasoMaestro;
use App\TraspasoDetalle;
use App\IngresoProducto;
use App\IngresoBodegaDetalle;
use App\IngresoBodegaMaestro;
use App\Bodegas;
use App\Cajas;
use App\Subsedes;
use App\Colaborador;
use App\DeptosGuatemala;
use App\MunicipiosGuatemala;
use App\User;
use Validator;

class TraspasoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.traspaso.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bodega = Bodegas::Where('estado','=','1')->get();
        return view('admin.traspaso.create', compact('bodega'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existenciaTc01B1           = $request->input("config.existenciaTc01B1");
        $cantidadTraspasoTc01B1     = $request->input("config.cantidadTraspasoTc01B1");
        $existenciaTc05B1           = $request->input("config.existenciaTc05B1");
        $cantidadTraspasoTc05B1     = $request->input("config.cantidadTraspasoTc05B1");
        $existenciaTc10B1           = $request->input("config.existenciaTc10B1");
        $cantidadTraspasoTc10B1     = $request->input("config.cantidadTraspasoTc10B1");
        $existenciaTc20B1           = $request->input("config.existenciaTc20B1");
        $cantidadTraspasoTc20B1     = $request->input("config.cantidadTraspasoTc20B1");
        $existenciaTc50B1           = $request->input("config.existenciaTc50B1");
        $cantidadTraspasoTc50B1     = $request->input("config.cantidadTraspasoTc50B1");
        $existenciaTc100B1          = $request->input("config.existenciaTc100B1");
        $cantidadTraspasoTc100B1    = $request->input("config.cantidadTraspasoTc100B1");
        $existenciaTc200B1          = $request->input("config.existenciaTc200B1");
        $cantidadTraspasoTc200B1    = $request->input("config.cantidadTraspasoTc200B1");
        $existenciaTc500B1          = $request->input("config.existenciaTc500B1");
        $cantidadTraspasoTc500B1    = $request->input("config.cantidadTraspasoTc500B1");
        // $bodegaOrigen               = $request->bodegaOrigen;
        $bodegaOrigen               = 2;
        $bodegaDestino              = $request->bodegaDestino;

        // Almacen traspaso Maestro
        $CantidadlTimbres = $cantidadTraspasoTc01B1 + $cantidadTraspasoTc05B1 + $cantidadTraspasoTc10B1 + $cantidadTraspasoTc20B1 + $cantidadTraspasoTc50B1 + $cantidadTraspasoTc100B1 + $cantidadTraspasoTc200B1 + $cantidadTraspasoTc500B1;
        $totaltc01 = $cantidadTraspasoTc01B1 * 1;
        $totaltc05 = $cantidadTraspasoTc05B1 * 5;
        $totaltc10 = $cantidadTraspasoTc10B1 * 10;
        $totaltc20 = $cantidadTraspasoTc20B1 * 20;
        $totaltc50 = $cantidadTraspasoTc50B1 * 50;
        $totaltc100 = $cantidadTraspasoTc100B1 * 100;
        $totaltc200 = $cantidadTraspasoTc200B1 * 200;
        $totaltc500 = $cantidadTraspasoTc500B1 * 500;
        $totalGeneral = $totaltc01 + $totaltc05 + $totaltc10 + $totaltc20 + $totaltc50 + $totaltc100 + $totaltc200 + $totaltc500;

        $trasMaestro = new TraspasoMaestro;
        $trasMaestro->bodega_origen_id = $bodegaOrigen;
        $trasMaestro->bodega_destino_id = $bodegaDestino;
        $trasMaestro->cantidad_de_timbres = $CantidadlTimbres;
        $trasMaestro->total_en_timbres = $totalGeneral;
        $trasMaestro->fecha_ingreso = now();
        $trasMaestro->usuario_id = Auth::user()->id;
        $trasMaestro->save();

        // Almacen traspaso Detalle e Ingreso Producto y Actualizacion de tabla ingreso_producto de bodega anterior
        $lastValueId = TraspasoMaestro::pluck('id')->last();
        $idBodegaMaestro = IngresoBodegaMaestro::pluck('id')->where('codigo_bodega_id', 2)->last();

        if($cantidadTraspasoTc01B1 != 0)
        {
            $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 1 AND bodega_id = 2 ORDER BY id ASC"; //consulta para ver existencias de bodega
                $result = DB::select($consulta);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc01B1;
                if ($total >= 0) {
                    $finalIP = $res->numeracion_inicial + $cantidadTraspasoTc01B1 -1;

                    $ingresoProducto = new IngresoProducto;
                    $ingresoProducto->timbre_id = 1;
                    $ingresoProducto->cantidad = $cantidadTraspasoTc01B1;
                    $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                    $ingresoProducto->numeracion_final = $finalIP;
                    $ingresoProducto->bodega_id = $bodegaDestino;
                    $ingresoProducto->save();

                    $trasDetalle = new TraspasoDetalle;
                    $trasDetalle->traspaso_maestro_id = $lastValueId;
                    $trasDetalle->tipo_pago_timbre_id = 1;
                    $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc01B1;
                    $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                    $trasDetalle->numeracion_final = $finalIP;
                    $trasDetalle->save();

                    $nuevoInicialIP = $res->numeracion_inicial + $cantidadTraspasoTc01B1;

                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicialIP);
                    $result = DB::connection('mysql')->update($query, $parametros);

                    break;
                } elseif ($total < 0) {
                    if ($res->cantidad != 0){
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $ingresoProducto = new IngresoProducto;
                        $ingresoProducto->timbre_id = 1;
                        $ingresoProducto->cantidad = $res->cantidad;
                        $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                        $ingresoProducto->numeracion_final = $res->numeracion_final;
                        $ingresoProducto->bodega_id = $bodegaDestino;
                        $ingresoProducto->save();

                        $trasDetalle = new TraspasoDetalle;
                        $trasDetalle->traspaso_maestro_id = $lastValueId;
                        $trasDetalle->tipo_pago_timbre_id = 1;
                        $trasDetalle->cantidad_a_traspasar = $res->cantidad;
                        $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                        $trasDetalle->numeracion_final = $res->numeracion_final;
                        $trasDetalle->save();

                        $cantidadTraspasoTc01B1 = $total * -1 ;
                    }
                }
            }
        }
        if($cantidadTraspasoTc05B1 != 0)
        {
            $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 2 AND bodega_id = 2 ORDER BY id ASC"; //consulta para ver existencias de bodega
                $result = DB::select($consulta);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc05B1;
                if ($total >= 0) {
                    $finalIP = $res->numeracion_inicial + $cantidadTraspasoTc05B1 -1;

                    $ingresoProducto = new IngresoProducto;
                    $ingresoProducto->timbre_id = 2;
                    $ingresoProducto->cantidad = $cantidadTraspasoTc05B1;
                    $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                    $ingresoProducto->numeracion_final = $finalIP;
                    $ingresoProducto->bodega_id = $bodegaDestino;
                    $ingresoProducto->save();

                    $trasDetalle = new TraspasoDetalle;
                    $trasDetalle->traspaso_maestro_id = $lastValueId;
                    $trasDetalle->tipo_pago_timbre_id = 2;
                    $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc05B1;
                    $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                    $trasDetalle->numeracion_final = $finalIP;
                    $trasDetalle->save();

                    $nuevoInicialIP = $res->numeracion_inicial + $cantidadTraspasoTc05B1;

                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicialIP);
                    $result = DB::connection('mysql')->update($query, $parametros);

                    break;
                } elseif ($total < 0) {
                    if ($res->cantidad != 0){
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $ingresoProducto = new IngresoProducto;
                        $ingresoProducto->timbre_id = 1;
                        $ingresoProducto->cantidad = $res->cantidad;
                        $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                        $ingresoProducto->numeracion_final = $res->numeracion_final;
                        $ingresoProducto->bodega_id = $bodegaDestino;
                        $ingresoProducto->save();

                        $trasDetalle = new TraspasoDetalle;
                        $trasDetalle->traspaso_maestro_id = $lastValueId;
                        $trasDetalle->tipo_pago_timbre_id = 2;
                        $trasDetalle->cantidad_a_traspasar = $res->cantidad;
                        $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                        $trasDetalle->numeracion_final = $res->numeracion_final;
                        $trasDetalle->save();

                        $cantidadTraspasoTc05B1 = $total * -1 ;
                    }
                }
            }
        }
        if($cantidadTraspasoTc10B1 != 0)
        {
            $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 3 AND bodega_id = 2 ORDER BY id ASC"; //consulta para ver existencias de bodega
                $result = DB::select($consulta);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc10B1;
                if ($total >= 0) {
                    $finalIP = $res->numeracion_inicial + $cantidadTraspasoTc10B1 -1;

                    $ingresoProducto = new IngresoProducto;
                    $ingresoProducto->timbre_id = 3;
                    $ingresoProducto->cantidad = $cantidadTraspasoTc10B1;
                    $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                    $ingresoProducto->numeracion_final = $finalIP;
                    $ingresoProducto->bodega_id = $bodegaDestino;
                    $ingresoProducto->save();

                    $trasDetalle = new TraspasoDetalle;
                    $trasDetalle->traspaso_maestro_id = $lastValueId;
                    $trasDetalle->tipo_pago_timbre_id = 3;
                    $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc10B1;
                    $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                    $trasDetalle->numeracion_final = $finalIP;
                    $trasDetalle->save();

                    $nuevoInicialIP = $res->numeracion_inicial + $cantidadTraspasoTc10B1;

                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicialIP);
                    $result = DB::connection('mysql')->update($query, $parametros);

                    break;
                } elseif ($total < 0) {
                    if ($res->cantidad != 0){
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $ingresoProducto = new IngresoProducto;
                        $ingresoProducto->timbre_id = 3;
                        $ingresoProducto->cantidad = $res->cantidad;
                        $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                        $ingresoProducto->numeracion_final = $res->numeracion_final;
                        $ingresoProducto->bodega_id = $bodegaDestino;
                        $ingresoProducto->save();

                        $trasDetalle = new TraspasoDetalle;
                        $trasDetalle->traspaso_maestro_id = $lastValueId;
                        $trasDetalle->tipo_pago_timbre_id = 3;
                        $trasDetalle->cantidad_a_traspasar = $res->cantidad;
                        $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                        $trasDetalle->numeracion_final = $res->numeracion_final;
                        $trasDetalle->save();

                        $cantidadTraspasoTc10B1 = $total * -1 ;
                    }
                }
            }
        }
        if($cantidadTraspasoTc20B1 != 0)
        {
            $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 4 AND bodega_id = 2 ORDER BY id ASC"; //consulta para ver existencias de bodega
                $result = DB::select($consulta);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc20B1;
                if ($total >= 0) {
                    $finalIP = $res->numeracion_inicial + $cantidadTraspasoTc20B1 -1;

                    $ingresoProducto = new IngresoProducto;
                    $ingresoProducto->timbre_id = 4;
                    $ingresoProducto->cantidad = $cantidadTraspasoTc20B1;
                    $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                    $ingresoProducto->numeracion_final = $finalIP;
                    $ingresoProducto->bodega_id = $bodegaDestino;
                    $ingresoProducto->save();

                    $trasDetalle = new TraspasoDetalle;
                    $trasDetalle->traspaso_maestro_id = $lastValueId;
                    $trasDetalle->tipo_pago_timbre_id = 4;
                    $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc20B1;
                    $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                    $trasDetalle->numeracion_final = $finalIP;
                    $trasDetalle->save();

                    $nuevoInicialIP = $res->numeracion_inicial + $cantidadTraspasoTc20B1;

                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicialIP);
                    $result = DB::connection('mysql')->update($query, $parametros);

                    break;
                } elseif ($total < 0) {
                    if ($res->cantidad != 0){
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $ingresoProducto = new IngresoProducto;
                        $ingresoProducto->timbre_id = 4;
                        $ingresoProducto->cantidad = $res->cantidad;
                        $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                        $ingresoProducto->numeracion_final = $res->numeracion_final;
                        $ingresoProducto->bodega_id = $bodegaDestino;
                        $ingresoProducto->save();

                        $trasDetalle = new TraspasoDetalle;
                        $trasDetalle->traspaso_maestro_id = $lastValueId;
                        $trasDetalle->tipo_pago_timbre_id = 4;
                        $trasDetalle->cantidad_a_traspasar = $res->cantidad;
                        $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                        $trasDetalle->numeracion_final = $res->numeracion_final;
                        $trasDetalle->save();

                        $cantidadTraspasoTc20B1 = $total * -1 ;
                    }
                }
            }
        }
        if($cantidadTraspasoTc50B1 != 0)
        {
            $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 5 AND bodega_id = 2 ORDER BY id ASC"; //consulta para ver existencias de bodega
                $result = DB::select($consulta);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc50B1;
                if ($total >= 0) {
                    $finalIP = $res->numeracion_inicial + $cantidadTraspasoTc50B1 -1;

                    $ingresoProducto = new IngresoProducto;
                    $ingresoProducto->timbre_id = 5;
                    $ingresoProducto->cantidad = $cantidadTraspasoTc50B1;
                    $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                    $ingresoProducto->numeracion_final = $finalIP;
                    $ingresoProducto->bodega_id = $bodegaDestino;
                    $ingresoProducto->save();

                    $trasDetalle = new TraspasoDetalle;
                    $trasDetalle->traspaso_maestro_id = $lastValueId;
                    $trasDetalle->tipo_pago_timbre_id = 5;
                    $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc50B1;
                    $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                    $trasDetalle->numeracion_final = $finalIP;
                    $trasDetalle->save();

                    $nuevoInicialIP = $res->numeracion_inicial + $cantidadTraspasoTc50B1;

                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicialIP);
                    $result = DB::connection('mysql')->update($query, $parametros);

                    break;
                } elseif ($total < 0) {
                    if ($res->cantidad != 0){
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $ingresoProducto = new IngresoProducto;
                        $ingresoProducto->timbre_id = 5;
                        $ingresoProducto->cantidad = $res->cantidad;
                        $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                        $ingresoProducto->numeracion_final = $res->numeracion_final;
                        $ingresoProducto->bodega_id = $bodegaDestino;
                        $ingresoProducto->save();

                        $trasDetalle = new TraspasoDetalle;
                        $trasDetalle->traspaso_maestro_id = $lastValueId;
                        $trasDetalle->tipo_pago_timbre_id = 5;
                        $trasDetalle->cantidad_a_traspasar = $res->cantidad;
                        $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                        $trasDetalle->numeracion_final = $res->numeracion_final;
                        $trasDetalle->save();

                        $cantidadTraspasoTc50B1 = $total * -1 ;
                    }
                }
            }
        }
        if($cantidadTraspasoTc100B1 != 0)
        {
            $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 6 AND bodega_id = 2 ORDER BY id ASC"; //consulta para ver existencias de bodega
                $result = DB::select($consulta);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc100B1;
                if ($total >= 0) {
                    $finalIP = $res->numeracion_inicial + $cantidadTraspasoTc100B1 -1;

                    $ingresoProducto = new IngresoProducto;
                    $ingresoProducto->timbre_id = 6;
                    $ingresoProducto->cantidad = $cantidadTraspasoTc100B1;
                    $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                    $ingresoProducto->numeracion_final = $finalIP;
                    $ingresoProducto->bodega_id = $bodegaDestino;
                    $ingresoProducto->save();

                    $trasDetalle = new TraspasoDetalle;
                    $trasDetalle->traspaso_maestro_id = $lastValueId;
                    $trasDetalle->tipo_pago_timbre_id = 6;
                    $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc100B1;
                    $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                    $trasDetalle->numeracion_final = $finalIP;
                    $trasDetalle->save();

                    $nuevoInicialIP = $res->numeracion_inicial + $cantidadTraspasoTc100B1;

                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicialIP);
                    $result = DB::connection('mysql')->update($query, $parametros);

                    break;
                } elseif ($total < 0) {
                    if ($res->cantidad != 0){
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $ingresoProducto = new IngresoProducto;
                        $ingresoProducto->timbre_id = 6;
                        $ingresoProducto->cantidad = $res->cantidad;
                        $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                        $ingresoProducto->numeracion_final = $res->numeracion_final;
                        $ingresoProducto->bodega_id = $bodegaDestino;
                        $ingresoProducto->save();

                        $trasDetalle = new TraspasoDetalle;
                        $trasDetalle->traspaso_maestro_id = $lastValueId;
                        $trasDetalle->tipo_pago_timbre_id = 6;
                        $trasDetalle->cantidad_a_traspasar = $res->cantidad;
                        $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                        $trasDetalle->numeracion_final = $res->numeracion_final;
                        $trasDetalle->save();

                        $cantidadTraspasoTc100B1 = $total * -1 ;
                    }
                }
            }
        }
        if($cantidadTraspasoTc200B1 != 0)
        {
            $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 7 AND bodega_id = 2 ORDER BY id ASC"; //consulta para ver existencias de bodega
                $result = DB::select($consulta);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc200B1;
                if ($total >= 0) {
                    $finalIP = $res->numeracion_inicial + $cantidadTraspasoTc200B1 -1;

                    $ingresoProducto = new IngresoProducto;
                    $ingresoProducto->timbre_id = 7;
                    $ingresoProducto->cantidad = $cantidadTraspasoTc200B1;
                    $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                    $ingresoProducto->numeracion_final = $finalIP;
                    $ingresoProducto->bodega_id = $bodegaDestino;
                    $ingresoProducto->save();

                    $trasDetalle = new TraspasoDetalle;
                    $trasDetalle->traspaso_maestro_id = $lastValueId;
                    $trasDetalle->tipo_pago_timbre_id = 7;
                    $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc200B1;
                    $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                    $trasDetalle->numeracion_final = $finalIP;
                    $trasDetalle->save();

                    $nuevoInicialIP = $res->numeracion_inicial + $cantidadTraspasoTc200B1;

                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicialIP);
                    $result = DB::connection('mysql')->update($query, $parametros);

                    break;
                } elseif ($total < 0) {
                    if ($res->cantidad != 0){
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $ingresoProducto = new IngresoProducto;
                        $ingresoProducto->timbre_id = 7;
                        $ingresoProducto->cantidad = $res->cantidad;
                        $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                        $ingresoProducto->numeracion_final = $res->numeracion_final;
                        $ingresoProducto->bodega_id = $bodegaDestino;
                        $ingresoProducto->save();

                        $trasDetalle = new TraspasoDetalle;
                        $trasDetalle->traspaso_maestro_id = $lastValueId;
                        $trasDetalle->tipo_pago_timbre_id = 7;
                        $trasDetalle->cantidad_a_traspasar = $res->cantidad;
                        $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                        $trasDetalle->numeracion_final = $res->numeracion_final;
                        $trasDetalle->save();

                        $cantidadTraspasoTc200B1 = $total * -1 ;
                    }
                }
            }
        }
        if($cantidadTraspasoTc500B1 != 0)
        {
            $consulta = "SELECT * FROM sigecig_ingreso_producto WHERE timbre_id = 8 AND bodega_id = 2 ORDER BY id ASC"; //consulta para ver existencias de bodega
                $result = DB::select($consulta);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc500B1;
                if ($total >= 0) {
                    $finalIP = $res->numeracion_inicial + $cantidadTraspasoTc500B1 -1;

                    $ingresoProducto = new IngresoProducto;
                    $ingresoProducto->timbre_id = 8;
                    $ingresoProducto->cantidad = $cantidadTraspasoTc500B1;
                    $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                    $ingresoProducto->numeracion_final = $finalIP;
                    $ingresoProducto->bodega_id = $bodegaDestino;
                    $ingresoProducto->save();

                    $trasDetalle = new TraspasoDetalle;
                    $trasDetalle->traspaso_maestro_id = $lastValueId;
                    $trasDetalle->tipo_pago_timbre_id = 8;
                    $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc500B1;
                    $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                    $trasDetalle->numeracion_final = $finalIP;
                    $trasDetalle->save();

                    $nuevoInicialIP = $res->numeracion_inicial + $cantidadTraspasoTc500B1;

                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total, numeracion_inicial = :nuevoinicio WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id, ':nuevoinicio' => $nuevoInicialIP);
                    $result = DB::connection('mysql')->update($query, $parametros);

                    break;
                } elseif ($total < 0) {
                    if ($res->cantidad != 0){
                        $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0, numeracion_inicial = 0, numeracion_final = 0 WHERE id = :id";
                        $parametros = array(':id' => $res->id );
                        $result = DB::connection('mysql')->update($query, $parametros);

                        $ingresoProducto = new IngresoProducto;
                        $ingresoProducto->timbre_id = 8;
                        $ingresoProducto->cantidad = $res->cantidad;
                        $ingresoProducto->numeracion_inicial = $res->numeracion_inicial;
                        $ingresoProducto->numeracion_final = $res->numeracion_final;
                        $ingresoProducto->bodega_id = $bodegaDestino;
                        $ingresoProducto->save();

                        $trasDetalle = new TraspasoDetalle;
                        $trasDetalle->traspaso_maestro_id = $lastValueId;
                        $trasDetalle->tipo_pago_timbre_id = 8;
                        $trasDetalle->cantidad_a_traspasar = $res->cantidad;
                        $trasDetalle->numeracion_inicial = $res->numeracion_inicial;
                        $trasDetalle->numeracion_final = $res->numeracion_final;
                        $trasDetalle->save();

                        $cantidadTraspasoTc500B1 = $total * -1 ;
                    }
                }
            }
        }

        return response()->json(['success' => 'Exito']);

        // SELECT * FROM `sigecig_ingreso_producto` WHERE timbre_id = 30 AND bodega_id = 1 ORDER BY id ASC
    }

    public function getBodega($id)
    {
        $queryTc01 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND timbre_id = 1";
        $resultTc01 = DB::select($queryTc01);
        $queryTc05 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND timbre_id = 2";
        $resultTc05 = DB::select($queryTc05);
        $queryTc10 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND timbre_id = 3";
        $resultTc10 = DB::select($queryTc10);
        $queryTc20 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND timbre_id = 4";
        $resultTc20 = DB::select($queryTc20);
        $queryTc50 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND timbre_id = 5";
        $resultTc50 = DB::select($queryTc50);
        $queryTc100 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND timbre_id = 6";
        $resultTc100 = DB::select($queryTc100);
        $queryTc200 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND timbre_id = 7";
        $resultTc200 = DB::select($queryTc200);
        $queryTc500 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND timbre_id = 8";
        $resultTc500 = DB::select($queryTc500);

        return array("tc01" => $resultTc01[0]->cantidad,"tc05" => $resultTc05[0]->cantidad, "tc10" => $resultTc10[0]->cantidad,"tc20" => $resultTc20[0]->cantidad,"tc50" => $resultTc50[0]->cantidad,"tc100" => $resultTc100[0]->cantidad,"tc200" => $resultTc200[0]->cantidad,"tc500" => $resultTc500[0]->cantidad);
    }

    public function getJson(Request $params)
    {
        $query = "SELECT t.id, b.nombre_bodega as bodega_origen, c.nombre_bodega as bodega_destino, t.cantidad_de_timbres, t.total_en_timbres
                  FROM sigecig_traspaso_maestro t
                  INNER JOIN sigecig_bodega b ON t.bodega_origen_id = b.id
                  INNER JOIN sigecig_bodega c ON t.bodega_destino_id = c.id";

        $api_Result['data'] = DB::select($query);
        return Response::json( $api_Result );
    }

    public function pdfTraspaso(TraspasoMaestro $id)
    {
        setlocale(LC_TIME, "spanish");
        $newDate = strftime("%B %d, %Y ", strtotime( $id->created_at) ); //fecha de creacion en formato español

        $nombreUsuario = User::select("name")->where("id", $id->usuario_id)->get()->first(); //nombre del usuario que creo el traspaso

        $query = "SELECT t.id, b.nombre_bodega as bodega_origen, c.nombre_bodega as bodega_destino, t.cantidad_de_timbres, t.total_en_timbres
                  FROM sigecig_traspaso_maestro t
                  INNER JOIN sigecig_bodega b ON t.bodega_origen_id = b.id
                  INNER JOIN sigecig_bodega c ON t.bodega_destino_id = c.id
                  WHERE t.id = $id->id";
        $result = DB::select($query);

        $bodegaOrigen  = $result[0]->bodega_origen; //bodega de origen
        $bodegaDestino = $result[0]->bodega_destino; //bodega de destino

        $ciudadDestino = Bodegas::select('descripcion')->where('nombre_bodega', 'LIKE', $bodegaDestino)->get()->first();


        $query1= "SELECT tp.descripcion, id.cantidad_a_traspasar, id.numeracion_inicial, id.numeracion_final FROM sigecig_traspaso_detalle id
                  INNER JOIN sigecig_timbres tp ON id.tipo_pago_timbre_id = tp.id
                  WHERE id.traspaso_maestro_id = $id->id";
        $datos = DB::select($query1);

        $cajas = cajas::select('*')->where('bodega', $id->bodega_destino_id)->get()->first(); // consulta a la tabla de cajas para saber la subsede de la bodega destino
        $sedeDestino = Subsedes::select('*')->where('id', $cajas->subsede)->get()->first(); // datos sobre la sede de destino

        // $UsuarioDestino = User::select("name")->where("id", $cajas->cajero)->get()->first(); // consulta a tabla usuarios para el cajero que se encarga de la Bodega o sede Destino
        // $nombreUsuarioDestino = $UsuarioDestino->name; //nombre del cajero que se encarga de la Bodega o sede Destino

        $datoCUI = Colaborador::select("dpi","nombre", "departamento_dpi_id", "municipio_dpi_id")->where("usuario", $cajas->cajero)->get()->first();
        $cui = $datoCUI->dpi; // dpi del usuario destino
        $nombreUsuarioDestino = $datoCUI->nombre; //nombre del cajero de destino
        $depOrigenDPI = $datoCUI->departamento_dpi_id; //id del departamento de dpi usuario destino
        $datoDepto = DeptosGuatemala::select("nombre")->where("iddepartamento", $depOrigenDPI)->get()->first();
        $depOrigenDPI = $datoDepto->nombre; // nombre del departamento de dpi de usuario de destino
        $municipioOrigenDPI = $datoCUI->municipio_dpi_id; //id del departamento de dpi usuario desrtino
        $muniOrigen = MunicipiosGuatemala::select("nombre")->where("idmunicipio", $municipioOrigenDPI)->get()->first();
        $municipioOrigenDPI = $muniOrigen->nombre;

        $total = 0;
        for ($i = 0; $i < sizeof($datos); $i++) { //ciclo para sacar el total en Quetzales del precio de todos los timbres
            if ($datos[$i]->descripcion == 'Timbres de precio de Q1.00'){ $total += ($datos[$i]->cantidad_a_traspasar * 1); }
            if ($datos[$i]->descripcion == 'Timbres de precio de Q5.00'){ $total += ($datos[$i]->cantidad_a_traspasar * 5); }
            if ($datos[$i]->descripcion == 'Timbres de precio de Q10.00'){ $total += $datos[$i]->cantidad_a_traspasar * 10; }
            if ($datos[$i]->descripcion == 'Timbres de precio de Q20.00'){ $total += $datos[$i]->cantidad_a_traspasar * 20; }
            if ($datos[$i]->descripcion == 'Timbres de precio de Q50.00'){ $total += $datos[$i]->cantidad_a_traspasar * 50; }
            if ($datos[$i]->descripcion == 'Timbres de precio de Q100.00'){ $total += $datos[$i]->cantidad_a_traspasar * 100; }
            if ($datos[$i]->descripcion == 'Timbres de precio de Q200.00'){ $total += $datos[$i]->cantidad_a_traspasar * 200; }
            if ($datos[$i]->descripcion == 'Timbres de precio de Q500.00'){ $total += $datos[$i]->cantidad_a_traspasar * 500; }
        }

        return \PDF::loadView('admin.traspaso.pdftraspaso', compact('id', 'nombreUsuario', 'bodegaOrigen', 'depOrigenDPI', 'municipioOrigenDPI','bodegaDestino', 'ciudadDestino','newDate', 'datos', 'sedeDestino', 'total', 'nombreUsuarioDestino', 'cui'))
        ->setPaper('legal', 'portrait')
        ->stream('Traspaso.pdf');
    }
}

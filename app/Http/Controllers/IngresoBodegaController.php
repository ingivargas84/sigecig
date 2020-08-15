<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\IngresoBodegaMaestro;
use App\IngresoBodegaDetalle;
use App\IngresoProducto;
use App\Bodegas;
use App\User;
use Validator;

class IngresoBodegaController extends Controller
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
        return view('admin.remesa.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bodega = Bodegas::Where('estado','=','1')->get();
        return view('admin.remesa.create', compact('bodega'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $planchasTc01           = $request->input("config.planchasTc01");
        $unidadPlanchaTc01      = $request->input("config.unidadPlanchaTc01");
        $numeroInicialTc01      = $request->input("config.numeroInicialTc01");
        $numeroFinalTc01        = $request->input("config.numeroFinalTc01");
        $cantidadTc01           = $request->input("config.cantidadTc01");
        $totalTc01              = $request->input("config.totalTc01");
        $totalTc01              = substr($totalTc01,2);
        $planchasTc05           = $request->input("config.planchasTc05");
        $unidadPlanchaTc05      = $request->input("config.unidadPlanchaTc05");
        $numeroInicialTc05      = $request->input("config.numeroInicialTc05");
        $numeroFinalTc05        = $request->input("config.numeroFinalTc05");
        $cantidadTc05           = $request->input("config.cantidadTc05");
        $totalTc05              = $request->input("config.totalTc05");
        $totalTc05              = substr($totalTc05,2);
        $planchasTc10           = $request->input("config.planchasTc10");
        $unidadPlanchaTc10      = $request->input("config.unidadPlanchaTc10");
        $numeroInicialTc10      = $request->input("config.numeroInicialTc10");
        $numeroFinalTc10        = $request->input("config.numeroFinalTc10");
        $cantidadTc10           = $request->input("config.cantidadTc10");
        $totalTc10              = $request->input("config.totalTc10");
        $totalTc10              = substr($totalTc10,2);
        $planchasTc20           = $request->input("config.planchasTc20");
        $unidadPlanchaTc20      = $request->input("config.unidadPlanchaTc20");
        $numeroInicialTc20      = $request->input("config.numeroInicialTc20");
        $numeroFinalTc20        = $request->input("config.numeroFinalTc20");
        $cantidadTc20           = $request->input("config.cantidadTc20");
        $totalTc20              = $request->input("config.totalTc20");
        $totalTc20              = substr($totalTc20,2);
        $planchasTc50           = $request->input("config.planchasTc50");
        $unidadPlanchaTc50      = $request->input("config.unidadPlanchaTc50");
        $numeroInicialTc50      = $request->input("config.numeroInicialTc50");
        $numeroFinalTc50        = $request->input("config.numeroFinalTc50");
        $cantidadTc50           = $request->input("config.cantidadTc50");
        $totalTc50              = $request->input("config.totalTc50");
        $totalTc50              = substr($totalTc50,2);
        $planchasTc100          = $request->input("config.planchasTc100");
        $unidadPlanchaTc100     = $request->input("config.unidadPlanchaTc100");
        $numeroInicialTc100     = $request->input("config.numeroInicialTc100");
        $numeroFinalTc100       = $request->input("config.numeroFinalTc100");
        $cantidadTc100          = $request->input("config.cantidadTc100");
        $totalTc100             = $request->input("config.totalTc100");
        $totalTc100             = substr($totalTc100,2);
        $planchasTc200          = $request->input("config.planchasTc200");
        $unidadPlanchaTc200     = $request->input("config.unidadPlanchaTc200");
        $numeroInicialTc200     = $request->input("config.numeroInicialTc200");
        $numeroFinalTc200       = $request->input("config.numeroFinalTc200");
        $cantidadTc200          = $request->input("config.cantidadTc200");
        $totalTc200             = $request->input("config.totalTc200");
        $totalTc200             = substr($totalTc200,2);
        $planchasTc500          = $request->input("config.planchasTc500");
        $unidadPlanchaTc500     = $request->input("config.unidadPlanchaTc500");
        $numeroInicialTc500     = $request->input("config.numeroInicialTc500");
        $numeroFinalTc500       = $request->input("config.numeroFinalTc500");
        $cantidadTc500          = $request->input("config.cantidadTc500");
        $totalTc500             = $request->input("config.totalTc500");
        $totalTc500             = substr($totalTc500,2);
        $bodega_id              = $request->bodega;

        // almacen de ingreso_bodega_maestro
        $cantidadTotal = $cantidadTc01 + $cantidadTc05 + $cantidadTc10 + $cantidadTc20 + $cantidadTc50 + $cantidadTc100 + $cantidadTc200 + $cantidadTc500;
        $precioTotal = $totalTc01 + $totalTc05 + $totalTc10 + $totalTc20 + $totalTc50 + $totalTc100 + $totalTc200 + $totalTc500;

        $bodegaMaestro = new IngresoBodegaMaestro;
        $bodegaMaestro->usuario_id =  Auth::user()->id;
        $bodegaMaestro->cantidad_de_timbres = $cantidadTotal;
        $bodegaMaestro->total = $precioTotal;
        $bodegaMaestro->codigo_bodega_id = $bodega_id;
        $bodegaMaestro->save();

        // almacen de ingreso_bodega_detalle
        $lastValueId = IngresoBodegaMaestro::pluck('id')->last();

        if($cantidadTc01 != 0)
        {
            $bodegaDetalle = new IngresoBodegaDetalle;
            $bodegaDetalle->fecha_ingreso = now();
            $bodegaDetalle->ingreso_maestro_id = $lastValueId;
            $bodegaDetalle->timbre_id = 1;
            $bodegaDetalle->planchas = $planchasTc01;
            $bodegaDetalle->unidad_por_plancha = $unidadPlanchaTc01;
            $bodegaDetalle->numeracion_inicial = $numeroInicialTc01;
            $bodegaDetalle->numeracion_final = $numeroFinalTc01;
            $bodegaDetalle->cantidad = $cantidadTc01;
            $bodegaDetalle->total = $totalTc01;
            $bodegaDetalle->usuario_id = Auth::user()->id;
            $bodegaDetalle->save();
        }
        if($cantidadTc05 != 0)
        {
            $bodegaDetalle = new IngresoBodegaDetalle;
            $bodegaDetalle->fecha_ingreso = now();
            $bodegaDetalle->ingreso_maestro_id = $lastValueId;
            $bodegaDetalle->timbre_id = 2;
            $bodegaDetalle->planchas = $planchasTc05;
            $bodegaDetalle->unidad_por_plancha = $unidadPlanchaTc05;
            $bodegaDetalle->numeracion_inicial = $numeroInicialTc05;
            $bodegaDetalle->numeracion_final = $numeroFinalTc05;
            $bodegaDetalle->cantidad = $cantidadTc05;
            $bodegaDetalle->total = $totalTc05;
            $bodegaDetalle->usuario_id = Auth::user()->id;
            $bodegaDetalle->save();
        }

        if($cantidadTc10 != 0)
        {
            $bodegaDetalle = new IngresoBodegaDetalle;
            $bodegaDetalle->fecha_ingreso = now();
            $bodegaDetalle->ingreso_maestro_id = $lastValueId;
            $bodegaDetalle->timbre_id = 3;
            $bodegaDetalle->planchas = $planchasTc10;
            $bodegaDetalle->unidad_por_plancha = $unidadPlanchaTc10;
            $bodegaDetalle->numeracion_inicial = $numeroInicialTc10;
            $bodegaDetalle->numeracion_final = $numeroFinalTc10;
            $bodegaDetalle->cantidad = $cantidadTc10;
            $bodegaDetalle->total = $totalTc10;
            $bodegaDetalle->usuario_id = Auth::user()->id;
            $bodegaDetalle->save();
        }

        if($cantidadTc20 != 0)
        {
            $bodegaDetalle = new IngresoBodegaDetalle;
            $bodegaDetalle->fecha_ingreso = now();
            $bodegaDetalle->ingreso_maestro_id = $lastValueId;
            $bodegaDetalle->timbre_id = 4;
            $bodegaDetalle->planchas = $planchasTc20;
            $bodegaDetalle->unidad_por_plancha = $unidadPlanchaTc20;
            $bodegaDetalle->numeracion_inicial = $numeroInicialTc20;
            $bodegaDetalle->numeracion_final = $numeroFinalTc20;
            $bodegaDetalle->cantidad = $cantidadTc20;
            $bodegaDetalle->total = $totalTc20;
            $bodegaDetalle->usuario_id = Auth::user()->id;
            $bodegaDetalle->save();
        }

        if($cantidadTc50 != 0)
        {
            $bodegaDetalle = new IngresoBodegaDetalle;
            $bodegaDetalle->fecha_ingreso = now();
            $bodegaDetalle->ingreso_maestro_id = $lastValueId;
            $bodegaDetalle->timbre_id = 5;
            $bodegaDetalle->planchas = $planchasTc50;
            $bodegaDetalle->unidad_por_plancha = $unidadPlanchaTc50;
            $bodegaDetalle->numeracion_inicial = $numeroInicialTc50;
            $bodegaDetalle->numeracion_final = $numeroFinalTc50;
            $bodegaDetalle->cantidad = $cantidadTc50;
            $bodegaDetalle->total = $totalTc50;
            $bodegaDetalle->usuario_id = Auth::user()->id;
            $bodegaDetalle->save();
        }

        if($cantidadTc100 != 0)
        {
            $bodegaDetalle = new IngresoBodegaDetalle;
            $bodegaDetalle->fecha_ingreso = now();
            $bodegaDetalle->ingreso_maestro_id = $lastValueId;
            $bodegaDetalle->timbre_id = 6;
            $bodegaDetalle->planchas = $planchasTc100;
            $bodegaDetalle->unidad_por_plancha = $unidadPlanchaTc100;
            $bodegaDetalle->numeracion_inicial = $numeroInicialTc100;
            $bodegaDetalle->numeracion_final = $numeroFinalTc100;
            $bodegaDetalle->cantidad = $cantidadTc100;
            $bodegaDetalle->total = $totalTc100;
            $bodegaDetalle->usuario_id = Auth::user()->id;
            $bodegaDetalle->save();
        }

        if($cantidadTc200 != 0)
        {
            $bodegaDetalle = new IngresoBodegaDetalle;
            $bodegaDetalle->fecha_ingreso = now();
            $bodegaDetalle->ingreso_maestro_id = $lastValueId;
            $bodegaDetalle->timbre_id = 7;
            $bodegaDetalle->planchas = $planchasTc200;
            $bodegaDetalle->unidad_por_plancha = $unidadPlanchaTc200;
            $bodegaDetalle->numeracion_inicial = $numeroInicialTc200;
            $bodegaDetalle->numeracion_final = $numeroFinalTc200;
            $bodegaDetalle->cantidad = $cantidadTc200;
            $bodegaDetalle->total = $totalTc200;
            $bodegaDetalle->usuario_id = Auth::user()->id;
            $bodegaDetalle->save();
        }

        if($cantidadTc500 != 0)
        {
            $bodegaDetalle = new IngresoBodegaDetalle;
            $bodegaDetalle->fecha_ingreso = now();
            $bodegaDetalle->ingreso_maestro_id = $lastValueId;
            $bodegaDetalle->timbre_id = 8;
            $bodegaDetalle->planchas = $planchasTc500;
            $bodegaDetalle->unidad_por_plancha = $unidadPlanchaTc500;
            $bodegaDetalle->numeracion_inicial = $numeroInicialTc500;
            $bodegaDetalle->numeracion_final = $numeroFinalTc500;
            $bodegaDetalle->cantidad = $cantidadTc500;
            $bodegaDetalle->total = $totalTc500;
            $bodegaDetalle->usuario_id = Auth::user()->id;
            $bodegaDetalle->save();
        }

        // almacen de ingreso_producto
        if($cantidadTc01 != 0)
        {
            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->timbre_id = 1;
            $ingresoProducto->cantidad = $cantidadTc01;
            $ingresoProducto->numeracion_inicial = $numeroInicialTc01;
            $ingresoProducto->numeracion_final = $numeroFinalTc01;
            $ingresoProducto->bodega_id = $bodega_id;
            $ingresoProducto->save();
        }
        if($cantidadTc05 != 0)
        {
            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->timbre_id = 2;
            $ingresoProducto->cantidad = $cantidadTc05;
            $ingresoProducto->numeracion_inicial = $numeroInicialTc05;
            $ingresoProducto->numeracion_final = $numeroFinalTc05;
            $ingresoProducto->bodega_id = $bodega_id;
            $ingresoProducto->save();
        }
        if($cantidadTc10 != 0)
        {
            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->timbre_id = 3;
            $ingresoProducto->cantidad = $cantidadTc10;
            $ingresoProducto->numeracion_inicial = $numeroInicialTc10;
            $ingresoProducto->numeracion_final = $numeroFinalTc10;
            $ingresoProducto->bodega_id = $bodega_id;
            $ingresoProducto->save();
        }
        if($cantidadTc20 != 0)
        {
            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->timbre_id = 4;
            $ingresoProducto->cantidad = $cantidadTc20;
            $ingresoProducto->numeracion_inicial = $numeroInicialTc20;
            $ingresoProducto->numeracion_final = $numeroFinalTc20;
            $ingresoProducto->bodega_id = $bodega_id;
            $ingresoProducto->save();
        }
        if($cantidadTc50 != 0)
        {
            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->timbre_id = 5;
            $ingresoProducto->cantidad = $cantidadTc50;
            $ingresoProducto->numeracion_inicial = $numeroInicialTc50;
            $ingresoProducto->numeracion_final = $numeroFinalTc50;
            $ingresoProducto->bodega_id = $bodega_id;
            $ingresoProducto->save();
        }
        if($cantidadTc100 != 0)
        {
            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->timbre_id = 6;
            $ingresoProducto->cantidad = $cantidadTc100;
            $ingresoProducto->numeracion_inicial = $numeroInicialTc100;
            $ingresoProducto->numeracion_final = $numeroFinalTc100;
            $ingresoProducto->bodega_id = $bodega_id;
            $ingresoProducto->save();
        }
        if($cantidadTc200 != 0)
        {
            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->timbre_id = 7;
            $ingresoProducto->cantidad = $cantidadTc200;
            $ingresoProducto->numeracion_inicial = $numeroInicialTc200;
            $ingresoProducto->numeracion_final = $numeroFinalTc200;
            $ingresoProducto->bodega_id = $bodega_id;
            $ingresoProducto->save();
        }
        if($cantidadTc500 != 0)
        {
            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->timbre_id = 8;
            $ingresoProducto->cantidad = $cantidadTc500;
            $ingresoProducto->numeracion_inicial = $numeroInicialTc500;
            $ingresoProducto->numeracion_final = $numeroFinalTc500;
            $ingresoProducto->bodega_id = $bodega_id;
            $ingresoProducto->save();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(IngresoBodegaMaestro $id)
    {
        $maestro = $id;
        $fecha = substr($maestro->created_at,0,10);
        $fecha = date("d/m/Y", strtotime($fecha));
        $bodega = Bodegas::Where('id','=', $maestro->codigo_bodega_id)->get();

        $query = "SELECT t.descripcion, d.planchas, d.unidad_por_plancha, d.numeracion_inicial, d.numeracion_final, d.cantidad, d.total
                  from sigecig_ingreso_bodega_detalle d
                  inner join sigecig_timbres t on d.timbre_id = t.id
                  WHERE ingreso_maestro_id = $maestro->id";
        $result = DB::select($query);

        return view('admin.remesa.detalles', compact('bodega','fecha','result'));
    }

    public function getUltimoDato($datos)
    {
        $tc01 = substr($datos,16,4);
        $tc05 = substr($datos,21,4);
        $tc10 = substr($datos,26,4);
        $tc20 = substr($datos,31,4);
        $tc50 = substr($datos,36,4);
        $tc100 = substr($datos,41,5);
        $tc200 = substr($datos,47,5);
        $tc500 = substr($datos,53,5);

        $lastValueTc01 = DB::table('sigecig_ingreso_bodega_detalle')->Where('timbre_id','=', 1)->orderBy('ingreso_maestro_id', 'desc')->first();
        $lastValueTc01 = $lastValueTc01->numeracion_final + 1;
        $lastValueTc05 = DB::table('sigecig_ingreso_bodega_detalle')->Where('timbre_id','=', 2)->orderBy('ingreso_maestro_id', 'desc')->first();
        $lastValueTc05 = $lastValueTc05->numeracion_final + 1;
        $lastValueTc10 = DB::table('sigecig_ingreso_bodega_detalle')->Where('timbre_id','=', 3)->orderBy('ingreso_maestro_id', 'desc')->first();
        $lastValueTc10 = $lastValueTc10->numeracion_final + 1;
        $lastValueTc20 = DB::table('sigecig_ingreso_bodega_detalle')->Where('timbre_id','=', 4)->orderBy('ingreso_maestro_id', 'desc')->first();
        $lastValueTc20 = $lastValueTc20->numeracion_final + 1;
        $lastValueTc50 = DB::table('sigecig_ingreso_bodega_detalle')->Where('timbre_id','=', 5)->orderBy('ingreso_maestro_id', 'desc')->first();
        $lastValueTc50 = $lastValueTc50->numeracion_final + 1;
        $lastValueTc100 = DB::table('sigecig_ingreso_bodega_detalle')->Where('timbre_id','=', 6)->orderBy('ingreso_maestro_id', 'desc')->first();
        $lastValueTc100 = $lastValueTc100->numeracion_final + 1;
        $lastValueTc200 = DB::table('sigecig_ingreso_bodega_detalle')->Where('timbre_id','=', 7)->orderBy('ingreso_maestro_id', 'desc')->first();
        $lastValueTc200 = $lastValueTc200->numeracion_final + 1;
        $lastValueTc500 = DB::table('sigecig_ingreso_bodega_detalle')->Where('timbre_id','=', 8)->orderBy('ingreso_maestro_id', 'desc')->first();
        $lastValueTc500 = $lastValueTc500->numeracion_final + 1;

        return array("tc01" => $lastValueTc01,"tc05" => $lastValueTc05, "tc10" => $lastValueTc10,"tc20" => $lastValueTc20,"tc50" => $lastValueTc50,"tc100" => $lastValueTc100,"tc200" => $lastValueTc200,"tc500" => $lastValueTc500);
    }

    public function getJson(Request $params)
    {
        $query = "SELECT i.id, i.created_at, u.name, i.cantidad_de_timbres, i.total
                  FROM sigecig_ingreso_bodega_maestro i
                  INNER JOIN sigecig_users u ON i.usuario_id = u.id";

        $api_Result['data'] = DB::select($query);
        return Response::json( $api_Result );
    }

    public function pdfRemesa(IngresoBodegaMaestro $id)
    {
        $newDate = date("d/m/Y", strtotime($id->created_at));
        $nombre = User::select("name")->where("id", $id->usuario_id)->get()->first();

        $query1= "SELECT tp.descripcion, id.planchas, id.unidad_por_plancha, id.numeracion_inicial, id.numeracion_final, id.cantidad, id.total FROM sigecig_ingreso_bodega_detalle id
                  INNER JOIN sigecig_timbres tp ON id.timbre_id = tp.id
                  WHERE id.ingreso_maestro_id = $id->id";
        $datos = DB::select($query1);

        $total = 0;
        for ($i = 0; $i < sizeof($datos); $i++) {
            $total += $datos[$i]->total;
        }

        return \PDF::loadView('admin.remesa.pdfremesa', compact('id', 'nombre', 'datos', 'total', 'newDate'))
        ->setPaper('legal', 'landscape')
        ->stream('Remesa.pdf');
    }
}

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
use App\Bodegas;
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

    public function getBodega($id)
    {
        $queryTc01 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND tipo_de_pago_id = 30";
        $resultTc01 = DB::select($queryTc01);
        $queryTc05 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND tipo_de_pago_id = 31";
        $resultTc05 = DB::select($queryTc05);
        $queryTc10 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND tipo_de_pago_id = 32";
        $resultTc10 = DB::select($queryTc10);
        $queryTc20 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND tipo_de_pago_id = 34";
        $resultTc20 = DB::select($queryTc20);
        $queryTc50 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND tipo_de_pago_id = 36";
        $resultTc50 = DB::select($queryTc50);
        $queryTc100 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND tipo_de_pago_id = 33";
        $resultTc100 = DB::select($queryTc100);
        $queryTc200 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND tipo_de_pago_id = 35";
        $resultTc200 = DB::select($queryTc200);
        $queryTc500 = "SELECT SUM(cantidad) as cantidad FROM sigecig_ingreso_producto WHERE bodega_id = $id AND tipo_de_pago_id = 37";
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
}

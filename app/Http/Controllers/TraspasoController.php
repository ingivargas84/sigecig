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
        $bodegaOrigen               = $request->bodegaOrigen;
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

        // Almacen traspaso Detalle
        $lastValueId = TraspasoMaestro::pluck('id')->last();

        if($cantidadTraspasoTc01B1 != 0)
        {
            $trasDetalle = new TraspasoDetalle;
            $trasDetalle->traspaso_maestro_id = $lastValueId;
            $trasDetalle->tipo_pago_timbre_id = 30;
            $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc01B1;
            $trasDetalle->save();

            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->tipo_de_pago_id = 30;
            $ingresoProducto->cantidad = $cantidadTraspasoTc01B1;
            $ingresoProducto->bodega_id = $bodegaDestino;
            $ingresoProducto->save();
        }
        if($cantidadTraspasoTc05B1 != 0)
        {
            $trasDetalle = new TraspasoDetalle;
            $trasDetalle->traspaso_maestro_id = $lastValueId;
            $trasDetalle->tipo_pago_timbre_id = 31;
            $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc05B1;
            $trasDetalle->save();

            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->tipo_de_pago_id = 31;
            $ingresoProducto->cantidad = $cantidadTraspasoTc05B1;
            $ingresoProducto->bodega_id = $bodegaDestino;
            $ingresoProducto->save();
        }
        if($cantidadTraspasoTc10B1 != 0)
        {
            $trasDetalle = new TraspasoDetalle;
            $trasDetalle->traspaso_maestro_id = $lastValueId;
            $trasDetalle->tipo_pago_timbre_id = 32;
            $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc10B1;
            $trasDetalle->save();

            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->tipo_de_pago_id = 32;
            $ingresoProducto->cantidad = $cantidadTraspasoTc10B1;
            $ingresoProducto->bodega_id = $bodegaDestino;
            $ingresoProducto->save();
        }
        if($cantidadTraspasoTc20B1 != 0)
        {
            $trasDetalle = new TraspasoDetalle;
            $trasDetalle->traspaso_maestro_id = $lastValueId;
            $trasDetalle->tipo_pago_timbre_id = 34;
            $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc20B1;
            $trasDetalle->save();

            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->tipo_de_pago_id = 34;
            $ingresoProducto->cantidad = $cantidadTraspasoTc20B1;
            $ingresoProducto->bodega_id = $bodegaDestino;
            $ingresoProducto->save();
        }
        if($cantidadTraspasoTc50B1 != 0)
        {
            $trasDetalle = new TraspasoDetalle;
            $trasDetalle->traspaso_maestro_id = $lastValueId;
            $trasDetalle->tipo_pago_timbre_id = 36;
            $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc50B1;
            $trasDetalle->save();

            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->tipo_de_pago_id = 36;
            $ingresoProducto->cantidad = $cantidadTraspasoTc50B1;
            $ingresoProducto->bodega_id = $bodegaDestino;
            $ingresoProducto->save();
        }
        if($cantidadTraspasoTc100B1 != 0)
        {
            $trasDetalle = new TraspasoDetalle;
            $trasDetalle->traspaso_maestro_id = $lastValueId;
            $trasDetalle->tipo_pago_timbre_id = 33;
            $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc100B1;
            $trasDetalle->save();

            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->tipo_de_pago_id = 33;
            $ingresoProducto->cantidad = $cantidadTraspasoTc100B1;
            $ingresoProducto->bodega_id = $bodegaDestino;
            $ingresoProducto->save();
        }
        if($cantidadTraspasoTc200B1 != 0)
        {
            $trasDetalle = new TraspasoDetalle;
            $trasDetalle->traspaso_maestro_id = $lastValueId;
            $trasDetalle->tipo_pago_timbre_id = 35;
            $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc200B1;
            $trasDetalle->save();

            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->tipo_de_pago_id = 35;
            $ingresoProducto->cantidad = $cantidadTraspasoTc200B1;
            $ingresoProducto->bodega_id = $bodegaDestino;
            $ingresoProducto->save();
        }
        if($cantidadTraspasoTc500B1 != 0)
        {
            $trasDetalle = new TraspasoDetalle;
            $trasDetalle->traspaso_maestro_id = $lastValueId;
            $trasDetalle->tipo_pago_timbre_id = 37;
            $trasDetalle->cantidad_a_traspasar = $cantidadTraspasoTc500B1;
            $trasDetalle->save();

            $ingresoProducto = new IngresoProducto;
            $ingresoProducto->tipo_de_pago_id = 37;
            $ingresoProducto->cantidad = $cantidadTraspasoTc500B1;
            $ingresoProducto->bodega_id = $bodegaDestino;
            $ingresoProducto->save();
        }

        // Actualizacion de ingreso producto
        if($cantidadTraspasoTc01B1 != 0)
        {
            $query = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 30 AND bodega_id = $bodegaOrigen ORDER BY id ASC";
            $result = DB::select($query);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc01B1;
                if ($total >= 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);
                    break;
                } elseif ($total < 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                    $parametros = array(':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);

                    $cantidadTraspasoTc01B1 = $total * -1 ;
                }
            }
        }

        if($cantidadTraspasoTc05B1 != 0)
        {
            $query = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 31 AND bodega_id = $bodegaOrigen ORDER BY id ASC";
            $result = DB::select($query);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc05B1;
                if ($total >= 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);
                    break;
                } elseif ($total < 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                    $parametros = array(':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);

                    $cantidadTraspasoTc05B1 = $total * -1 ;
                }
            }
        }

        if($cantidadTraspasoTc10B1 != 0)
        {
            $query = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 32 AND bodega_id = $bodegaOrigen ORDER BY id ASC";
            $result = DB::select($query);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc10B1;
                if ($total >= 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);
                    break;
                } elseif ($total < 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                    $parametros = array(':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);

                    $cantidadTraspasoTc10B1 = $total * -1 ;
                }
            }
        }

        if($cantidadTraspasoTc20B1 != 0)
        {
            $query = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 34 AND bodega_id = $bodegaOrigen ORDER BY id ASC";
            $result = DB::select($query);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc20B1;
                if ($total >= 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);
                    break;
                } elseif ($total < 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                    $parametros = array(':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);

                    $cantidadTraspasoTc20B1 = $total * -1 ;
                }
            }
        }

        if($cantidadTraspasoTc50B1 != 0)
        {
            $query = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 36 AND bodega_id = $bodegaOrigen ORDER BY id ASC";
            $result = DB::select($query);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc50B1;
                if ($total >= 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);
                    break;
                } elseif ($total < 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                    $parametros = array(':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);

                    $cantidadTraspasoTc50B1 = $total * -1 ;
                }
            }
        }

        if($cantidadTraspasoTc100B1 != 0)
        {
            $query = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 33 AND bodega_id = $bodegaOrigen ORDER BY id ASC";
            $result = DB::select($query);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc100B1;
                if ($total >= 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);
                    break;
                } elseif ($total < 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                    $parametros = array(':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);

                    $cantidadTraspasoTc100B1 = $total * -1 ;
                }
            }
        }

        if($cantidadTraspasoTc200B1 != 0)
        {
            $query = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 35 AND bodega_id = $bodegaOrigen ORDER BY id ASC";
            $result = DB::select($query);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc200B1;
                if ($total >= 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);
                    break;
                } elseif ($total < 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                    $parametros = array(':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);

                    $cantidadTraspasoTc200B1 = $total * -1 ;
                }
            }
        }

        if($cantidadTraspasoTc500B1 != 0)
        {
            $query = "SELECT * FROM sigecig_ingreso_producto WHERE tipo_de_pago_id = 37 AND bodega_id = $bodegaOrigen ORDER BY id ASC";
            $result = DB::select($query);

            foreach($result as $res)
            {
                $total = $res->cantidad - $cantidadTraspasoTc500B1;
                if ($total >= 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = :total WHERE id = :id";
                    $parametros = array(':total' => $total, ':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);
                    break;
                } elseif ($total < 0) {
                    $query = "UPDATE sigecig_ingreso_producto SET cantidad = 0 WHERE id = :id";
                    $parametros = array(':id' => $res->id );
                    $result = DB::connection('mysql')->update($query, $parametros);

                    $cantidadTraspasoTc500B1 = $total * -1 ;
                }
            }
        }


        return response()->json(['success' => 'Exito']);

        // SELECT * FROM `sigecig_ingreso_producto` WHERE tipo_de_pago_id = 30 AND bodega_id = 1 ORDER BY id ASC
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

    public function pdfTraspaso(TraspasoMaestro $id)
    {
        $newDate = date("d/m/Y", strtotime($id->created_at)); //fecha de creacion
        $nombreUsuario = User::select("name")->where("id", $id->usuario_id)->get()->first(); //nombre del usuario que creo el traspaso

        $query = "SELECT t.id, b.nombre_bodega as bodega_origen, c.nombre_bodega as bodega_destino, t.cantidad_de_timbres, t.total_en_timbres
                  FROM sigecig_traspaso_maestro t
                  INNER JOIN sigecig_bodega b ON t.bodega_origen_id = b.id
                  INNER JOIN sigecig_bodega c ON t.bodega_destino_id = c.id
                  WHERE t.id = $id->id";
        $result = DB::select($query);

        $bodegaOrigen  = $result[0]->bodega_origen; //bodega de origen
        $bodegaDestino = $result[0]->bodega_destino; //bodega de destino


        $query1= "SELECT tp.codigo, tp.tipo_de_pago, id.cantidad_a_traspasar FROM sigecig_traspaso_detalle id
                  INNER JOIN sigecig_tipo_de_pago tp ON id.tipo_pago_timbre_id = tp.id
                  WHERE id.traspaso_maestro_id = $id->id";
        $datos = DB::select($query1);

        // dd($result);

        // $total = 0;
        // for ($i = 1; $i < sizeof($datos); $i++) {
        //     $total += $datos[$i]->total;
        // }

        return \PDF::loadView('admin.traspaso.pdftraspaso', compact('id', 'nombreUsuario', 'bodegaOrigen', 'bodegaDestino', 'newDate'))
        ->setPaper('legal', 'portrait')
        ->stream('Traspaso.pdf');
    }
}

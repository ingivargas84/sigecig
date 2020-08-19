<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use \App\EstadoDeCuentaMaestro;
use \App\EstadoDeCuentaDetalle;
use App\SigecigSaldoColegiados;
use App\SQLSRV_Colegiado;
use App\TipoDePago;
use Carbon\Carbon;
use App\User;

class CorteDeCajaController extends Controller
{
    public function index()
    {
        return view('admin.cortecaja.index');
    }

    public function getJson(Request $params)
    {
       $query = "SELECT CM.id, RM.serie_recibo_id, RM.numero_recibo, RM.monto_total, RM.created_at
       FROM sigecig_recibo_maestro RM
       INNER JOIN sigecig_estado_de_cuenta_maestro CM ON RM.numero_de_identificacion = CM.colegiado_id";

       $api_Result['data'] = DB::select($query);
       return Response::json( $api_Result );
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use DB;




class EstadoCuentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $user = Auth::User();
        return view ('admin.estadoCuenta.cuentamaestro',compact('user'));
    }

    public function getJson()
    {
   
            $query = "SELECT U.id, U.no_solicitud, U.n_colegiado, AP.Nombre1, S.estado_solicitud_ap, B.nombre_banco, TC.tipo_cuenta, U.no_cuenta, U.fecha_pago_ap
        FROM sigecig_solicitudes_ap U
        INNER JOIN sigecig_estado_solicitud_ap S ON U.id_estado_solicitud=S.id
        INNER JOIN adm_usuario AU ON AU.Usuario=U.n_colegiado
        INNER JOIN adm_persona AP ON AU.idPersona = AP.idPersona
        INNER JOIN sigecig_bancos B ON B.id=U.id_banco
        INNER JOIN sigecig_tipo_cuentas TC ON TC.id=U.id_tipo_cuenta
        WHERE U.id_estado_solicitud >=1
        ORDER BY U.id DESC";
     

        $result = DB::select($query);

        $api_Result['data'] = $result;
        return Response::json($api_Result);
    }
}

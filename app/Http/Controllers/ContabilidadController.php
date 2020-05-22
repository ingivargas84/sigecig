<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\PlataformaSolicitudAp;
use App\AdmPersona;
use App\PlataformaBanco;
use App\PlataformaTipoCuenta;
use App\AdmUsuario;
use App\User;
use DB;

class ContabilidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function fechaconfig(PlataformaSolicitudAp $tipo)
    {
        $banco = PlataformaBanco::where("id",$solicitud->id_banco)->get()->first();
        $tipocuenta = PlataformaTipoCuenta::where("id",$solicitud->id_tipo_cuenta)->get()->first();
        $adm_usuario=AdmUsuario::where('Usuario', '=', $tipo->n_colegiado)->get()->first();
        $adm_persona=AdmPersona::where('idPersona', '=', $adm_usuario->idPersona)->get()->first();

        return view ('admin.contabilidad.configfecha', compact('tipo', 'solicitud','banco','tipocuenta', 'adm_usuario', 'adm_persona'));
    }

    public function index()
    {
        $user = Auth::User();
        return view ('admin.contabilidad.index', compact('user'));
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

    public function configfecha(PlataformaSolicitudAp $tipo, Request $request)
    {
        $nuevos_datos = array(
            'no_acta' => $request->no_acta,
            'no_punto_acta' => $request->no_punto_acta,
            'id_estado_solicitud' => 7,
        );
        $json = json_encode($nuevos_datos);
        
        
        $tipo->update($nuevos_datos);
        
        //return redirect()->route('tipoDePago.index', $tipo)->with('flash','Tipo de pago ha sido actualizado!');
        return Response::json(['success' => 'Éxito']);
    }

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

    public function getJson(Request $params)
    {  
        $query = "SELECT U.id, U.no_solicitud, U.n_colegiado, AP.Nombre1, S.estado_solicitud_ap
        FROM sigecig_solicitudes_ap U
        INNER JOIN sigecig_estado_solicitud_ap S ON U.id_estado_solicitud=S.id
        INNER JOIN adm_usuario AU ON AU.Usuario=U.n_colegiado
        INNER JOIN adm_persona AP ON AU.idPersona = AP.idPersona
        WHERE U.id_estado_solicitud >=2";
        
        $result = DB::select($query);
        $api_Result['data'] = $result;
        
        return Response::json( $api_Result );
    }

}

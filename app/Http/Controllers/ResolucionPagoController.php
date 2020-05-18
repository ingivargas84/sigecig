<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\ServiceProvider;


class ResolucionPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function imprimir(){
        $nombre = Auth::User();
        $pdf = \PDF::loadView('timbreingenieria.firmaresolucion.pdf', compact('nombre'));
        return $pdf->stream('AnticipoAP.pdf');
    }
    public function index()
    {
        {
            $user = Auth::User();
            return view ('timbreingenieria.firmaresolucion.index', compact('user'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User;
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

    public function getJson(Request $params)
    {
        $user_id = Auth::id();
       
        {
        $query = "SELECT U.id, U.n_colegiado, AP.Nombre1, S.estado_solicitud_ap
        FROM sigecig_solicitudes_ap U
        INNER JOIN sigecig_estado_solicitud_ap S ON U.id_estado_solicitud=S.id
        INNER JOIN adm_usuario AU ON AU.Usuario=U.n_colegiado
        INNER JOIN adm_persona AP ON AU.idPersona = AP.idPersona
        WHERE S.id >=3";
        }
    	
        
        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }
}

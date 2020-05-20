<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Colegiado;
use App\Empresa;
use App\User;
use Validator;

class ReciboController extends Controller
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
        return view('admin.creacionRecibo.index');
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

    public function getDatosColegiado($n_cliente)
    {
        $datos = DB::table('cc00')
        ->select('n_cliente', 'estado', 'f_ult_timbre', 'f_ult_pago')
        ->where('c_cliente', $c_cliente)
        ->get();
    }

    public function getDatosEmpresa()
    {
        $tipoCliente = Input::get('tipoCliente');
        if($tipoCliente == 'e') {
            return $this->getDatosColegiado();
        } else if ($tipoCliente == 'e') {
            $query = "SELECT CODIGO colegiado, EMPRESA nombres, '' apellidos FROM MAEEMPR WHERE CODIGO=:nit";
            $parametros = array(':nit' => Input::get('colegiado'));
            $users = DB::select($query, $parametros);
            $colegiadoR = null;
            foreach($users as $colegiado) {
                $colegiadoR = $colegiado;
            }
            if(!$colegiadoR) {
                $respuesta = array('error' => '1', 'mensaje' => 'Datos no encontrados');
                return json_encode($respuesta);
            }
            return json_encode($colegiadoR);
        }
    }
}

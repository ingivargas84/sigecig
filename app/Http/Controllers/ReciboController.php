<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\SQLSRV_Colegiado;
use App\SQLSRV_Empresa;
use App\TipoDePago;
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
        $tipo = TipoDePago::where('estado', '=', 0)->get(); //el estado "0" son los tipo de pago activos
        return view('admin.creacionRecibo.index', compact('tipo'));
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

    public function getDatosColegiado($colegiado)
    {
        $consulta= SQLSRV_Colegiado::select('n_cliente', 'estado', 'f_ult_timbre', 'f_ult_pago', 'monto_timbre')
            ->where('c_cliente', $colegiado)->get()->first();

        return $consulta;
        //dd($consulta);
    }

    public function getDatosEmpresa($nit)
    {
        $consulta= SQLSRV_Empresa::select('empresa')
            ->where('nit', $nit)->get()->first();

        return $consulta;
    }

    public function getTipoDePago($tipo)
    {
        $consulta= TipoDePago::select('codigo', 'tipo_de_pago', 'precio_colegiado', 'precio_particular')
            ->where('id', $tipo)->where('estado', '=', 0)->get()->first();

            return $consulta;
    }
}

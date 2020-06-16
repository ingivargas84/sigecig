<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\ActualizacionBitacora;
use Carbon\Carbon;
use App\Colaborador;
use App\Puesto;
use App\Departamento;
use App\Subsedes;
use App\User;

class ColaboradorController extends Controller
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
        return view ('admin.colaborador.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $puestos = Puesto::all();
        $departamentos = Departamento::all();
        $user = User::select('sigecig_users.id','sigecig_users.username')
        ->leftJoin('sigecig_colaborador','sigecig_users.id','=','sigecig_colaborador.usuario')
        ->wherenull('sigecig_colaborador.usuario')
        ->where('sigecig_users.id', '>=', '2')
        ->get();
        $sub = Subsedes::all();

        return view ('admin.colaborador.create', compact('puestos','departamentos', 'sub', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $colaborador = Colaborador::create($data);
        $colaborador->estado = 1;
        $colaborador->save();

        event(new ActualizacionBitacora($colaborador->id, Auth::user()->id, 'Creacion', '', $colaborador,'Colaborador'));

        return redirect()->route('colaborador.index')->withFlash('Colaborador se creo exitosamente!');
    }

    public function dpiDisponible(){
        $dato = Input::get("dpi");
        $query = Colaborador::where("dpi",$dato)->where('estado', 1)->get();
             $contador = count($query);
        if ($contador == 0 )
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
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
    public function edit(Colaborador $colaborador)
    {
        $puestos = Puesto::all();
        $departamentos = Departamento::all();
        $user = User::select('sigecig_users.id','sigecig_users.username')
        ->leftJoin('sigecig_colaborador','sigecig_users.id','=','sigecig_colaborador.usuario')
        ->wherenull('sigecig_colaborador.usuario')
        ->where('sigecig_users.id', '>=', '2')
        ->get();
        $sub = Subsedes::all();
        

        return view ('admin.colaborador.edit', compact('colaborador','puestos','departamentos', 'sub', 'user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Responses
     */
    public function update(Colaborador $colaborador, Request $request)
    {
        $nuevos_datos = array(
            'nombre' => $request->nombre,
            'dpi' => $request->dpi,
            'puesto' => $request->puesto,
            'departamento' => $request->departamento,
            'telefono' => $request->telefono,
            'usuario' => $request->usuario
        );
        $json = json_encode($nuevos_datos);

        $colaborador->update($request->all());

        return redirect()->route('colaborador.index', $colaborador)->with('flash','el colaborador ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colaborador $colaborador, Request $request)
    {
        $colaborador->estado=0;
        $colaborador->save();
        return Response::json(['success' => 'Éxito']);
    }

    public function getJson(Request $params)
     {
         $api_Result['data'] = Colaborador::where('estado','!=',0)->get();
         return Response::json( $api_Result );
     }
    }

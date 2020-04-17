<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Colaborador;
use App\Puesto;
use App\Departamento;

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
        return view ('administracion.colaborador.index');
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
        return view ('administracion.colaborador.create', compact('puestos','departamentos')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $colaborador=new Colaborador;
        $colaborador->nombre=$request->get('nombre');
        $colaborador->puesto=$request->get('puesto');
        $colaborador->departamento=$request->get('departamento');
        $colaborador->telefono=$request->get('telefono');
        $colaborador->estado=1;
        $colaborador->save();

        return redirect()->route('colaborador.index')->withFlash('Colaborador se creo exitosamente!');
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
        return view ('administracion.colaborador.edit', compact('colaborador','puestos','departamentos')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Colaborador $colaborador, Request $request)
    {
        $nuevos_datos = array(
            'nombre' => $request->nombre,
            'puesto' => $request->puesto,
            'departamento' => $request->departamento,
            'telefono' => $request->telefono,
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

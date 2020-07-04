<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\InformeLlamada;
use App\User;
use Validator;

class InformeLlamadasController extends Controller
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
        return view('admin.llamada.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.llamada.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $informe= new InformeLlamada;
        $informe->fecha_hora=now();
        $informe->colegiado=$request->get('colegiado');
        $informe->telefono=$request->get('telefono');
        $informe->observaciones=$request->get('observaciones');
        $informe->userid=Auth::user()->id;
        $informe->save();

        return redirect()->route('llamada.new')->withFlash('El Informe ha sido ingresado exitosamente.');
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
    public function edit(InformeLlamada $informe)
    {
        return view('admin.llamada.edit', compact('informe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InformeLlamada $informe, Request $request)
    {
        $nuevos_datos = array(
            'colegiado' => $request->colegiado,
            'telefono' => $request->telefono,
            'observaciones' => $request->observaciones,
            'userid' => Auth::user()->id,
            );
        $json = json_encode($nuevos_datos);

        $informe->update($request->all());

        return redirect()->route('llamada.index', $informe)->with('flash','El informe ha sido actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(InformeLlamada $informe)
    {
        $informe->deleted_at=now();
        $informe->save();

        return Response::json(['success' => 'Éxito']);
    }

    public function getJson(Request $params)
     {
         $api_Result['data'] = InformeLlamada::all();
         return Response::json( $api_Result );
     }
}

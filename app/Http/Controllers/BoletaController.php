<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Boleta;
use App\Events\ActualizacionBitacoraBoleta;
use App\User;
use Validator;


class BoletaController extends Controller
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
        return view ('admin.boleta.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.boleta.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $boleta=new Boleta;
        $boleta->no_boleta=$request->get('no_boleta');
        $boleta->nombre_usuario=$request->get('nombre_usuario');
        $boleta->estado_boleta='1';
        $boleta->estado_proceso='1';
        $boleta->solicitud_boleta_id=$request->get('solicitud_boleta_id');
        $boleta->save();

        event(new ActualizacionBitacoraBoleta($boleta->no_boleta, 'Creacion', Auth::user()->id, date("Y-m-d")));
        return redirect()->route('boleta.index')->withFlash('La boleta ha sido creada exitosamente');
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
    public function edit(Boleta $boleta)
    {
        return view('admin.boleta.edit', compact('boleta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Boleta $boleta, Request $request)
    {
        $nuevos_datos = array(
            'no_boleta' => $request->no_boleta,
            'nombre_usuario' => $request->nombre_usuario,
            'user_id' => Auth::user()->id,
            );
        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacoraBoleta($boleta->no_boleta, 'Edicion', Auth::user()->id, date("Y-m-d")));

        $boleta->update($request->all());

        return redirect()->route('boleta.index', $boleta)->with('flash','La Boleta ha sido actualizada!');
    }

    public function destroy(Boleta $boleta, Request $request)
     {
        $boleta->estado_boleta = 2; //este estado es el que se muestra en boleta.index
        $boleta->estado_proceso = 4;
        $boleta->save();

        event(new ActualizacionBitacoraBoleta($boleta->no_boleta, 'Eliminar', Auth::user()->id, date("Y-m-d")));
        return Response::json(['success' => 'Éxito']);
     }

    public function delete(Boleta $boleta, Request $request)
     {
        $boleta->estado_boleta = 3;
        $boleta->save();

        event(new ActualizacionBitacoraBoleta($boleta->no_boleta, 'Eliminar', Auth::user()->id, date("Y-m-d")));
        return Response::json(['success' => 'Éxito']);
     }

     public function activar(Boleta $boleta, Request $request)
     {
        $boleta->estado_boleta = 1;
        $boleta->estado_proceso = 1;
        $boleta->save();

        event(new ActualizacionBitacoraBoleta($boleta->no_boleta, 'Activar', Auth::user()->id, date("Y-m-d")));
        return Response::json(['success' => 'Éxito']);
     }

    public function getJson(Request $params)
     {
         $api_Result['data'] = Boleta::where('estado_boleta','!=',3)->get();
         return Response::json( $api_Result );
     }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\SolicitudBoleta;
use App\User;
use Validator;


class SolicitudBoletaController extends Controller
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
        return view ("gerencia.solicitud.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("gerencia.solicitud.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $solBoleta=new SolicitudBoleta;
        $solBoleta->fecha=$request->get('fecha');
        $solBoleta->departamento_id=$request->get('departamento_id');
        $solBoleta->descripcion_boleta=$request->get('descripcion_boleta');
        $solBoleta->responsable=$request->get('responsable');
        $solBoleta->user_id =$request->get('user_id');
        $solBoleta->estado_solicitud='1';
        $solBoleta->quien_la_usara=$request->get('quien_la_usara');
        $solBoleta->save();

        return redirect()->route('solicitud.index')->withFlash('La solicitud se ha creado exitosamente!');
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
    public function edit(SolicitudBoleta $solBoleta)
    {
        return view('gerencia.solicitud.edit', compact('solBoleta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SolicitudBoleta $solBoleta,Request $request)
    {
        $nuevos_datos = array(
            'fecha' => $request->fecha,
            'departamento_id' => $request->departamento_id,
            'descripcion_boleta' => $request->descripcion_boleta,
            'responsable' => $request->responsable,
            'estado_solicitud' => $request->estado_solicitud,
            'quien_la_usara' => $request->quien_la_usara,
            'user_id' => Auth::user()->id,
            );
        $json = json_encode($nuevos_datos);

        $solBoleta->update($request->all());
      
        return redirect()->route('solicitud.index', $solBoleta)->with('flash','La solicitud de ingreso ha sido actualizada!');
    }

    //funcion destroy rechaza el registro en estado_solicitud: 2
    public function destroy(SolicitudBoleta $solBoleta, Request $request)
     {
        $solBoleta->estado_solicitud = 2;
        $solBoleta->save();

        return Response::json(['success' => 'Éxito']);       
     }

    public function activar(SolicitudBoleta $solBoleta, Request $request)
     {
        $solBoleta->estado_solicitud = 1;
        $solBoleta->save();

        return Response::json(['success' => 'Éxito']);       
     }

     //funcion delete elimina el registro en estado_solicitud: 4
     public function delete(SolicitudBoleta $solBoleta, Request $request)
     {
            $solBoleta->estado_solicitud = 4;
            $solBoleta->save();

            return Response::json(['success' => 'Éxito']); 
    }

    public function getJson(Request $params)
     {
            $api_Result['data'] = SolicitudBoleta::where('estado_solicitud','!=',4)->get();
            return Response::json( $api_Result );
        
     }


}

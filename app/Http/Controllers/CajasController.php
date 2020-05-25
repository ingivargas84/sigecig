<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Cajaspport\Facades\Redirect;
use Illuminate\Cajaspport\Facades\Response;
use Illuminate\Cajaspport\Facades\Auth;
use Illuminate\Cajaspport\Facades\Input;
use Illuminate\Cajaspport\Facades\Session;
use App\Events\ActualizacionBitacora;
use Carbon\Carbon;
use App\Cajasbsedes;
use App\User;
use Validator;

class CajasController extends Controller
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
        return view('admin.cajas.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.cajas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cajas=new Cajas;
        $cajas->nombre_caja=$request->get('nombre_caja');
        $cajas->cajero=$request->get('cajero');
        $cajas->subsede=$request->get('subsede');
        $cajas->estado=1; // estado uno representa como activo
        $cajas->save();

        event(new ActualizacionBitacora(1, Auth::user()->id,'creacion', '', $Cajas, 'cajas' ));

        return redirect()->route('cajas.index')->with('flash','La Cajas ha sido creada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cajas  $cajas
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cajas  $cajas
     * @return \Illuminate\Http\Response
     */
    public function edit(Cajas $cajas)
    {
        return view('admin.cajas.edit', compact('cajas'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cajas  $cajas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cajas $Cajas)
    {
        $nuevos_datos = array(
            'nombre_caja' => $request->nombre_sede,
            'cajero' => $request->cajero,
            'subsede' => $request->subsede,


        );
        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora(1, Auth::user()->id,'edicion', $cajas, $json, 'cajas' ));
        $cajas->update($request->all());
        return redirect()->route('cajas.index', $cajas)->with('flash','la cajasbsede ha sido actualizada');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cajas  $cajas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cajas $cajas )
    {
        $cajas->estado=0;
        $cajas->save();
        event(new ActualizacionBitacora(1, Auth::user()->id,'desactivacion', '', $cajas, 'cajas' ));
        return Response::json(['cajasccess' => 'exito']);

    }

    public function delete(Request $request, Cajas $cajas )
    {
        $cajas->delete_at=now();
        $cajas->save();
        event(new ActualizacionBitacora(1, Auth::user()->id,'eliminacion', '', $cajas, 'cajas' ));
        return Response::json(['cajasccess' => 'se ha eliminado con exito']);

    }

    public function activar(Request $request, Cajas $cajas )
    {
        $cajas->estado=1;
        $cajas->save();
        event(new ActualizacionBitacora(1, Auth::user()->id,'activo', '', $cajas, 'cajas' ));
        return Response::json(['cajasccess' => 'activado con exito']);

    }

    public function nombreDisponible(){
        $dato = Input::get("nombre_sede");
        $query = Cajas::where("nombre_sede",$dato)->where('estado', 1)->get();
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

    public function nombreDisponibleEdit(){

        $dato = Input::get("nombre_sede");
        $id = Input::get("num");

        $query = Cajas::where("nombre_sede",$dato)->where("estado", 1)->where("id","!=",$id)->get();

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


    public function getJson(Request $params)
     {
         //$api_Recajaslt['data'] = Cajas::where('estado','=',1)->get();
         $api_Recajaslt['data'] = Cajas::all();
         return Response::json( $api_Recajaslt );
     }

}


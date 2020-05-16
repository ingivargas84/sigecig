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
use App\Subsedes;
use App\User;
use Validator;


class SubsedesController extends Controller
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
        return view('subsedes.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subsedes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $su=new Subsedes;
        $su->nombre_sede=$request->get('nombre_sede');
        $su->direccion=$request->get('direccion');
        $su->telefono=$request->get('telefono');
        $su->telefono_2=$request->get('telefono_2');
        $su->correo_electronico=$request->get('correo_electronico');
        $su->estado=1; // estado uno representa como activo
        $su->save();


        event(new ActualizacionBitacora(1, Auth::user()->id,'creacion', '', $su, 'subsedes' ));
        return redirect()->route('subsedes.index')->withFlash('subsede se creo exitosamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subsedes  $subsedes
     * @return \Illuminate\Http\Response
     */
    public function show(Subsedes $su)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subsedes  $subsedes
     * @return \Illuminate\Http\Response
     */
    public function edit(Subsedes $su)
    {
        return view('subsedes.edit', compact('su'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subsedes  $subsedes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subsedes $su)
    {
        $nuevos_datos = array(
            'nombre_sede' => $request->nombre_sede,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'telefono_2' => $request->telefono_2,
            'correo_electronico' => $request->correo_electronico,


        );
        $json = json_encode($nuevos_datos);



        event(new ActualizacionBitacora(1, Auth::user()->id,'edicion', $su, $json, 'subsedes' ));
        $su->update($request->all());
        return redirect()->route('subsedes.index', $su)->with('flash','la subsede ha sido actualizada');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subsedes  $subsedes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Subsedes $su )
    {
        $su->estado=0;
        $su->save();
        event(new ActualizacionBitacora(1, Auth::user()->id,'desactivacion', '', $su, 'subsedes' ));
        return Response::json(['success' => 'exito']);

    }


    public function delete(Request $request, Subsedes $su )
    {
        $su->delete_at=now();
        $su->save();
        event(new ActualizacionBitacora(1, Auth::user()->id,'eliminacion', '', $su, 'subsedes' ));
        return Response::json(['success' => 'se ha eliminado con exito']);

    }

    public function activar(Request $request, Subsedes $su )
    {
        $su->estado=1;
        $su->save();
        event(new ActualizacionBitacora(1, Auth::user()->id,'activo', '', $su, 'subsedes' ));
        return Response::json(['success' => 'activado con exito']);

    }

    public function nombreDisponible(){
        $dato = Input::get("nombre_sede");
        $query = Subsedes::where("nombre_sede",$dato)->where('estado', 1)->get();
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

        $query = Subsedes::where("nombre_sede",$dato)->where("estado", 1)->where("id","<>",$id)->get();

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
         //$api_Result['data'] = Subsedes::where('estado','=',1)->get();
         $api_Result['data'] = Subsedes::all();
         return Response::json( $api_Result );
     }

}

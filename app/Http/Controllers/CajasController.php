<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Events\ActualizacionBitacora;
use Carbon\Carbon;
use App\Cajasbsedes;
use App\User;
use App\Cajas;
use App\Subsedes;
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
        $subsede = Subsedes::all();
        $caja = Cajas::all();
       // $user = User::all();

        $query= "SELECT U.name, U.id
        FROM sigecig_users U
        INNER JOIN model_has_roles MR ON MR.model_id = U.id
        WHERE MR.role_id = '18'";
         
        $datos = DB::select($query);

        //$rol = Roles::where('id', '=', $modelrol->role_id)->get();
       // $user =User::where('id', '=',  $modelrol->model_id)->get();
       
        return view('admin.cajas.index', compact( 'subsede', 'caja', 'datos'));

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

        event(new ActualizacionBitacora(1, Auth::user()->id,'creacion', '', $cajas, 'Cajas' ));
        return response()->json(['success' => 'Exito']);

      //  return redirect()->route('cajas.index')->with('flash','La Caja ha sido creada correctamente');
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
    public function update(Request $request, Cajas $cajas)
    {
        $nuevos_datos = array(
            'nombre_caja' => $request->nombre_caja,
            'cajero' => $request->cajero,
            'subsede' => $request->subsede,
        );
        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora(1, Auth::user()->id,'Edicion', $cajas, $json, 'cajas' ));
        $cajas->update($request->all());
        return Response::json(['success' => 'Éxito']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cajas  $cajas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cajas $cajas )
    {
        $cajas->estado=0; //estado 0 = desactivado
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
        event(new ActualizacionBitacora(1, Auth::user()->id,'activacion', '', $cajas, 'cajas' ));
        return Response::json(['success' => 'activado con exito']);

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

        $query = "SELECT C.id, C.nombre_caja, S.nombre_sede, C.estado, U.name
        FROM sigecig_cajas C
        INNER JOIN sigecig_subsedes S ON C.id = S.id
        INNER JOIN sigecig_users U ON C.cajero = U.id";

        $api_Result['data'] = DB::select($query);
        return Response::json( $api_Result );
     }

}


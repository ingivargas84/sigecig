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
use App\User;
use App\Cajas;
use App\Subsedes;
use App\Bodegas;
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
        //Obtener subsedes
        $datos2 = "SELECT S.id, S.nombre_sede
        FROM sigecig_subsedes S
        WHERE S.estado = 1";
        $subsede = DB::select($datos2);

        //Obtener los cajeros
        $query= "SELECT U.name, U.id
        FROM sigecig_users U
        INNER JOIN model_has_roles MR ON MR.model_id = U.id
        WHERE MR.role_id = '18'
        AND U.id  NOT IN (SELECT cajero FROM sigecig_cajas)
        AND U.estado = 1";
        $datos = DB::select($query);
                    
        //Obtener bodegas
        $da = "SELECT B.id, B.nombre_bodega
        FROM sigecig_bodega B
       
        WHERE B.id  NOT IN (SELECT bodega FROM sigecig_cajas)
        AND B.estado = 1";
        $datos1 = DB::select($da); 
       
        $cj = Cajas::all();
        $bds = Bodegas::all();
        
        return view('admin.cajas.index', compact( 'subsede', 'datos', 'datos1'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function editBodegaCaja(Cajas $id)
    {
        $da = "SELECT B.id, B.nombre_bodega
        FROM sigecig_bodega B
       
        WHERE B.id  NOT IN (SELECT bodega FROM sigecig_cajas)
        AND B.estado = 1
        OR B.id = $id->bodega";
        $datos1 = DB::select($da); 

        $query= "SELECT U.name, U.id
        FROM sigecig_users U
        INNER JOIN model_has_roles MR ON MR.model_id = U.id
        WHERE MR.role_id = '18'
        AND U.id  NOT IN (SELECT cajero FROM sigecig_cajas)
        AND U.estado = 1
        OR U.id = $id->cajero";
        $datos = DB::select($query);

        return array($datos1, $datos);
      //  $bodega = Bodegas::where('id', $id->bodega)->get()->first();
//
    }

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
        $cajas->bodega=$request->get('bodega');
        $cajas->estado=1; // estado uno representa como activo
        $cajas->save();

        event(new ActualizacionBitacora(1, Auth::user()->id,'creacion', '', $cajas, 'Cajas' ));
        return response()->json(['success' => 'Exito']);
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
    public function update(Request $request, Cajas $cajas, Subsedes $subsede)
    {
        $nuevos_datos = array(
            'nombre_caja' => $request->nombre_caja,
            'subsede' => $request->subsede,
            'cajero' => $request->cajero,
            'bodega' => $request->bodega,
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
        $dato = Input::get("nombre_caja");
        $query = Cajas::where("nombre_caja",$dato)->where('estado', 1)->get();
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

    public function nombreDisponibleEdit(Request $request){

        $dato = $request->value;
        $id = $request->id;

        $query = Cajas::where("nombre_caja",$dato)->where("id","!=",$id)->get();

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
        $query = "SELECT C.id, C.nombre_caja, C.cajero, C.bodega, C.subsede, S.nombre_sede, C.estado, U.name, B.nombre_bodega
        FROM sigecig_cajas C
        INNER JOIN sigecig_subsedes S ON C.subsede = S.id
        INNER JOIN sigecig_users U ON C.cajero = U.id
        INNER JOIN sigecig_bodega B ON B.id = C.bodega";

        $api_Result['data'] = DB::select($query);
        return Response::json( $api_Result );
     }
}


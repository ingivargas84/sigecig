<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\Events\ActualizacionBitacora;
use Carbon\Carbon;
use App\User;
use App\Bodegas;
use App\Cajas;


class BodegasController extends Controller
{
    public function index()
    {
        return view('admin.bodegas.index');
    }

    public function store(Request $request)
    {
        $bodegas=new Bodegas;
        $bodegas->nombre_bodega=$request->get('nombre_bodega');
        $bodegas->descripcion=$request->get('descripcion');
        $bodegas->estado=1; // estado uno representa como activo
        $bodegas->save();

        event(new ActualizacionBitacora(1, Auth::user()->id,'creacion', '', $bodegas, 'Bodegas' ));
        return response()->json(['success' => 'Exito']);
    }

    public function update(Request $request, Bodegas $bodegas)
    {
        $nuevos_datos = array(
            'nombre_bodega' => $request->nombre_bodega,
            'descripcion' => $request->descripcion,
        );
        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora(1, Auth::user()->id,'Edicion', $bodegas, $json, 'bodegas' ));
        $bodegas->update($request->all());
        return Response::json(['success' => 'Éxito']);
    }

    public function destroy(Bodegas $bodegas, Request $request)
    {
        $bodegas->estado=0;
        $bodegas->save();
        return Response::json(['success' => 'Éxito']);
    }

    public function nombreDisponible(){
        $dato = Input::get("nombre_bodega");
        $query = Bodegas::where("nombre_bodega",$dato)->where('estado', 1)->get();
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

        $query = Bodegas::where("nombre_bodega",$dato)->where("id","!=",$id)->get();

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
        $query = "SELECT B.id, B.nombre_bodega, B.descripcion, B.estado
        FROM sigecig_bodega B
        WHERE B.estado != 0";

        $api_Result['data'] = DB::select($query);
        return Response::json( $api_Result );
     }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\TipoDePago;
use App\CategoriaTipoPago;
use App\Events\ActualizacionBitacora;
use App\User;
use Validator;

class TipoDePagoController extends Controller
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
        $cat = CategoriaTipoPago::all();
        return view('admin.tipodepago.index', compact( 'cat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TipoDePago $tipo)
    {
        // $cat = CategoriaTipoPago::all();
        // return view('tipodepago.createModal', compact( 'cat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipo = new TipoDePago;
        $tipo->codigo=$request->get('codigo');
        $tipo->tipo_de_pago=$request->get('tipo_de_pago');
        $tipo->precio_colegiado=$request->get('precio_colegiado');
        $tipo->precio_particular=$request->get('precio_particular');
        $tipo->categoria_id=$request->get('categoria_id');
        $tipo->estado=0; //el estado 0 es activo
        $tipo->save();


        event(new ActualizacionBitacora(1, Auth::user()->id, 'Creacion', '', $tipo,'Tipo De Pago'));

        return response()->json(['success' => 'Exito']);
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
    public function edit(CategoriaTipoPago $cat)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TipoDePago $tipo, Request $request)
    {
        $nuevos_datos = array(
            'codigo' => $request->codigo,
            'tipo_de_pago' => $request->tipo_de_pago,
            'precio_colegiado' => $request->precio_colegiado,
            'precio_particular' => $request->precio_particular,
            'categoria_id' => $request->categoria_id,
            );
        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora(1, Auth::user()->id, 'Edicion', $tipo, $json,'Tipo De Pago'));

        $tipo->update($request->all());

        //return redirect()->route('tipoDePago.index', $tipo)->with('flash','Tipo de pago ha sido actualizado!');
        return Response::json(['success' => 'Éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoDePago $tipo, Request $request)
     {
        $tipo->estado = 1; //este estado es el que desactiva el tipo de pago para que ya no lo muestre
        $tipo->save();

        event(new ActualizacionBitacora(1, Auth::user()->id, 'Desactivacion', $tipo,'','Tipo De Pago'));
        return Response::json(['success' => 'Éxito']);
    }

    public function delete(TipoDePago $tipo, Request $request)
     {
        $tipo->deleted_at=now(); //este campo de delete, borra el registro
        $tipo->save();

        event(new ActualizacionBitacora(1, Auth::user()->id, 'Elminacion', '', $tipo,'Tipo De Pago'));
        return Response::json(['success' => 'Éxito']);
     }

     public function activar(TipoDePago $tipo, Request $request)
     {
        $tipo->estado = 0;
        $tipo->save();

        event(new ActualizacionBitacora(1, Auth::user()->id, 'Activacion', $tipo,'','Tipo De Pago'));
        return Response::json(['success' => 'Éxito']);
     }

     public function nombreDisponible(){
        $dato = Input::get("codigo");
        $query = TipoDePago::where("codigo",$dato)->where('estado', '!=', null)->get();
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
        $dato = Input::get("codigo");
        $id = Input::get('id');
        $query = TipoDePago::where("codigo",$dato)->where('id','!=', $id)->get();
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
         $api_Result['data'] = TipoDePago::all();
         return Response::json( $api_Result );
     }


}

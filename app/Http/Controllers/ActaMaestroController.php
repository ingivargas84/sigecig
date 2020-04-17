<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\ActaMaestro;
use App\ActaDetalle;
use App\User;
use Validator;

class ActaMaestroController extends Controller
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
        return view ('juntadirectiva.acta.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('juntadirectiva.acta.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $acta = new ActaMaestro;
        $acta->no_acta=$request->get('no_acta');
        $acta->fecha_acta=$request->get('fecha_acta');
        /*
        if(Input::hasFile('pdf_acta')){
            $file=Input::file('pdf_acta');
            $file->move(public_path().'/documentos/actas/',$file->getClientOriginalName());
            $acta->pdf_acta=$file->getClientOriginalName();
        }*/
        
        if($request->hasFile('pdf_acta')){
            $file = $request->file('pdf_acta');
            $name = date("Y-m-d")." / ".$file->getClientOriginalName();      
            $file->move(public_path().'/documentos/actas/', $name);   
        };
        
        $acta->pdf_acta=$name;  
        $acta->estado='1';
        $acta->save();

        return redirect()->route('acta.index')->withFlash('Acta creada Exitosamente');
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
    public function edit(ActaMaestro $acta)
    {
        return view('juntadirectiva.acta.edit', compact('acta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActaMaestro $acta, Request $request)
    {   

        $nuevos_datos = array(
            'no_acta' => $request->no_acta,
            'fecha_acta' => $request->fecha_acta,
            //'pdf_acta' => $request->pdf_acta

            
        );
        $json = json_encode($nuevos_datos);

        $acta->update($request->all());

        return redirect()->route('acta.index', $acta)->withFlash('El acta ha sido actualizado!');
    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActaMaestro $acta, Request $request)
    {
        $acta->estado=0;
        $acta->save();

        return Response::json(['success' => 'Exito']);
    }

    public function getJson(Request $params)
    {
        $api_Result['data'] = ActaMaestro::where('estado','=','1')->get();
        return Response::json( $api_Result );
    }
}

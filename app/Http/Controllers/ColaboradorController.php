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
use App\Colaborador;
use App\Puesto;
use App\Departamento;
use App\Subsedes;
use App\DeptosGuatemala;
use App\MunicipiosGuatemala;
use App\User;

class ColaboradorController extends Controller
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
        return view ('admin.colaborador.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $puestos = Puesto::all();
        $departamentos = Departamento::all();
        $user = User::select('sigecig_users.id','sigecig_users.username')
        ->leftJoin('sigecig_colaborador','sigecig_users.id','=','sigecig_colaborador.usuario')
        ->wherenull('sigecig_colaborador.usuario')
        ->where('sigecig_users.id', '>=', '2')
        ->get();
        $sub = Subsedes::all();
        $deptosG = DeptosGuatemala::all();

        return view ('admin.colaborador.create', compact('puestos','departamentos', 'sub', 'user', 'deptosG'));
    }

    public function getMunicipio($value)
    {
        $municipiosG = MunicipiosGuatemala::all()->where('iddepartamento', $value);

        return json_encode($municipiosG);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $colaborador = new Colaborador;
        $colaborador->nombre = $request->nombre;
        $colaborador->dpi = $request->dpi;
        $colaborador->departamento_dpi_id = $request->departamentoDPI;
        $colaborador->municipio_dpi_id = $request->municipioDPI;
        $colaborador->puesto = $request->puesto;
        $colaborador->departamento = $request->departamento;
        $colaborador->subsede = $request->subsede;
        $colaborador->telefono = $request->telefono;
        $colaborador->usuario = $request->usuario;
        $colaborador->estado = 1;
        $colaborador->save();

        event(new ActualizacionBitacora($colaborador->id, Auth::user()->id, 'Creacion', '', $colaborador,'Colaborador'));

        return redirect()->route('colaborador.index')->withFlash('Colaborador se creo exitosamente!');
    }

    public function dpiDisponible(){
        $dato = Input::get("dpi");
        $query = Colaborador::where("dpi",$dato)->where('estado', 1)->get();
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

    public function dpiDisponibleEdit(){
        $dato = Input::get("dpi");
        $query = Colaborador::where("dpi", $dato)->where('estado', 1)->where("dpi", '!=',$dato)->get();
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

    public function getDepartamentoEdit(Colaborador $value)
    {
        // $dato = Departamento::select("departamento_dpi_id", "municipio_dpi_id")->where('id', $value)->get()->first();
        $deptoG = DeptosGuatemala::select("iddepartamento")->where('iddepartamento', $value->departamento_dpi_id)->get()->first();
        $minuG = MunicipiosGuatemala::select("idmunicipio")->where('idmunicipio', $value->municipio_dpi_id)->get()->first();

        return array($deptoG, $minuG);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Colaborador $colaborador)
    {
        $puestos = Puesto::all();
        $departamentos = Departamento::all();
         $user = User::select('sigecig_users.id','sigecig_users.username')
        ->leftJoin('sigecig_colaborador','sigecig_users.id','=','sigecig_colaborador.usuario')
        ->wherenull('sigecig_colaborador.usuario')
        ->where('sigecig_users.id', '>=', '2')
        ->get();

        $userExist = User::select('sigecig_users.id','sigecig_users.username')
        ->leftJoin('sigecig_colaborador','sigecig_users.id','=','sigecig_colaborador.usuario')
        ->where('sigecig_users.id', '=', $colaborador->usuario)
        ->get();

        $deptosG = DeptosGuatemala::all();

        // $deptosG = DeptosGuatemala::select("iddepartamento", "nombre")->where('iddepartamento', $colaborador->departamento_dpi_id)->get()->first();
        // $municipioG = MunicipiosGuatemala::select("idmunicipio", "nombre")->where('idmunicipio', $colaborador->municipio_dpi_id)->get()->first();
        // dd($deptosG);
       /*  $query= "SELECT U.username, U.id, SC.usuario
        FROM sigecig_users U
        INNER JOIN sigecig_colaborador SC ON SC.usuario = U.id
        WHERE U.id >= '2' AND SC.usuario IS NULL";

        $user = DB::select($query);*/
//dd($departamentos);
        $sub = Subsedes::all();
        //dd($user);

        return view ('admin.colaborador.edit', compact('colaborador','puestos','departamentos', 'sub', 'user', 'deptosG', 'userExist'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Responses
     */
    public function update(Colaborador $colaborador, Request $request)
    {
        $nuevos_datos = array(
            'nombre' => $request->nombre,
            'dpi' => $request->dpi,
            'departamento_dpi_id' => $request->departamentoDPI,
            'municipio_dpi_id' => $request->municipioDPI,
            'puesto' => $request->puesto,
            'departamento' => $request->departamento,
            'subsede' => $request->subsede,
            'telefono' => $request->telefono,
            'usuario' => $request->usuario
        );
        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora(1, Auth::user()->id,'edicion', $colaborador, $json, 'colaborador' ));

        $query = "UPDATE sigecig_colaborador SET nombre = :nombre, dpi = :dpi, departamento_dpi_id = :departamento_dpi_id, municipio_dpi_id = :municipio_dpi_id, puesto = :puesto,
                  departamento = :departamento, subsede= :subsede, telefono = :telefono, usuario = :usuario WHERE id = :id";
        $parametros = array(':id' => $request->id,  ':nombre' => $request->nombre, ':dpi' => $request->dpi,':departamento_dpi_id' => $request->departamentoDPI, ':municipio_dpi_id' => $request->municipioDPI,
                            ':puesto' => $request->puesto, ':departamento' => $request->departamento, ':subsede' => $request->subsede, ':telefono' => $request->telefono, ':usuario' => $request->usuario);
        $result = DB::connection('mysql')->update($query, $parametros);

        // $colaborador->update($request->all());

        return redirect()->route('colaborador.index', $colaborador)->with('flash','el colaborador ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colaborador $colaborador, Request $request)
    {
        $colaborador->estado=0;
        $colaborador->save();
        return Response::json(['success' => 'Éxito']);
    }

    public function getJson(Request $params)
     {
          $api_Result['data'] = Colaborador::where('estado','!=',0)->get();
         return Response::json( $api_Result );

        /*  $query = "SELECT T.id, T.nombre, T.dpi, T.puesto, T.departamento, T.subsede, T.telefono, T.usuario, T.estado, U.username, U.id
         FROM sigecig_colaborador T
         LEFT JOIN sigecig_users U ON T.usuario = U.id
         WHERE T.estado != 0";

         $api_Result['data'] = DB::select($query);
          return Response::json( $api_Result ); */
     }
    }

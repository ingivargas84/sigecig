<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\ServiceProvider;
use App\PlataformaSolicitudAp;
use App\Banco;
use App\TipoDeCuenta;



class ResolucionPagoController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    function imprimir(){
        $pdf = \PDF::loadView('admin.firmaresolucion.pdf');
        return $pdf->stream('primerpdf.pdf');
    }
    
    
    public function index()
    {
        $user = Auth::User();
        return view ('admin.firmaresolucion.index', compact('user'));
    }
    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $user = new User;
    }

    public function asap(PlataformaSolicitudAp $solicitud)
    {
        $banco = Banco::where("id",$solicitud->id_banco)->get();
        $tipocuenta = TipoDeCuenta::where("id",$solicitud->id_tipo_cuenta)->get();

        return view ('admin.firmaresolucion.asap', compact('solicitud','banco','tipocuenta'));
    }
    
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $user = new User;
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
    public function edit($id)
    {
        //
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function addActa(PlataformaSolicitudAp $solicitud, Request $request)
    {
        $nuevos_datos = array(
            'no_acta' => $request->no_acta,
            'no_punto_acta' => $request->no_punto_acta,
            'id_estado_solicitud' => 7,
        );
        $json = json_encode($nuevos_datos);
        
        
        $solicitud->update($nuevos_datos);
        
        //return redirect()->route('tipoDePago.index', $tipo)->with('flash','Tipo de pago ha sido actualizado!');
        return Response::json(['success' => 'Éxito']);
    }
    
    public function mail(request $request)
    {
        $data = $request->all();
        
        Mail::send('mails.cambioestado', ['data' => $data],  function ($m) use ($data) {
            $m->from('visa@cig.org.gt', 'Colegio de Ingenieros de Guatemala');
            $m->to("ing.ivargas21314@gmail.com", "Iver Vargas")->subject('Prueba de Correo');
            
        });
        
        return Response::json($data);
    }
    

    public function destroy($id)
    {
        //
    }

    
    public function solicitudesPendientes()
    {
        $cuenta = PlataformaSolicitudAp::all();

        return \PDF::loadView('admin.firmaresolucion.solicitudes_pendientes', compact("cuenta"))
        ->setPaper('a4', 'landscape')
        ->stream('archivo.pdf');
    }
    
    public function getJson(Request $params)
    {  
        $query = "SELECT U.id, U.no_solicitud, U.n_colegiado, AP.Nombre1, S.estado_solicitud_ap
        FROM sigecig_solicitudes_ap U
        INNER JOIN sigecig_estado_solicitud_ap S ON U.id_estado_solicitud=S.id
        INNER JOIN adm_usuario AU ON AU.Usuario=U.n_colegiado
        INNER JOIN adm_persona AP ON AU.idPersona = AP.idPersona
        WHERE U.id_estado_solicitud >=2";
        
        $result = DB::select($query);
        $api_Result['data'] = $result;
        
        return Response::json( $api_Result );
    }
    
    
    
    
}

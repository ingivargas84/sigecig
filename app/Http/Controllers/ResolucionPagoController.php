<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Image,File,Mail;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Barryvdh\DomPDF\ServiceProvider;
use App\PlataformaSolicitudAp;
use App\AdmPersona;
use App\PlataformaBanco;
use App\PlataformaTipoCuenta;
use App\AdmUsuario;
use App\BitacoraAp;
use Carbon\Carbon;
use App\SQLSRV_Colegiado;
use App\SQLSRV_Profesion;
use App\Events\ActualizacionBitacoraAp;
use Illuminate\Support\Facades\Storage;
use App\Mail\AprobacionDocAp;



class ResolucionPagoController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }

    function imprimir(PlataformaSolicitudAp $id){
        $date = Carbon::now()->toDateTimeString('%A %d %B %Y');
        $adm_usuario=AdmUsuario::where('Usuario', '=', $id->n_colegiado)->get()->first();
        $adm_persona=AdmPersona::where('idPersona', '=', $adm_usuario->idPersona)->get()->first();
        $profesion = SQLSRV_Profesion::where("c_cliente",$id->n_colegiado)->get()->first();
     

        $pdf = \PDF::loadView('admin.firmaresolucion.pdf', compact('id', 'adm_usuario', 'adm_persona', 'date', 'profesion'));
        return $pdf->stream('ArchivoPDF.pdf');
    }

    public function fechaconfig(PlataformaSolicitudAp $tipo, Request $request)
    {
        $fecha = date("Y/m/d h:m:s");

        $nuevos_datos = array(
            'fecha_pago_ap' => $request->fecha_pago_ap,
            'id_estado_solicitud' => 9,

        );
        $json = json_encode($nuevos_datos);
        $tipo->update($nuevos_datos);
        
        event(new ActualizacionBitacoraAp(Auth::user()->id, $tipo->id, $fecha, $tipo->id_estado_solicitud));

        return Response::json(['success' => 'Éxito']);
    }

    public function index()
    {
        $user = Auth::User();
        return view ('admin.firmaresolucion.index', compact('user'));
    }

    public function bitacora(PlataformaSolicitudAp $id)
    {
        $adm_usuario=AdmUsuario::where('Usuario', '=', $id->n_colegiado)->get()->first();
        $adm_persona=AdmPersona::where('idPersona', '=', $adm_usuario->idPersona)->get()->first();
        $profesion = SQLSRV_Profesion::where("c_cliente",$id->n_colegiado)->get()->first();
        $fecha_Nac = SQLSRV_Colegiado::where("c_cliente",$id->n_colegiado)->get()->first();
        $tel = SQLSRV_Colegiado::where("c_cliente",$id->n_colegiado)->get()->first();
        $reg = SQLSRV_Colegiado::where("c_cliente",$id->n_colegiado)->get()->first();
        $tipocuenta = PlataformaTipoCuenta::where("id",$id->id_tipo_cuenta)->get()->first();
        $banco = PlataformaBanco::where("id",$id->id_banco)->get()->first();
        $usuario_cambio = BitacoraAp::where("no_solicitud", '=',$id->id)->orderBy('estado_solicitud', 'asc')->get();

//dd($usuario_cambio);
        $user = Auth::User();
        return view ('admin.bitacora.index', compact('id', 'user', 'adm_usuario', 'adm_persona', 'profesion', 'fecha_Nac', 'tel', 'reg','banco','tipocuenta', 'usuario_cambio'));
    }

    function imprimirbitacora(PlataformaSolicitudAp $id){
        $adm_usuario=AdmUsuario::where('Usuario', '=', $id->n_colegiado)->get()->first();
        $adm_persona=AdmPersona::where('idPersona', '=', $adm_usuario->idPersona)->get()->first();
        $fecha_Nac = SQLSRV_Colegiado::where("c_cliente",$id->n_colegiado)->get()->first();
        $profesion = SQLSRV_Profesion::where("c_cliente",$id->n_colegiado)->get()->first();
        $tel = SQLSRV_Colegiado::where("c_cliente",$id->n_colegiado)->get()->first();
        $reg = SQLSRV_Colegiado::where("c_cliente",$id->n_colegiado)->get()->first();
        $tipocuenta = PlataformaTipoCuenta::where("id",$id->id_tipo_cuenta)->get()->first();
        $banco = PlataformaBanco::where("id",$id->id_banco)->get()->first();
        $usuario_cambio = BitacoraAp::where("no_solicitud", '=',$id->id)->orderBy('estado_solicitud', 'asc')->get();

        $user = Auth::User();

        $pdf = \PDF::loadView('admin.bitacora.pdfbitacora', compact('id', 'user', 'adm_usuario',  'adm_persona', 'profesion', 'fecha_Nac', 'tel', 'reg','banco','tipocuenta', 'usuario_cambio'));
        return $pdf->stream('BitacoraPDF.pdf');
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
        $banco = PlataformaBanco::where("id",$solicitud->id_banco)->get()->first();
        $tipocuenta = PlataformaTipoCuenta::where("id",$solicitud->id_tipo_cuenta)->get()->first();
        $colegiado = SQLSRV_Colegiado::where("c_cliente",$solicitud->n_colegiado)->get()->first();
        $profesion = SQLSRV_Profesion::where("c_cliente",$solicitud->n_colegiado)->get()->first();
        return view ('admin.firmaresolucion.asap', compact('solicitud','banco','tipocuenta','colegiado','profesion'));
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

    public function cambiarestado(PlataformaSolicitudAp $solicitud, Request $request)
    {
// Estado 5 a estado 8
        $fecha = date("Y/m/d h:m:s");
        $nuevos_datos = array(
            'id_estado_solicitud' => 8
                   
        );

        $json = json_encode($nuevos_datos);
        $solicitud->update($nuevos_datos);

        event(new ActualizacionBitacoraAp(Auth::user()->id, $solicitud->id, $fecha, $solicitud->id_estado_solicitud));

        return Response::json(['success' => 'Éxito']);
    }
    
    public function finalizarestado(PlataformaSolicitudAp $solicitud, Request $request)
    {

        //Estado 9 a 10
        $fecha = date("Y/m/d h:m:s");
        $nuevos_datos = array(
            'id_estado_solicitud' => 10,
        );
        $json = json_encode($nuevos_datos);
        $solicitud->update($nuevos_datos);
   
        event(new ActualizacionBitacoraAp(Auth::user()->id, $solicitud->id, $fecha, $solicitud->id_estado_solicitud));

        $auxpost = SQLSRV_Colegiado::where("c_cliente",$solicitud->n_colegiado)->get()->first();
        $auxpost->auxpost='1';
        $auxpost->paga_auxilio='1';
        $auxpost->update();

        return Response::json(['success' => 'Éxito']);
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
        //Estado 7 a 8
        $fecha = date("Y/m/d h:m:s");

        $nuevos_datos = array(
            'no_acta' => $request->no_acta,
            'no_punto_acta' => $request->no_punto_acta,
            'id_estado_solicitud' => 8,
        );
        $json = json_encode($nuevos_datos);
        
        
        $solicitud->update($nuevos_datos);
        event(new ActualizacionBitacoraAp(Auth::user()->id, $solicitud->id, $fecha, $solicitud->id_estado_solicitud));

        //return redirect()->route('tipoDePago.index', $tipo)->with('flash','Tipo de pago ha sido actualizado!');
        return Response::json(['success' => 'Éxito']);
    }
    
    public function sendMail(request $request)
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
        $path = 'images/timbre.png';
        $data = file_get_contents($path);
        $base64 = 'data:image/' . "png" . ';base64,' . base64_encode($data);

        $mytime = Carbon::now();
        $ap = PlataformaSolicitudAp::where("id_estado_solicitud",4)->orderBy("n_colegiado", "asc")->get();

        $cuenta = PlataformaSolicitudAp::where("id_estado_solicitud",4)->pluck('n_colegiado');
        
        $cuenta1 = SQLSRV_Colegiado::select('cc00.c_cliente','cc00.n_cliente', 'cc00.registro', 'cc00prof.n_profesion', 'cc00.telefono', 'cc00.fecha_nac', 'cc00.f_ult_pago', 'cc00.f_ult_timbre')
                ->join('cc00prof','cc00.c_cliente','=','cc00prof.c_cliente')
                ->whereIn('cc00.c_cliente', $cuenta)
                ->orderBy('cc00.c_cliente', 'asc')
                ->get();  

        return \PDF::loadView('admin.firmaresolucion.solicitudes_pendientes', compact("cuenta1", "ap", "mytime", "base64"))
        ->setPaper('legal', 'landscape')
        ->stream('archivo.pdf');
    }
    
    public function getJson(Request $params)
    {  
        if(auth()->user()->hasRole('Administrador|Super-Administrador|Timbre|JefeTimbres')){
        $query = "SELECT U.id, U.no_solicitud, U.n_colegiado, AP.Nombre1, S.estado_solicitud_ap, B.nombre_banco, TC.tipo_cuenta, U.no_cuenta, U.fecha_pago_ap
        FROM sigecig_solicitudes_ap U
        INNER JOIN sigecig_estado_solicitud_ap S ON U.id_estado_solicitud=S.id 
        INNER JOIN adm_usuario AU ON AU.Usuario=U.n_colegiado
        INNER JOIN adm_persona AP ON AU.idPersona = AP.idPersona
        INNER JOIN sigecig_bancos B ON B.id=U.id_banco
        INNER JOIN sigecig_tipo_cuentas TC ON TC.id=U.id_tipo_cuenta
        WHERE U.id_estado_solicitud >=2";
        }

        else{    
        $query = "SELECT U.id, U.no_solicitud, U.n_colegiado, AP.Nombre1, S.estado_solicitud_ap, B.nombre_banco, TC.tipo_cuenta, U.no_cuenta, U.fecha_pago_ap
        FROM sigecig_solicitudes_ap U
        INNER JOIN sigecig_estado_solicitud_ap S ON U.id_estado_solicitud=S.id 
        INNER JOIN adm_usuario AU ON AU.Usuario=U.n_colegiado
        INNER JOIN adm_persona AP ON AU.idPersona = AP.idPersona
        INNER JOIN sigecig_bancos B ON B.id=U.id_banco
        INNER JOIN sigecig_tipo_cuentas TC ON TC.id=U.id_tipo_cuenta
        WHERE U.id_estado_solicitud >=8";
        }
        
        $result = DB::select($query);
        $api_Result['data'] = $result;
        
        return Response::json( $api_Result );
    }

    public function aprDocumentosAp(Request $request, PlataformaSolicitudAp $solicitud){   
        $fecha = date("Y/m/d h:m:s");
        $estado_solicitud = PlataformaSolicitudAp::Where("no_solicitud", $request->solicitud)->get()->first();
        $estado_solicitud->id_estado_solicitud='4';
        $estado_solicitud->update();

        //envio de Corroe Aprobacion Documentacion
        $fecha_actual=date_format(Now(),'d-m-Y');
        $solicitudAP = PlataformaSolicitudAp::Where("n_colegiado", $estado_solicitud->n_colegiado)->orderBy('id','DESC')->first();
        $colegiado = SQLSRV_Colegiado::where("c_cliente",$solicitudAP->n_colegiado)->get()->first();
        $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP, $colegiado);    
        $infoCorreoAp->subject('Aprobacion de Documentos Auxilio Póstumo');     
        Mail::to($colegiado->e_mail)->send($infoCorreoAp);

        //event(new ActualizacionBitacoraAp(Auth::user()->id, $solicitud->id, $fecha, $solicitud->id_estado_solicitud));

        return response()->json(['mensaje' => 'Resgistrado Correctamente']);
    }

    public function rczDocumentosAp(Request $request){
         $fecha = date("Y/m/d h:m:s");
         $estado_solicitud = PlataformaSolicitudAp::Where("no_solicitud", $request->solicitud)->get()->first();
         $estado_solicitud->solicitud_rechazo_ap = $request->texto;
         $estado_solicitud->id_estado_solicitud='3';
         $estado_solicitud->update();  
         
        //envio de Corroe Aprobacion Documentacion
        $fecha_actual=date_format(Now(),'d-m-Y');
        $solicitudAP = PlataformaSolicitudAp::Where("n_colegiado", $estado_solicitud->n_colegiado)->orderBy('id','DESC')->first();
        $colegiado = SQLSRV_Colegiado::where("c_cliente",$solicitudAP->n_colegiado)->get()->first();
        $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP, $colegiado);    
        $infoCorreoAp->subject('Rechazo de Documentos Auxilio Póstumo');     
        Mail::to($colegiado->e_mail)->send($infoCorreoAp);

         event(new ActualizacionBitacoraAp(Auth::user()->id, $estado_solicitud->id, $fecha, $estado_solicitud->id_estado_solicitud));
         return response()->json(['mensaje' => 'Resgistrado Correctamente']);
       
    }

    public function aprDocumentosJunta(Request $request){
        $fecha = date("Y/m/d h:m:s");
        $estado_solicitud = PlataformaSolicitudAp::Where("id", $request->id_solicitud)->get()->first();
        $estado_solicitud->id_estado_solicitud='5';
        $estado_solicitud->update();    
        event(new ActualizacionBitacoraAp(Auth::user()->id, $estado_solicitud->id, $fecha, $estado_solicitud->id_estado_solicitud));

        //envio de Corroe Aprobacion Solicitud por Junta Directiva
        $fecha_actual=date_format(Now(),'d-m-Y');
        $solicitudAP = PlataformaSolicitudAp::Where("n_colegiado", $estado_solicitud->n_colegiado)->orderBy('id','DESC')->first();
        $colegiado = SQLSRV_Colegiado::where("c_cliente",$solicitudAP->n_colegiado)->get()->first();
        $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP, $colegiado);    
        $infoCorreoAp->subject('Aprobacion de Solicitud por Junta Directiva');     
        Mail::to($colegiado->e_mail)->send($infoCorreoAp);

        return response()->json(['mensaje' => 'Resgistrado Correctamente']);
    }

    public function rczDocumentosJunta(Request $request){
        $fecha = date("Y/m/d h:m:s");

        $estado_solicitud = PlataformaSolicitudAp::Where("id", $request->id_solicitud)->get()->first();
        $estado_solicitud->solicitud_rechazo_junta = $request->texto;
        $estado_solicitud->id_estado_solicitud='10';
        $estado_solicitud->update();    

        event(new ActualizacionBitacoraAp(Auth::user()->id, $estado_solicitud->id, $fecha, $estado_solicitud->id_estado_solicitud));

        $fecha_actual=date_format(Now(),'d-m-Y');
        $solicitudAP = PlataformaSolicitudAp::Where("n_colegiado", $estado_solicitud->n_colegiado)->orderBy('id','DESC')->first();
        $colegiado = SQLSRV_Colegiado::where("c_cliente",$solicitudAP->n_colegiado)->get()->first();
        $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP, $colegiado);    
        $infoCorreoAp->subject('Rechazo de Solicitud por Junta Directiva');     
        Mail::to($colegiado->e_mail)->send($infoCorreoAp);

        return response()->json(['mensaje' => 'Resgistrado Correctamente']);

    }

    public function verSolicitudAp($solicitud){
        $estado_solicitud = PlataformaSolicitudAp::Where("no_solicitud", $solicitud)->get()->first();   
        $path = $estado_solicitud->pdf_solicitud_ap;
        $file = File::get($path);
        $type = File::mimeType($path);         
        $response = Response::make($file, 200);     
        $response->header("Content-Type", $type);
        return $response;
    }
    public function verDpiAp($solicitud){
        $estado_solicitud = PlataformaSolicitudAp::Where("no_solicitud", $solicitud)->get()->first();   
        $path = $estado_solicitud->pdf_dpi_ap;
        $file = File::get($path);
        $type = File::mimeType($path);         
        $response = Response::make($file, 200);     
        $response->header("Content-Type", $type);
        return $response;
    }

    public function correo(){
         $colegiado = '11282';
        // $fecha_actual=date_format(Now(),'d-m-Y');
        // $solicitudAP = PlataformaSolicitudAp::Where("n_colegiado", $colegiado)->orderBy('id','DESC')->first();
        // $infoCorreoAp = new \App\Mail\AprobacionDocAp($colegiado,$fecha_actual, $solicitudAP);    
        // $infoCorreoAp->subject('Aprobacion de Documentos Auxilio Póstumo');     
        // Mail::to('daeliasc@gmail.com')->send($infoCorreoAp);

        $fecha_actual=date_format(Now(),'d-m-Y');
        $solicitudAP = PlataformaSolicitudAp::Where("n_colegiado", $colegiado)->orderBy('id','DESC')->first();
        $colegiado = SQLSRV_Colegiado::where("c_cliente",$solicitudAP->n_colegiado)->get()->first();
        return view ('mails.prueba',compact('fecha_actual','solicitudAP','colegiado'));
        $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP); 
        dd($correo);
        $infoCorreoAp->subject('Rechazo de Documentos Auxilio Póstumo');     
        Mail::to('daeliasc@gmail.com')->send($infoCorreoAp);

    }


}

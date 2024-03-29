<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Image, File, Mail;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Barryvdh\DomPDF\ServiceProvider;
use App\PlataformaSolicitudAp;
use App\AdmPersona;
use App\Recibo_Maestro;
use App\PlataformaBanco;
use App\PlataformaTipoCuenta;
use App\AdmUsuario;
use App\BitacoraAp;
use Carbon\Carbon;
use App\SQLSRV_Colegiado;
use App\SQLSRV_Empresa;
use App\Recibo_Detalle;
use App\TipoDePago;
use App\SQLSRV_Profesion;
use App\Events\ActualizacionBitacoraAp;
use Illuminate\Support\Facades\Storage;
use App\Mail\AprobacionDocAp;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use NumeroALetras;



class ResolucionPagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function imprimir(PlataformaSolicitudAp $id)
    {
        $date = Carbon::now()->toDateTimeString('%A %d %B %Y');
        $adm_usuario = AdmUsuario::where('Usuario', '=', $id->n_colegiado)->get()->first();
        $adm_persona = AdmPersona::where('idPersona', '=', $adm_usuario->idPersona)->get()->first();
        $profesion = SQLSRV_Profesion::where("c_cliente", $id->n_colegiado)->get()->first();


        $pdf = \PDF::loadView('admin.firmaresolucion.pdf', compact('id', 'adm_usuario', 'adm_persona', 'date', 'profesion'));
        return $pdf->stream('ArchivoPDF.pdf');
    }

    public function reporte_ap(PlataformaSolicitudAp $id)
    {

        $path = 'images/timbre.png';
        $data = file_get_contents($path);
        $base64 = 'data:image/' . "png" . ';base64,' . base64_encode($data);
        $mytime = Carbon::now();
        $adm_usuario = AdmUsuario::where('Usuario', '=', $id->n_colegiado)->get()->first();

        $query = "SELECT U.id, U.no_solicitud, U.n_colegiado, AP.Nombre1, S.estado_solicitud_ap, U.no_cuenta, U.fecha_pago_ap
            FROM sigecig_solicitudes_ap U
            INNER JOIN sigecig_estado_solicitud_ap S ON U.id_estado_solicitud=S.id
            INNER JOIN adm_usuario AU ON AU.Usuario=U.n_colegiado
            INNER JOIN adm_persona AP ON AU.idPersona = AP.idPersona
            INNER JOIN sigecig_tipo_cuentas TC ON TC.id=U.id_tipo_cuenta
            WHERE U.id_estado_solicitud =10
            ORDER BY n_colegiado ASC;";

        $datos = DB::select($query);

        $pdf = \PDF::loadView('admin.firmaresolucion.reporteap', compact('base64', 'mytime', 'id', 'datos'));
        return $pdf->setPaper('legal', 'landscape')->stream('ReportePDF.pdf');
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
        try {
        //envio de correo Finalizar estado
        $fecha_actual = date_format(Now(), 'd-m-Y');
        $solicitudAP = PlataformaSolicitudAp::Where("id", $tipo->id)->get()->first();
        $colegiado = SQLSRV_Colegiado::where("c_cliente", $solicitudAP->n_colegiado)->get()->first();
        $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP, $colegiado);
        $infoCorreoAp->subject('Solicitud de Auxilio Póstumo ' . $solicitudAP->no_solicitud);
        $infoCorreoAp->from('visa@cig.org.gt', 'Colegio de Ingenieros de Guatemala Portal Electrónico');
        Mail::to($colegiado->e_mail)->send($infoCorreoAp);

        event(new ActualizacionBitacoraAp(Auth::user()->id, $tipo->id, Now(), $tipo->id_estado_solicitud));
        return Response::json(['success' => 'Éxito']);

        } catch (\Throwable $th) {
            event(new ActualizacionBitacoraAp(Auth::user()->id, $tipo->id, Now(), $tipo->id_estado_solicitud));
            return Response::json(['success' => 'Éxito']);
        }

    }

    public function index()
    {
        $user = Auth::User();
        if ($user->roles[0]->name=='Administrador' || $user->roles[0]->name=='Super-Administrador' || $user->roles[0]->name=='Timbre' || $user->roles[0]->name=='JefeTimbres' || $user->roles[0]->name=='Contabilidad' || $user->roles[0]->name=='JefeContabilidad') {
        return view('admin.firmaresolucion.index', compact('user'));
        }else{
            return redirect()->route('dashboard');        }
    }

    public function bitacora(PlataformaSolicitudAp $id)
    {
        $adm_usuario = AdmUsuario::where('Usuario', '=', $id->n_colegiado)->get()->first();
        $adm_persona = AdmPersona::where('idPersona', '=', $adm_usuario->idPersona)->get()->first();
        $profesion = SQLSRV_Profesion::where("c_cliente", $id->n_colegiado)->get()->first();
        $fecha_Nac = SQLSRV_Colegiado::where("c_cliente", $id->n_colegiado)->get()->first();
        $tel = SQLSRV_Colegiado::where("c_cliente", $id->n_colegiado)->get()->first();
        $reg = SQLSRV_Colegiado::where("c_cliente", $id->n_colegiado)->get()->first();
        $tipocuenta = PlataformaTipoCuenta::where("id", $id->id_tipo_cuenta)->get()->first();
        $banco = PlataformaBanco::where("id", $id->id_banco)->get()->first();
        $usuario_cambio = BitacoraAp::where("no_solicitud", '=', $id->id)->orderBy('estado_solicitud', 'asc')->get();
        //  $rechazoap = AdmUsuario::where('Usuario', '=', $id->n_colegiado)->get()->first();
        $path = $id->pdf_dpi_ap;
        $extDpi = pathinfo($path, PATHINFO_EXTENSION);// PATHINFO_EXTENSION es una constantedd
        $path = $id->pdf_solicitud_ap;
        $extSolicitud = pathinfo($path, PATHINFO_EXTENSION);// PATHINFO_EXTENSION es una constantedd
       



        $user = Auth::User();
        if ($user->roles[0]->name=='Administrador' || $user->roles[0]->name=='Super-Administrador' || $user->roles[0]->name=='Timbre' || $user->roles[0]->name=='JefeTimbres' || $user->roles[0]->name=='Contabilidad' || $user->roles[0]->name=='JefeContabilidad') {
            return view('admin.bitacora.index', compact('extDpi','extSolicitud','id', 'user', 'adm_usuario', 'adm_persona', 'profesion', 'fecha_Nac', 'tel', 'reg', 'banco', 'tipocuenta', 'usuario_cambio'));
        }else{
                return redirect()->route('dashboard');        }
    }

    function imprimirbitacora(PlataformaSolicitudAp $id)
    {
        $adm_usuario = AdmUsuario::where('Usuario', '=', $id->n_colegiado)->get()->first();
        $adm_persona = AdmPersona::where('idPersona', '=', $adm_usuario->idPersona)->get()->first();
        $fecha_Nac = SQLSRV_Colegiado::where("c_cliente", $id->n_colegiado)->get()->first();
        $profesion = SQLSRV_Profesion::where("c_cliente", $id->n_colegiado)->get()->first();
        $tel = SQLSRV_Colegiado::where("c_cliente", $id->n_colegiado)->get()->first();
        $reg = SQLSRV_Colegiado::where("c_cliente", $id->n_colegiado)->get()->first();
        $tipocuenta = PlataformaTipoCuenta::where("id", $id->id_tipo_cuenta)->get()->first();
        $banco = PlataformaBanco::where("id", $id->id_banco)->get()->first();
        $usuario_cambio = BitacoraAp::where("no_solicitud", '=', $id->id)->orderBy('estado_solicitud', 'asc')->get();

        $user = Auth::User();

        $pdf = \PDF::loadView('admin.bitacora.pdfbitacora', compact('id', 'user', 'adm_usuario',  'adm_persona', 'profesion', 'fecha_Nac', 'tel', 'reg', 'banco', 'tipocuenta', 'usuario_cambio'));
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
        $banco = PlataformaBanco::where("id", $solicitud->id_banco)->get()->first();
        $tipocuenta = PlataformaTipoCuenta::where("id", $solicitud->id_tipo_cuenta)->get()->first();
        $colegiado = SQLSRV_Colegiado::where("c_cliente", $solicitud->n_colegiado)->get()->first();
        $profesion = SQLSRV_Profesion::where("c_cliente", $solicitud->n_colegiado)->get()->first();
        $path = $solicitud->pdf_dpi_ap;
        $extDpi = pathinfo($path, PATHINFO_EXTENSION);// PATHINFO_EXTENSION es una constantedd
        $path = $solicitud->pdf_solicitud_ap;
        $extSolicitud = pathinfo($path, PATHINFO_EXTENSION);// PATHINFO_EXTENSION es una constantedd
        return view('admin.firmaresolucion.asap', compact('solicitud', 'banco', 'tipocuenta', 'colegiado', 'profesion','extDpi','extSolicitud'));
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
        // Estado 7 a estado 8
        $fecha = date("Y/m/d h:m:s");
        $nuevos_datos = array(
            'id_estado_solicitud' => 8
        );

        $json = json_encode($nuevos_datos);
        $solicitud->update($nuevos_datos);

        try {
            $fecha_actual = date_format(Now(), 'd-m-Y');
            $solicitudAP = PlataformaSolicitudAp::Where("id", $solicitud->id)->get()->first();
            $colegiado = SQLSRV_Colegiado::where("c_cliente", $solicitudAP->n_colegiado)->get()->first();
            $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP, $colegiado);
            $infoCorreoAp->subject('Solicitud de Auxilio Póstumo ' . $solicitudAP->no_solicitud);
            $infoCorreoAp->from('visa@cig.org.gt', 'Colegio de Ingenieros de Guatemala Portal Electrónico');
            Mail::to($colegiado->e_mail)->send($infoCorreoAp);
            $this->envioCorreoJuntaAp($colegiado,$fecha_actual, $solicitudAP);


            event(new ActualizacionBitacoraAp(Auth::user()->id, $solicitud->id, Now(), $solicitud->id_estado_solicitud));
            return Response::json(['success' => 'Éxito']);
        } catch (\Throwable $th) {
            event(new ActualizacionBitacoraAp(Auth::user()->id, $solicitud->id, Now(), $solicitud->id_estado_solicitud));
            return Response::json(['success' => 'Éxito-no se envío correo',]);
        }

    }

    public function finalizarestado(PlataformaSolicitudAp $solicitud, Request $request)


    {

        //Estado 9 a 10
        $nuevos_datos = array(
            'id_estado_solicitud' => 10,
        );
        $solicitud->update($nuevos_datos);
        $auxpost = SQLSRV_Colegiado::where("c_cliente", $solicitud->n_colegiado)->get()->first();
        $auxpost->auxpost = 1;
        $auxpost->update();

        try {
                //envio de correo Finalizar estado
            $fecha_actual = date_format(Now(), 'd-m-Y');
            $solicitudAP = PlataformaSolicitudAp::Where("id", $solicitud->id)->get()->first();
            $colegiado = SQLSRV_Colegiado::where("c_cliente", $solicitudAP->n_colegiado)->get()->first();
            $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP, $colegiado);
            $infoCorreoAp->subject('Solicitud de Auxilio Póstumo ' . $solicitudAP->no_solicitud);
            $infoCorreoAp->from('visa@cig.org.gt', 'Colegio de Ingenieros de Guatemala Portal Electrónico');
            Mail::to($colegiado->e_mail)->send($infoCorreoAp);

            event(new ActualizacionBitacoraAp(Auth::user()->id, $solicitud->id, Now(), $solicitud->id_estado_solicitud));

            return Response::json(['success' => 'Éxito']);
        } catch (\Throwable $th) {
            event(new ActualizacionBitacoraAp(Auth::user()->id, $solicitud->id,Now(), $solicitud->id_estado_solicitud));

            return Response::json(['success' => 'Éxito-No se envio correo']);
        }

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
        //Estado 5 a 7
        $fecha = date("Y/m/d h:m:s");

        $nuevos_datos = array(
            'no_acta' => $request->no_acta,
            'no_punto_acta' => $request->no_punto_acta,
            'id_estado_solicitud' => 7,
            'fecha_ingreso_acta' => Now(),
        );
        $json = json_encode($nuevos_datos);
        $solicitud->update($nuevos_datos);

            event(new ActualizacionBitacoraAp(Auth::user()->id, $solicitud->id,Now(), $solicitud->id_estado_solicitud));
            //return redirect()->route('tipoDePago.index', $tipo)->with('flash','Tipo de pago ha sido actualizado!');
            return Response::json(['success' => 'Éxito']);


    }

    public function sendMail(request $request)
    {
        $data = $request->all();

        Mail::send('mails.cambioestado', ['data' => $data],  function ($m) use ($data) {
            $m->from('visa@cig.org.gt', 'Colegio de Ingenieros de Guatemala portal electrónico');
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
        $user = Auth::User();

        if ($user->roles[0]->name=='Administrador' || $user->roles[0]->name=='Super-Administrador' || $user->roles[0]->name=='Timbre' || $user->roles[0]->name=='JefeTimbres') {
            $path = 'images/timbres.png';
            $data = file_get_contents($path);
            $base64 = 'data:image/' . "png" . ';base64,' . base64_encode($data);
    
            $mytime = Carbon::now();
            $ap = PlataformaSolicitudAp::where("id_estado_solicitud", 4)->orderBy("n_colegiado", "asc")->get();
            $cuenta = PlataformaSolicitudAp::where("id_estado_solicitud", 4)->orderBy("n_colegiado", "asc")->pluck('n_colegiado')->toArray();
            $cuenta1 = SQLSRV_Colegiado::select('cc00.c_cliente', 'cc00.n_cliente', 'cc00.registro', 'cc00prof.n_profesion', 'cc00.telefono', 'cc00.fecha_nac', 'cc00.f_ult_pago', 'cc00.f_ult_timbre')
                ->join('cc00prof', 'cc00.c_cliente', '=', 'cc00prof.c_cliente')
                ->whereIn('cc00.c_cliente', $cuenta)->orderBy('c_cliente','asc')
                ->get();
           
            $List = implode(', ', $cuenta); 
            if(!empty($List)){
                $query = "SELECT CONVERT(INT, U.c_cliente) as cliente, U.n_cliente, U.registro, S.n_profesion, U.telefono, U.fecha_nac, U.f_ult_pago, U.f_ult_timbre
                FROM cc00 U
                INNER JOIN cc00prof S ON U.c_cliente=S.c_cliente 
                WHERE  U.c_cliente IN ($List)
                ORDER BY cliente asc;";
        
                $result = DB::connection('sqlsrv')->select($query);
            }else{
                $result = 0;
            }
    
            return \PDF::loadView('admin.firmaresolucion.solicitudes_pendientes', compact("cuenta1", "ap", "mytime", "base64","result"))
                ->setPaper('legal', 'landscape')
                ->stream('archivo.pdf');
        }else{
            return redirect()->route('resolucion.index');
        }

    }

    public function getJson(Request $params)
    {
        if (auth()->user()->hasRole('Administrador|Super-Administrador|Timbre|JefeTimbres')) {
            $query = "SELECT U.id, U.no_solicitud, U.n_colegiado, AP.Nombre1, S.estado_solicitud_ap, B.nombre_banco, TC.tipo_cuenta, U.no_cuenta, U.fecha_pago_ap
        FROM sigecig_solicitudes_ap U
        INNER JOIN sigecig_estado_solicitud_ap S ON U.id_estado_solicitud=S.id
        INNER JOIN adm_usuario AU ON AU.Usuario=U.n_colegiado
        INNER JOIN adm_persona AP ON AU.idPersona = AP.idPersona
        INNER JOIN sigecig_bancos B ON B.id=U.id_banco
        INNER JOIN sigecig_tipo_cuentas TC ON TC.id=U.id_tipo_cuenta
        WHERE U.id_estado_solicitud >=1
        ORDER BY U.id DESC";
        } else {
            $query = "SELECT U.id, U.no_solicitud, U.n_colegiado, AP.Nombre1, S.estado_solicitud_ap, B.nombre_banco, TC.tipo_cuenta, U.no_cuenta, U.fecha_pago_ap
        FROM sigecig_solicitudes_ap U
        INNER JOIN sigecig_estado_solicitud_ap S ON U.id_estado_solicitud=S.id
        INNER JOIN adm_usuario AU ON AU.Usuario=U.n_colegiado
        INNER JOIN adm_persona AP ON AU.idPersona = AP.idPersona
        INNER JOIN sigecig_bancos B ON B.id=U.id_banco
        INNER JOIN sigecig_tipo_cuentas TC ON TC.id=U.id_tipo_cuenta
        WHERE U.id_estado_solicitud >=8
        ORDER BY U.id DESC";
        }

        $result = DB::select($query);

        $api_Result['data'] = $result;
        return Response::json($api_Result);
    }

    public function aprDocumentosAp(Request $request)
    {
        $fecha = date("Y/m/d h:m:s");
        $estado_solicitud = PlataformaSolicitudAp::Where("id", $request->solicitud)->get()->first();
        $estado_solicitud->id_estado_solicitud = '4';
        $estado_solicitud->update();

        try {
                       //envio de Corroe Aprobacion Documentacion
                       $fecha_actual = date_format(Now(), 'd-m-Y');
                       $solicitudAP = PlataformaSolicitudAp::Where("id", $request->solicitud)->get()->first();
                       $colegiado = SQLSRV_Colegiado::where("c_cliente", $solicitudAP->n_colegiado)->get()->first();
                       $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP, $colegiado);
                       $infoCorreoAp->subject('Solicitud de Auxilio Póstumo'.$solicitudAP->no_solicitud);
                       $infoCorreoAp->from('visa@cig.org.gt', 'Colegio de Ingenieros de Guatemala Portal Electrónico');
                       Mail::to($colegiado->e_mail)->send($infoCorreoAp);

                       event(new ActualizacionBitacoraAp(Auth::user()->id, $estado_solicitud->id, Now(), $estado_solicitud->id_estado_solicitud));
                       return response()->json(['mensaje' => 'Resgistrado Correctamente']);
        } catch (\Throwable $th) {
            event(new ActualizacionBitacoraAp(Auth::user()->id, $estado_solicitud->id, Now(), $estado_solicitud->id_estado_solicitud));
            return response()->json(['mensaje' => 'Resgistrado Correctamente']);
        }




    }

    public function rczDocumentosAp(Request $request)
    {

        $fecha = date("Y/m/d h:m:s");
        $estado_solicitud = PlataformaSolicitudAp::Where("id", $request->solicitud)->get()->first();
        $estado_solicitud->solicitud_rechazo_ap = $request->texto;
        $estado_solicitud->id_estado_solicitud = '3';
        $estado_solicitud->update();

        try {
                //envio de Corroe Aprobacion Documentacion
            $fecha_actual = date_format(Now(), 'd-m-Y');
            $solicitudAP = PlataformaSolicitudAp::Where("id", $request->solicitud)->get()->first();
            $colegiado = SQLSRV_Colegiado::where("c_cliente", $solicitudAP->n_colegiado)->get()->first();
            $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP, $colegiado);
            $infoCorreoAp->subject('Solicitud de Auxilio Póstumo ' . $solicitudAP->no_solicitud);
            $infoCorreoAp->from('visa@cig.org.gt', 'Colegio de Ingenieros de Guatemala Portal Electrónico');
            Mail::to($colegiado->e_mail)->send($infoCorreoAp);

             event(new ActualizacionBitacoraAp(Auth::user()->id, $estado_solicitud->id,Now(), $estado_solicitud->id_estado_solicitud));
             return response()->json(['mensaje' => 'Registrado Correctamente']);
        } catch (\Throwable $th) {
            event(new ActualizacionBitacoraAp(Auth::user()->id, $estado_solicitud->id, Now(), $estado_solicitud->id_estado_solicitud));
            return response()->json(['mensaje' => 'Registrado Correctamente']);
        }

    }

    public function aprDocumentosJunta(Request $request)
    {
        $fecha = date("Y/m/d h:m:s");
        $estado_solicitud = PlataformaSolicitudAp::Where("id", $request->id_solicitud)->get()->first();
        $estado_solicitud->id_estado_solicitud = '5';
        $estado_solicitud->update();


            try {
            //envio de Corroe Aprobacion Solicitud por Junta Directiva
            $fecha_actual = date_format(Now(), 'd-m-Y');
            $solicitudAP = PlataformaSolicitudAp::Where("id",  $request->id_solicitud)->get()->first();
            $colegiado = SQLSRV_Colegiado::where("c_cliente", $solicitudAP->n_colegiado)->get()->first();
            $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP, $colegiado);
            $infoCorreoAp->subject('Solicitud de Auxilio Póstumo ' . $solicitudAP->no_solicitud);
            $infoCorreoAp->from('visa@cig.org.gt', 'Colegio de Ingenieros de Guatemala Portal Electrónico');
            Mail::to($colegiado->e_mail)->send($infoCorreoAp);

                event(new ActualizacionBitacoraAp(Auth::user()->id, $estado_solicitud->id, Now(), $estado_solicitud->id_estado_solicitud));
                return response()->json(['mensaje' => 'Resgistrado Correctamente']);
            } catch (\Throwable $th) {
                event(new ActualizacionBitacoraAp(Auth::user()->id, $estado_solicitud->id,Now(), $estado_solicitud->id_estado_solicitud));
                return response()->json(['mensaje' => 'Resgistrado Correctamente']);
            }

    }

    public function rczDocumentosJunta(Request $request)
    {
        $fecha = date("Y/m/d h:m:s");

        $estado_solicitud = PlataformaSolicitudAp::Where("id", $request->id_solicitud)->get()->first();
        $estado_solicitud->solicitud_rechazo_junta = $request->texto;
        $estado_solicitud->id_estado_solicitud = '6';
        $estado_solicitud->update();

        try {
            $fecha_actual = date_format(Now(), 'd-m-Y');
            $solicitudAP = PlataformaSolicitudAp::Where("id", $request->id_solicitud)->get()->first();
            $colegiado = SQLSRV_Colegiado::where("c_cliente", $solicitudAP->n_colegiado)->get()->first();
            $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP, $colegiado);
            $infoCorreoAp->subject('Solicitud de Auxilio Póstumo ' . $solicitudAP->no_solicitud);
            $infoCorreoAp->from('visa@cig.org.gt', 'Colegio de Ingenieros de Guatemala Portal Electrónico');
            Mail::to($colegiado->e_mail)->send($infoCorreoAp);

            event(new ActualizacionBitacoraAp(Auth::user()->id, $estado_solicitud->id, Now(), $estado_solicitud->id_estado_solicitud));
            return response()->json(['mensaje' => 'Resgistrado Correctamente']);
        } catch (\Throwable $th) {
            event(new ActualizacionBitacoraAp(Auth::user()->id, $estado_solicitud->id, Now(), $estado_solicitud->id_estado_solicitud));
            return response()->json(['mensaje' => 'Resgistrado Correctamente']);
        }

    }

    public function verSolicitudAp(PlataformaSolicitudAp $solicitud)
    {
        $doc = $solicitud->pdf_solicitud_ap;
        return view ('admin.auxilioPostumo.iframimg',compact('doc'));
    //     dd($solicitud);
    //     $estado_solicitud = PlataformaSolicitudAp::Where("id", $solicitud)->get()->first();
    //     $path = $estado_solicitud->pdf_solicitud_ap;
    //     $file = File::get($path);
    //     $type = File::mimeType($path);
    //     $response = Response::make($file, 200);
    //     $response->header("Content-Type", $type);

    //    $data = file_get_contents($path);
    //    $base64 = 'data:doc/' . "pdf" . ';base64,' . base64_encode($data);
    //    return $base64;

    //     return $base64;

    }
    public function verDpiAp(PlataformaSolicitudAp $solicitud)
    {
        $doc = $solicitud->pdf_dpi_ap;
        return view ('admin.auxilioPostumo.iframimg',compact('doc'));
        // dd($solicitud);
        // $estado_solicitud = PlataformaSolicitudAp::Where("id", $solicitud)->get()->first();
        // $path = $estado_solicitud->pdf_dpi_ap;
        // $file = File::get($path);
        // $type = File::mimeType($path);
        // $response = Response::make($file, 200);
        // $response->header("Content-Type", $type);
        // return $response;
    }
    public function envioCorreoJuntaAp($colegiado,$fecha_actual, $solicitudAP){
        //envio de correo para confirmar recepcion de Documentos
        $infoCorreoAp = new \App\Mail\CorreoJunta($colegiado,$fecha_actual, $solicitudAP);    
        $infoCorreoAp->subject('Solicitud de Auxilio Póstumo');
        $infoCorreoAp->from('visa@cig.org.gt', 'Colegio de Ingenieros de Guatemala Portal Electrónico');
        Mail::to('auxcontad@cig.org.gt')->send($infoCorreoAp);

    }
    public function imprimirResolucion($id){
        $id = PlataformaSolicitudAp::Where("id", $id)->get()->first();
        $profesion= SQLSRV_Profesion::Where("c_cliente", $id->n_colegiado)->get()->first();
        $adm_usuario = AdmUsuario::Where("Usuario", $id->n_colegiado)->get()->first();
        $adm_persona = AdmPersona::Where("idPersona", $adm_usuario->idPersona)->get()->first();
        $fechaActa = Carbon::parse($id->fecha_ingreso_acta);
        $mes=$fechaActa->format('m');
        $año=$fechaActa->format('Y');
        $dia=$fechaActa->format('d');
        $mes = \App\SigecigMeses::where('id',$mes)->first();
       


        // return view('admin.firmaresolucion.pdf',compact('id','profesion','adm_usuario','adm_persona'));
        $pdf = \ PDF::loadView('admin.firmaresolucion.pdf',compact('id','profesion','adm_usuario','adm_persona','año','mes','dia'));
        return $pdf->stream('Resolución.pdf');
    }
}

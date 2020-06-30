<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SQLSRV_Colegiado;
use App\SQLSRV_Profesion;
use App\PlataformaBanco;
use App\PlataformaTipoCuenta;
use Carbon\Carbon;
use App\PlataformaSolicitudAp;
use Illuminate\Support\Facades\Response;
use DB;
use Image, File, Mail;
use App\Mail\AprobacionDocAp;
use App\AdmUsuario;
use App\AdmColegiado;
use App\AdmPersona;
use App\Events\ActualizacionBitacoraAp;
use Illuminate\Support\Facades\Auth;

class AuxilioPostumoController extends Controller
{
    //crear una nueva solicitud de auxilio postumo
    public function nuevaSolicitud()
    {
        $query = "SELECT c_cliente, n_cliente, estado, DATEDIFF(YEAR,fecha_nac,GetDate()) as edad
        FROM cc00
        WHERE auxpost=0 and DATEDIFF(month, f_ult_pago, GETDATE()) <= 3 and DATEDIFF(month, f_ult_timbre, GETDATE()) <= 3 and fallecido='N' and DATEDIFF(YEAR,fecha_nac,GetDate()) > 75";
        $result = DB::connection('sqlsrv')->select($query);

        $banco = PlataformaBanco::all();
        $tipo_cuenta = PlataformaTipoCuenta::all();
        return view('admin.auxilioPostumo.nueva_solicitud', compact('result', 'banco', 'tipo_cuenta'));
    }

    public function getDatosColegiado($no_colegiado)
    {
        $consulta = SQLSRV_Colegiado::select('cc00.c_cliente', 'cc00.n_cliente', 'cc00.registro', 'cc00prof.n_profesion', 'cc00.telefono', 'cc00.fecha_nac')
            ->join('cc00prof', 'cc00.c_cliente', '=', 'cc00prof.c_cliente')
            ->where('cc00.c_cliente', $no_colegiado)
            ->get();

        $admin_usuario = AdmUsuario::Where("Usuario", $no_colegiado)->get()->first();
        if (empty($admin_usuario)) {
            $usuario = '0';
        } else {
            $usuario = '1';
        }

        return Response::json(array($consulta, $usuario));
    }

    public function GuardarSolicitudAp(Request $request)
    {

        $colegiado = SQLSRV_Colegiado::where("c_cliente", $request->no_colegiado)->get()->first();
        $admin_usuario = AdmUsuario::Where("Usuario", $colegiado->c_cliente)->get()->first();

        if (empty($admin_usuario)) {
            $persona = new AdmPersona;
            $persona->Nombre1 = $colegiado->n_cliente;
            $persona->Email = $colegiado->e_mail;
            $persona->save();

            $usuario = new AdmUsuario;
            $usuario->Usuario = $colegiado->c_cliente;
            $usuario->idIdentidad = 1;
            $usuario->idRol = 4;
            $usuario->TipoInternoExterno = 2;
            $usuario->contrasenna = 'RwB1AGEAdABlAG0AYQBsAGEALgAyADAAMgAwAA==';
            $usuario->idRecordatorio = '0';
            $usuario->palabraclave = 'Respuesta';
            $usuario->idPersona = $persona->id;
            $usuario->primerIngreso = 1;
            $usuario->UltimaSesion = DB::raw('NOW()');
            $usuario->sesion = 0;
            $usuario->remember_token = str_random(32);
            $usuario->estado = 1;
            $usuario->save();

            $adm_colegiado = new AdmColegiado;
            $adm_colegiado->idUsuario = $usuario->id;
            $adm_colegiado->numerocolegiado = $colegiado->c_cliente;
            $adm_colegiado->fechacreacion = DB::raw('NOW()');
            $adm_colegiado->estado = 1;
            $adm_colegiado->save();

        }

        $solicitud = DB::table('sigecig_solicitudes_ap')->max('no_solicitud');
        $cuenta = new PlataformaSolicitudAp;

        $cuenta->fecha_solicitud = Now();
        $cuenta->n_colegiado = $request->no_colegiado;
        $cuenta->id_estado_solicitud = '1';
        $cuenta->id_banco = $request->banco;
        $cuenta->id_tipo_cuenta = $request->tipo_cuenta;
        $cuenta->no_cuenta = $request->no_cuenta;
        $cuenta->id_creacion = 1;


        if ($solicitud == 0) {
            $cuenta->no_solicitud = 15;
        } else {
            $cuenta->no_solicitud = $solicitud + 1;
        }

        $cuenta->save();

        $colegiado->telefono = $request->telefono;
        $colegiado->update();

        event(new ActualizacionBitacoraAp(Auth::user()->id, $cuenta->id, Now(), $cuenta->id_estado_solicitud));

        return response()->json(['mensaje' => 'Resgistrado Correctamente']);
    }

    public function DocumentosAp($id)
    {
        return view('admin.auxilioPostumo.subir_documentos', compact('id'));
    }

    public function imprimirSolicitud($id)
    {
        $solicitud = PlataformaSolicitudAp::Where("id", $id)->orderBy('id', 'DESC')->first();
        $profesion = SQLSRV_Profesion::Where("c_cliente", $solicitud->n_colegiado)->get()->first();
        $colegiado = SQLSRV_Colegiado::Where("c_cliente", $solicitud->n_colegiado)->get()->first();
        $fecha_actual = date_format(Now(), 'd-m-Y');
        $date = date_create($colegiado->fecha_nac);
        $fecha = date_format($date, 'd-m-Y');
        $path = 'images/timbres.png';
        $data = file_get_contents($path);
        $base64 = 'data:image/' . "png" . ';base64,' . base64_encode($data);
        $pdf = \PDF::loadView('admin.auxilioPostumo.print', compact('colegiado', 'profesion', 'fecha', 'fecha_actual', 'base64'));
        return $pdf->stream('SolicitudAp.pdf');
    }

    public function guardarDocumentosAp(Request $request, $id)
    {


        $fecha = date("Y/m/d h:m:s");
        $fecha_actual = date_format(Now(), 'd-m-Y');
        $solicitudAP = PlataformaSolicitudAp::Where("id", $id)->orderBy('id', 'DESC')->first();
        $colegiado = SQLSRV_Colegiado::Where("c_cliente", $solicitudAP->n_colegiado)->orderBy('id', 'DESC')->first();
        $pdf = new PlataformaSolicitudAp;

        $request->validate([
            //file -> pdf de la solicitud
            'solicitud' => 'required',
            'dpi' => 'required'
        ]);

        $pdfSolicituddb = 'C:\Documents\ap\solicitud/Solicitud' . $solicitudAP->no_solicitud . $solicitudAP->n_colegiado . '.' . request()->solicitud->getClientOriginalExtension();
        $pdfSolicitud = 'Solicitud' . $solicitudAP->no_solicitud . $solicitudAP->n_colegiado . '.' . request()->solicitud->getClientOriginalExtension();
        request()->solicitud->move('C:\Documents\ap\solicitud', $pdfSolicitud);

        $pdfDpidb = 'C:\Documents\ap\dpi/Dpi' . $solicitudAP->no_solicitud . $solicitudAP->n_colegiado . '.' . request()->dpi->getClientOriginalExtension();
        $pdfDpi = 'Dpi' . $solicitudAP->no_solicitud . $solicitudAP->n_colegiado . '.' . request()->dpi->getClientOriginalExtension();
        request()->dpi->move('C:\Documents\ap\dpi', $pdfDpi);


        $solicitudAP->pdf_solicitud_ap = $pdfSolicituddb;
        $solicitudAP->pdf_dpi_ap = $pdfDpidb;
        $solicitudAP->id_estado_solicitud = '2';
        $solicitudAP->update();

        //envio de correo para confirmar recepcion de Documentos
        $solicitudAP = PlataformaSolicitudAp::Where("id", $id)->orderBy('id', 'DESC')->first();
        $infoCorreoAp = new \App\Mail\AprobacionDocAp($fecha_actual, $solicitudAP, $colegiado);
        $infoCorreoAp->subject('Solicitud de Auxilio Póstumo ' . $solicitudAP->no_solicitud);
        Mail::to($colegiado->e_mail)->send($infoCorreoAp);

        event(new ActualizacionBitacoraAp(Auth::user()->id, $solicitudAP->id, Now(), $solicitudAP->id_estado_solicitud));
        return response()->json(['success' => 'You have successfully upload file.']);
    }
}

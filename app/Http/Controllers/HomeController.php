<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;
use App\Recibo_Maestro;
use App\nombres;
use App\AdmUsuario;
use App\AdmColegiado;
use App\AdmPersona;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function corte_diario()
    {
        $recibos = Recibo_Maestro::all();
        dd($recibos);

        return $recibos;
    }


    public function index()
    {
        $user = Auth::User();
        $rec = Recibo_Maestro::whereRaw('Date(created_at) = CURDATE()')->get()->first();
        return view('admin.dashboard', compact('rec'));
        
    }   

    public function saveUsuario(){



        $colegiados = DB::connection('sqlsrv')->select(" SELECT c_cliente, n_cliente, e_mail from  cc00 WHERE c_cliente IN (1016,1117,12,1374,17,22,2675,734,761,792,
        138,140,155,160,184,224,225,237,254,270,
        282,286,324,331,332,333,337,375,378,383,393,413,419,422,423,432,433,436,444,451,463,465,467,472,473,509,511,513,529,534,536,538,550,
        564,580,590,593,594,608,610,615,618,620,622,624,636,640,649,650,656,664,670,671,672,674,675,677,680,681,685,687,689,695,699,702,709,
        711,715,717,721,724,731,732,751,753,754,755,766,771,778,785,790,791,794,798,803,806,814,823,825,826,829,847,854,856,864,876,882,893,
        903,908,914,916,919,928,940,951,952,954,957,972,974,976,980,1001,1004,1008,1011,1033,1055,1064,1103,1115,1150,1160,1161,1174,1197,
        1250,1258,1268,1328,1341,1342,1356,1358,1359,1367,1369,1373,1378,1386,1387,1425,1429,1451,1460,1470,1490,1569,1575,1588,1672,1708,
        1743,1798,1853,1883,1922,1992,2009,2106,2151,2211,2759,2775,2777,2928,3363,3522,3772,4144,4331,4642,5216,5870,6066,9459);");

        // $result = DB::connection('sqlsrv')->select(" SELECT c_cliente from  cc00 WHERE c_cliente IN (254,413,423,534,536,695,754,903,1011,1708,393,444,472,794,893,980,1342,1429,160,432,436,473,1387,624,790,957,155,237,383,463,580,615,785,940,375,225,513,751,2151,224,650,610,685,2009,721,184,433,564,825,1161,1369,1378,4642,640,689,680,1451,509,1425,671,755,419,864,1008,976,1992,814,1672,465,2775,550,1064,333,2759,778,608,282,882,1798,928,951,1460,140,3772,511,1922,594,771,670,618,798,1268,9459,1359,332,451,711,331,467,1160,138,1367,876,649,324,4331,270,538,5870,681,3522,826,378,914,1001,806,1328,1150,422,5216,3363,766,2211,919,675,856,1356,674,1250,699,677,2928,529,593,854,590,731,1055,636,1358,823,908,791,1373,2106,1258,732,1004,724,974,1743,1569,1174,620,952,1490,709,286,672,702,6066,664,1575,1883,717,1115,715,4144,1033,1588,1341,2777,847,1103,803,1470,1197,972,753,954,1853,1386,337,916,829,656,622,687,792,2675,734,1016,1374,1117,761);");

      foreach ($colegiados as $key => $colegiado) {
        $admin_usuario = AdmUsuario::Where("Usuario", $colegiado->c_cliente)->get()->first();
        $conteo = 0;
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

       
      } return 'exito';
        

      
    }
}

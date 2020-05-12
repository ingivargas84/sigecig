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

        if($user->hasRole('Gerencia')){
        return view('gerencia.dashboard');
        }
        if($user->hasRole('JuntaDirectiva')){
        return view('juntadirectiva.dashboard');
        }
        if($user->hasRole('Administrador') || $user->hasRole('Super-Administrador')){
        return view('administracion.dashboard');
        }
        if($user->hasRole('JefeContabilidad')|| $user->hasRole('Contabilidad')){
        return view('contabilidad.dashboard');
        }
        if($user->hasRole('JefeInformatica') || $user->hasRole('SoporteInformatica')){
        return view('informatica.dashboard');
        }
        if($user->hasRole('Ceduca')|| $user->hasRole('JefeCeduca')){
        return view('ceduca.dashboard');
        }
        if($user->hasRole('JefeTimbres')|| $user->hasRole('Timbres')){
        return view('timbreingenieria.dashboard');
        }
        if($user->hasRole('JefeComisiones') || $user->hasRole('Comisiones')){
        return view('comisiones.dashboard');
        }
        if($user->hasRole('Auditoria')){
        return view('auditoria.dashboard');
        }
    }   
}

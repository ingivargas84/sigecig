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
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function gerencia()
    {
        return view('gerencia.dashboard');
    }

    public function juntadirectiva()
    {
        return view('juntadirectiva.dashboard');
    }

    public function administracion()
    {
        return view('administracion.dashboard');
    }

    public function contabilidad()
    {
        return view('contabilidad.dashboard');
    }

    public function informatica()
    {
        return view('informatica.dashboard');
    }

    public function ceduca()
    {
        return view('ceduca.dashboard');
    }

    public function nuevoscolegiados()
    {
        return view('nuevoscolegiados.dashboard');
    }

    public function timbreingenieria()
    {
        return view('timbreingenieria.dashboard');
    }

    public function comisiones()
    {
        return view('comisiones.dashboard');
    }

    public function auditoria()
    {
        return view('auditoria.dashboard');
    }

   
}

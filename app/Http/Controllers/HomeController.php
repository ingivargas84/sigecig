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

        return view('admin.dashboard');
        
    }   
}

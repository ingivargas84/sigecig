<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColegiadosController extends Controller
{
    public function index()
    {
        return view ('admin.colegiados.index');
    }

    public function create()
    {
       
        return view ('admin.colegiados.create');
    }

    public function getJson(Request $params)
     {
        $query = "SELECT B.id, B.nombre_bodega, B.descripcion, B.estado
        FROM sigecig_bodega B
        WHERE B.estado != 0";

        $api_Result['data'] = DB::select($query);
        return Response::json( $api_Result );
     }
}

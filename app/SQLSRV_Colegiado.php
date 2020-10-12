<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\IngresoProducto;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Input;



class SQLSRV_Colegiado extends Model
{
  protected $connection = 'sqlsrv';
  
  protected $table = 'CC00';
  
  protected $fillable = [
    'n_cliente',  //nombre del colegiado
    'direccion',
    'telefono',
    'fax',
    'observaciones',
    'n_social',
    'nit',
    'zona',
    'c_credito',
    't_pre',
    'dias_inac',  //dias de inactividad
    'c_cliente',  //no de colegiado
    'c_depto',  //departamento vivienda
    'c_mpo',  //municipio vivienda
    'c_t_cl',
    'c_negocio',
    'c_vendedor',
    'e_mail',
    'registro', // No de cédula - DPI
    'estado',  //I=Inactivo, A=Activo, F=Fallecido
    'contacto1',
    'contacto2',
    'f_creacion',
    'monto_extra',
    'usuario_crea',
    'f_creacion',
    'ft_pre_ref',
    'f_ult_pago',  //fecha de ultimo pago del colegiado en el tema de colegiación
    'paga_auxilio',  //paga auxilio póstumo o no, 1=si, 0=no
    'f_ult_timbre',  //fecha de pago de ultimo timbre
    'fecha_nac',  //fecha de nacimiento del colegiado
    'tipo_sangre',
    'fecha_col',  //fecha de colegiación
    'dir_trabajo',
    'zona_trabajo',
    'fecha_grad',  //fecha de graduación del colegiado
    'sexo',  //M=Masculino, F=Femenino
    'e_civil',  //V=viuda, C=Casado, S=Soltero
    'nacionalidad',  
    'f_fallecido',
    'c_universidad',
    'c_universidad1',
    'titulo_tesis',
    'jubilado',  //segun el reglamento un colegiado se jubila a los 65 años, 01 si es jubilado
    'memo',
    'c_deptocasa',
    'c_mpocasa',
    'c_deptotrab',
    'c_mpotrab',
    'c_deptootro',
    'c_mpootro',
    'apellidos',
    'nombres',
    'fallecido',  //si un colegiado esta fallecido S=Si, N=No
    'nombre_completo',
    'monto_timbre',
    'telmovil',
    'auxpost',
  ];
  protected $updated_at = 'Ymd H: i: s';
  
  public function codigosTimbrePago($cantidad = 1) {
    $montoTemp = $this->monto_timbre * $cantidad;
    $valores = [
      0=> ['timbre_id'=>'8','precio'=>'500'],
      1=> ['timbre_id'=>'7','precio'=>'200'],
      2=> ['timbre_id'=>'6','precio'=>'100'],
      3=> ['timbre_id'=>'5','precio'=>'50'],
      4=> ['timbre_id'=>'4','precio'=>'20'],
      5=> ['timbre_id'=>'3','precio'=>'10'],
      6=> ['timbre_id'=>'2','precio'=>'5'],
      7=> ['timbre_id'=>'1','precio'=>'1'],
    ];
    
    $retorno = array();
    foreach($valores as $valor) {
      
      if($montoTemp >= $valor['precio']) {
        $existenciaTimbre=IngresoProducto::where('tipo_de_pago_id',$valor['timbre_id'])->where('bodega_id',1)->where('cantidad','!=',0)->sum('cantidad');
        if($existenciaTimbre > 0){
          $divisionEntera = intdiv($montoTemp, $valor['precio']);
          if($divisionEntera <= $existenciaTimbre){
            $montoTemp -= $valor['precio'] * $divisionEntera;
            $detalle = new \stdClass();
            $detalle->codigo = 'TC' . str_pad($valor['precio'], 2, '0', STR_PAD_LEFT);
            $detalle->descripcion = 'Timbre por cuota de ' . $valor['precio'] . ' quetzales';
            $detalle->precioUnitario = $valor['precio'];
            $detalle->timbre_id = $valor['timbre_id'];
            $detalle->cantidad = $divisionEntera;
            $retorno[] = $detalle;
          }else{
            $montoTemp -= $valor['precio'] * $existenciaTimbre;
            $detalle = new \stdClass();
            $detalle->codigo = 'TC' . str_pad($valor['precio'], 2, '0', STR_PAD_LEFT);
            $detalle->descripcion = 'Timbre por cuota de ' . $valor['precio'] . ' quetzales';
            $detalle->precioUnitario = $valor['precio'];
            $detalle->timbre_id = $valor['timbre_id'];
            $detalle->cantidad = $existenciaTimbre;
            $retorno[] = $detalle;
          }
        }
        
        
      }
    }
    return $retorno;
  }
  
  ///funciones para reactivacion
  public function getMontoReactivacion()
  {
    
    $fecha_timbre = Carbon::parse($this->f_ult_timbre)->format("t/m/Y");
    $fecha_colegio = Carbon::parse($this->f_ult_pago)->format("Y/m/t");
    $colegiado = $this->c_cliente;
    $fecha_hasta_donde_paga = Carbon::Now()->endOfMonth()->format("Y-m-t");
    $monto_timbre = $this->monto_timbre;
    
    if (!$fecha_timbre || !$fecha_hasta_donde_paga || !$monto_timbre) {
      return json_encode(array("capital" => 0, "mora" => 0, "interes" => 0, "total" => 0));
    }
    $reactivacion = [];
    $detalle = new \stdClass();
    

    $reactivacionColegio = $this->getMontoReactivacionColegio($fecha_colegio, $fecha_hasta_donde_paga, $colegiado);
    $reactivacionTimbre = $this->getMontoReactivacionTimbre($fecha_timbre, $fecha_hasta_donde_paga, $monto_timbre, 0);

    $detalle->capitalTimbre = $reactivacionTimbre['capital'];
    $detalle->moraTimbre = $reactivacionTimbre['mora'];
    $detalle->interesTimbre = $reactivacionTimbre['interes'];
    $detalle->totalTimbre = $reactivacionTimbre['total'];
    $detalle->cuotasTimbre = $reactivacionTimbre['cuotas_timbre'];
    $detalle->cuotasColegio = $reactivacionColegio['cuotas'];
    $detalle->interesColegio = $reactivacionColegio['montoInteres'];
    $detalle->capitalColegio = $reactivacionColegio['capitalColegio'];
    $detalle->totalColegio = $reactivacionColegio['totalColegio'];
    $detalle->total = $reactivacionTimbre['total'] + $reactivacionColegio['totalColegio'];
    $detalle;
    return $detalle;
  }
  
  private function getMontoReactivacionTimbre($fecha_timbre, $fecha_hasta_donde_paga, $monto_timbre, $exonerar_intereses_timbre)
  {
    //dd($fecha_timbre);
    //$mes_origen = date("m", strtotime($fecha_timbre));
    $mes_origen = substr($fecha_timbre, -7, 2);
    //$anio_origen = date("Y", strtotime($fecha_timbre));
    $anio_origen = substr($fecha_timbre, -4);
    //dd($mes_origen);
    $mes_fin = date("m", strtotime($fecha_hasta_donde_paga));
    $anio_fin = date("Y", strtotime($fecha_hasta_donde_paga));
    
    $fecha_fin_meses = $mes_fin + $anio_fin * 12;
    $fecha_origen_meses = $mes_origen + $anio_origen * 12;
    $cuotas_timbre = $fecha_fin_meses - $fecha_origen_meses;
    
    $mes_actual = date("m");
    $anio_actual = date("Y");
    
    $fecha_actual_meses = $mes_actual + $anio_actual * 12;
    
    $monto_extra = 0;
    if ($fecha_fin_meses <= $fecha_actual_meses) {
      $diferencia = $fecha_fin_meses - $fecha_origen_meses;
      if ($diferencia <= 3) {
        $diferencia = 0;
      }
    } else {
      $diferencia = $fecha_actual_meses - $fecha_origen_meses;
      if ($diferencia <= 3) {
        $diferencia = 0;
      }
      $monto_extra = $fecha_fin_meses - $fecha_actual_meses;
    }
    $capital = round($monto_timbre * ($anio_fin * 12 + $mes_fin - ($anio_origen * 12 + $mes_origen)));
    $mora = round($monto_timbre * 0.18 / 12 * $diferencia * ($diferencia - 1) / 2);
    $intereses = round($monto_timbre * 0.128 / 12 * $diferencia * ($diferencia - 1) / 2);
    if ($exonerar_intereses_timbre == 1) {
      $mora = 0;
      $intereses = 0;
    }
    $total = $capital + $mora + $intereses;
    
    return array("capital" => $capital, "mora" => $mora, "interes" => $intereses, "total" => $total, 'cuotas_timbre' => $cuotas_timbre);
  }
  
  public function getMontoReactivacionColegio($fecha_colegio, $fecha_hasta_donde_paga = null, $colegiado)
  {
    $fechaHasta = $fecha_hasta_donde_paga ? $fecha_hasta_donde_paga : date('Y-m-d');
    $fechaHastaT = strtotime($fechaHasta);
    $fechaFinMes = strtotime(date('Y-m-t', strtotime(date('Y') . '-' . (date('m') - 3) . '-01')));
    $fechaTope = $fechaHastaT;
    if ($fechaHastaT > $fechaFinMes) {
      $fechaTope = $fechaFinMes;
    }
    
    $fechaultimopagocolegio = $fecha_colegio;
    
    $fechaDesdeT = strtotime($fechaultimopagocolegio);
    $cuotas = date('Y', $fechaTope) * 12 + date('m', $fechaTope) - (date('Y', $fechaDesdeT) * 12 + date('m', $fechaDesdeT));
    $cuotasD = date('Y', $fechaHastaT) * 12 + date('m', $fechaHastaT) - (date('Y', $fechaDesdeT) * 12 + date('m', $fechaDesdeT));
    $d = $cuotasD - $cuotas;
    $porcentajeInteres = 8.5;
    $montoBase = 40.75;
    $montoInteresAtrasado = 0;
    if ($cuotas > 0) {
      //$montoInteresAtrasado = $this->calculoPotenciaColegio($cuotas, $porcentajeInteres, $montoBase);
    }
    
    $mesesTemp = date('Y', $fechaHastaT) * 12 + date('m', $fechaHastaT);
    $mesesDesdeTemp = date('Y', $fechaDesdeT) * 12 + date('m', $fechaDesdeT);
    $cuotasTemp = $mesesDesdeTemp - $mesesTemp;
    $mesesAnterior = 1983 * 12 + 2;
    $montoAnterior = 6;
    $totalMontoColegio = 0;
    
    $montosPago = [['meses' => 1983 * 12 + 2, 'monto' => 6, 'codigo' => 'COL01', 'auxilio' => 0], ['meses' => 1989 * 12 + 12, 'monto' => 12, 'codigo' => 'COL02', 'auxilio' => 6], ['meses' => 1990 * 12 + 12, 'monto' => 23.25, 'codigo' => 'COL03', 'auxilio' => 12.75], ['meses' => 1991 * 12 + 9, 'monto' => 30, 'codigo' => 'COL04', 'auxilio' => 12.75], ['meses' => 2001 * 12 + 9, 'monto' => 39, 'codigo' => 'COL05', 'auxilio' => 12.75], ['meses' => 2001 * 12 + 12, 'monto' => 60, 'codigo' => 'COL06', 'auxilio' => 22.75], ['meses' => 2010 * 12 + 10, 'monto' => 65, 'codigo' => 'COL07', 'auxilio' => 22.75], ['meses' => 2011 * 12 + 8, 'monto' => 78.5, 'codigo' => 'COL08', 'auxilio' => 22.75], ['meses' => 2013 * 12 + 1, 'monto' => 98.5, 'codigo' => 'COL091', 'auxilio' => 22.75], ['meses' => date('Y') * 12 + date('m'), 'monto' => 115.75, 'codigo' => 'COL092', 'auxilio' => 40.75]];
    $detalleMontos = [];
    $montoInteresAtrasado = 0;
    foreach ($montosPago as $montoPago) {
      
      if ($mesesDesdeTemp <= $montoPago['meses']) {
        $diferencia = $montoPago['meses'] - $mesesDesdeTemp >= 0 ? $montoPago['meses'] - $mesesDesdeTemp : 0;
        $dif2 = $mesesTemp - $mesesDesdeTemp;
        if ($montoPago['monto'] == 115.75) {
          $diferencia += $d;
        }
        
        
        $totalMontoColegio += $diferencia * $montoPago['monto'];
        $cuotasTemp -= $diferencia;
        $mesesDesdeTemp = $montoPago['meses'];
        $detalleMontos[] = ['codigo' => $montoPago['codigo'], 'cuotas' => $diferencia, 'preciou' => $montoPago['monto']];
        $montoInteresAtrasado += $this->calculoPotenciaColegio($diferencia, $porcentajeInteres, $montoPago['auxilio'], $dif2);
      }
    }
    $query = "select importe from calculo_colegiado(" . $colegiado . ", '" . $fecha_hasta_donde_paga . "','02', '" . date('Y-m-d') . "') WHERE codigo='INT'";
    $users = DB::connection('sqlsrv')->select($query);
    $colegiadoR = null;
    foreach ($users as $colegiado1) {
      $colegiadoR = $colegiado1;
    }
    $inte = 0;
    if ($colegiadoR) {
      $inte = $colegiadoR->importe;
    }
    
    
    $query = "select * from calculo_colegiado(" . $colegiado . ", '" . $fecha_hasta_donde_paga . "','02', '" . date('Y-m-d') . "') WHERE codigo!='INT'";
    
    $users = DB::connection('sqlsrv')->select($query);
    $colegiadoR1 = null;
    $detalleMontos = [];
    $capitalT = 0;
    foreach ($users as $colegiado2) {
      $colegiadoR = $colegiado2;
      $detalleMontos[] = ['codigo' => $colegiado2->codigo, 'cuotas' => $colegiado2->cantidad, 'preciou' => $colegiado2->precio];
      $capitalT += $colegiado2->cantidad * $colegiado2->precio;
    }
    
    $totalMontoColegio += ($mesesTemp - ($mesesDesdeTemp > 0 ? $mesesDesdeTemp : 0)) * 115.75;
    $total = $totalMontoColegio + $montoInteresAtrasado;
    $total = $capitalT + $inte;
    
    return array("montoInteres" => round($inte, 2), "cuotas" => $cuotasD, 'capitalColegio' => $capitalT, 'totalColegio' => round($total, 2), 'detalleMontos' => $detalleMontos);
    //        return array("montoInteres" => round($inte, 2), "cuotas" => $cuotasD, 'capitalColegio' => $totalMontoColegio, 'totalColegio' => round($total,2), 'detalleMontos' => $detalleMontos);
  }
  
  private function calculoPotenciaColegio($cuotasAtrasadas, $porcentajeInteres, $montoBase, $dif2)
  {
    $suma = 0;
    for ($i = 1; $i < $cuotasAtrasadas + 1; $i++) {
      $suma += pow(1 + $porcentajeInteres / 1000, $dif2 - $i);
    }
    $suma = $montoBase * ($suma - $cuotasAtrasadas);
    return $suma;
  }
  public function calcularTipoCuota($cantidad = 1, $cuotas) {
    $fechaActual = Carbon::Now()->startOfMonth();
    $fecha11 = Carbon::Now()->startOfMonth();
    $fecha10 = Carbon::parse('01-01-2013')->startOfMonth();
    $fecha8 = Carbon::parse('01-08-2011')->startOfMonth();
    $fecha7 = Carbon::parse('01-10-2010')->startOfMonth();
    $fecha6 = Carbon::parse('01-12-2001')->startOfMonth();
    $fecha5 = Carbon::parse('01-09-2001')->startOfMonth();
    $fecha4 = Carbon::parse('01-09-1991')->startOfMonth();
    $fecha3 = Carbon::parse('01-12-1990')->startOfMonth();
    $fecha2 = Carbon::parse('01-12-1989')->startOfMonth();
    $fecha1 = Carbon::parse('01-02-1983')->startOfMonth();
    $cuota11=0;$cuota10=0;$cuota8=0;$cuota7=0;$cuota6=0;
    $cuota5=0;$cuota4=0;$cuota3=0;$cuota2=0;$cuota1=0;
    $arrayDatos=array();
    $arrayColegiaturaDetalle= array();
    $arrayColegiaturaTimbreDetalle= array();
    
    
    for ($i=0; $i <$cuotas ; $i++) { 
      

      if($fechaActual<=$fecha11  && $fechaActual > $fecha10 ){
        $tipoCuota = \App\TipoDePago::where('id',11)->first();
        $detalle = new \stdClass();
        $mesInicial = $fechaActual->format('m');
        $añoInicial = $fechaActual->format('Y');
        $mes =\App\SigecigMeses::where('id',$mesInicial)->first();
        $fechaPago = ' ('.$mes->mes.' del '.$añoInicial.')';
        $detalle->fechaPago = $fechaPago;
        $detalle->tipoPago = $tipoCuota->tipo_de_pago;
        $detalle->precio = $tipoCuota->precio_colegiado;
        $detalle->codigo = $tipoCuota->codigo;
        $detalle->cantidad = 1;
        $detalle->total = $detalle->cantidad * $detalle->precio;
        $arrayColegiaturaDetalle[]=$detalle;
        $cuota11+=1;
      }
      if($fechaActual<=$fecha10 && $fechaActual > $fecha8 ){
        $tipoCuota = \App\TipoDePago::where('id',10)->first();
        $detalle = new \stdClass();
        $mesInicial = $fechaActual->format('m');
        $añoInicial = $fechaActual->format('Y');
        $mes =\App\SigecigMeses::where('id',$mesInicial)->first();
        $fechaPago = ' ('.$mes->mes.' del '.$añoInicial.')';
        $detalle->fechaPago = $fechaPago;
        $detalle->tipoPago = $tipoCuota->tipo_de_pago;
        $detalle->precio = $tipoCuota->precio_colegiado;
        $detalle->codigo = $tipoCuota->codigo;
        $detalle->cantidad = 1;
        $detalle->total = $detalle->cantidad * $detalle->precio;
        $arrayColegiaturaDetalle[]=$detalle;
        $cuota10+=1;
      }
      if($fechaActual<=$fecha8 && $fechaActual > $fecha7 ){
        $tipoCuota = \App\TipoDePago::where('id',8)->first();
        $detalle = new \stdClass();
        $mesInicial = $fechaActual->format('m');
        $añoInicial = $fechaActual->format('Y');
        $mes =\App\SigecigMeses::where('id',$mesInicial)->first();
        $fechaPago = ' ('.$mes->mes.' del '.$añoInicial.')';
        $detalle->fechaPago = $fechaPago;
        $detalle->tipoPago = $tipoCuota->tipo_de_pago;
        $detalle->precio = $tipoCuota->precio_colegiado;
        $detalle->codigo = $tipoCuota->codigo;
        $detalle->cantidad = 1;
        $detalle->total = $detalle->cantidad * $detalle->precio;
        $arrayColegiaturaDetalle[]=$detalle;
        $cuota8+=1;
      }
      if($fechaActual<=$fecha7 && $fechaActual > $fecha6 ){
        $tipoCuota = \App\TipoDePago::where('id',7)->first();
        $detalle = new \stdClass();
        $mesInicial = $fechaActual->format('m');
        $añoInicial = $fechaActual->format('Y');
        $mes =\App\SigecigMeses::where('id',$mesInicial)->first();
        $fechaPago = ' ('.$mes->mes.' del '.$añoInicial.')';
        $detalle->fechaPago = $fechaPago;
        $detalle->tipoPago = $tipoCuota->tipo_de_pago;
        $detalle->precio = $tipoCuota->precio_colegiado;
        $detalle->codigo = $tipoCuota->codigo;
        $detalle->cantidad = 1;
        $detalle->total = $detalle->cantidad * $detalle->precio;
        $arrayColegiaturaDetalle[]=$detalle;
        $cuota7+=1;
      }
      if($fechaActual<=$fecha6 && $fechaActual > $fecha5 ){
        $tipoCuota = \App\TipoDePago::where('id',6)->first();
        $detalle = new \stdClass();
        $mesInicial = $fechaActual->format('m');
        $añoInicial = $fechaActual->format('Y');
        $mes =\App\SigecigMeses::where('id',$mesInicial)->first();
        $fechaPago = ' ('.$mes->mes.' del '.$añoInicial.')';
        $detalle->fechaPago = $fechaPago;
        $detalle->tipoPago = $tipoCuota->tipo_de_pago;
        $detalle->precio = $tipoCuota->precio_colegiado;
        $detalle->codigo = $tipoCuota->codigo;
        $detalle->cantidad = 1;
        $detalle->total = $detalle->cantidad * $detalle->precio;
        $arrayColegiaturaDetalle[]=$detalle;
        $cuota6+=1;
      }
      if($fechaActual<=$fecha5 && $fechaActual > $fecha4 ){
        $tipoCuota = \App\TipoDePago::where('id',5)->first();
        $detalle = new \stdClass();
        $mesInicial = $fechaActual->format('m');
        $añoInicial = $fechaActual->format('Y');
        $mes =\App\SigecigMeses::where('id',$mesInicial)->first();
        $fechaPago = ' ('.$mes->mes.' del '.$añoInicial.')';
        $detalle->fechaPago = $fechaPago;
        $detalle->tipoPago = $tipoCuota->tipo_de_pago;
        $detalle->precio = $tipoCuota->precio_colegiado;
        $detalle->codigo = $tipoCuota->codigo;
        $detalle->cantidad = 1;
        $detalle->total = $detalle->cantidad * $detalle->precio;
        $arrayColegiaturaDetalle[]=$detalle;
        $cuota5+=1;
      }
      if($fechaActual<=$fecha4 && $fechaActual > $fecha3 ){
        $tipoCuota = \App\TipoDePago::where('id',4)->first();
        $detalle = new \stdClass();
        $mesInicial = $fechaActual->format('m');
        $añoInicial = $fechaActual->format('Y');
        $mes =\App\SigecigMeses::where('id',$mesInicial)->first();
        $fechaPago = ' ('.$mes->mes.' del '.$añoInicial.')';
        $detalle->fechaPago = $fechaPago;
        $detalle->tipoPago = $tipoCuota->tipo_de_pago;
        $detalle->precio = $tipoCuota->precio_colegiado;
        $detalle->codigo = $tipoCuota->codigo;
        $detalle->cantidad = 1;
        $detalle->total = $detalle->cantidad * $detalle->precio;
        $arrayColegiaturaDetalle[]=$detalle;
        $cuota4+=1;
      }
      if($fechaActual<=$fecha3 && $fechaActual > $fecha2 ){
        $tipoCuota = \App\TipoDePago::where('id',3)->first();
        $detalle = new \stdClass();
        $mesInicial = $fechaActual->format('m');
        $añoInicial = $fechaActual->format('Y');
        $mes =\App\SigecigMeses::where('id',$mesInicial)->first();
        $fechaPago = ' ('.$mes->mes.' del '.$añoInicial.')';
        $detalle->fechaPago = $fechaPago;
        $detalle->tipoPago = $tipoCuota->tipo_de_pago;
        $detalle->precio = $tipoCuota->precio_colegiado;
        $detalle->codigo = $tipoCuota->codigo;
        $detalle->cantidad = 1;
        $detalle->total = $detalle->cantidad * $detalle->precio;
        $arrayColegiaturaDetalle[]=$detalle;
        $cuota3+=1;
      }
      if($fechaActual<=$fecha2 && $fechaActual > $fecha1 ){
        $tipoCuota = \App\TipoDePago::where('id',2)->first();
        $detalle = new \stdClass();
        $mesInicial = $fechaActual->format('m');
        $añoInicial = $fechaActual->format('Y');
        $mes =\App\SigecigMeses::where('id',$mesInicial)->first();
        $fechaPago = ' ('.$mes->mes.' del '.$añoInicial.')';
        $detalle->fechaPago = $fechaPago;
        $detalle->tipoPago = $tipoCuota->tipo_de_pago;
        $detalle->precio = $tipoCuota->precio_colegiado;
        $detalle->codigo = $tipoCuota->codigo;
        $detalle->cantidad = 1;
        $detalle->total = $detalle->cantidad * $detalle->precio;
        $arrayColegiaturaDetalle[]=$detalle;
        $cuota2+=1;
      }
      if($fechaActual<=$fecha1){
        $tipoCuota = \App\TipoDePago::where('id',1)->first();
        $detalle = new \stdClass();
        $mesInicial = $fechaActual->format('m');
        $añoInicial = $fechaActual->format('Y');
        $mes =\App\SigecigMeses::where('id',$mesInicial)->first();
        $fechaPago = ' ('.$mes->mes.' del '.$añoInicial.')';
        $detalle->fechaPago = $fechaPago;
        $detalle->tipoPago = $tipoCuota->tipo_de_pago;
        $detalle->precio = $tipoCuota->precio_colegiado;
        $detalle->codigo = $tipoCuota->codigo;
        $detalle->cantidad = 1;
        $detalle->total = $detalle->cantidad * $detalle->precio;
        $arrayColegiaturaDetalle[]=$detalle;
        $cuota1+=1;
      }
      $fechaActual->subMonth(1);
    }
    $arrayColegiatura= array();

    $arrayDatos[]=['cuotas'=>$cuota1,'id'=>1];
    $arrayDatos[]=['cuotas'=>$cuota2,'id'=>2];
    $arrayDatos[]=['cuotas'=>$cuota3,'id'=>3];
    $arrayDatos[]=['cuotas'=>$cuota4,'id'=>4];
    $arrayDatos[]=['cuotas'=>$cuota5,'id'=>5];
    $arrayDatos[]=['cuotas'=>$cuota6,'id'=>6];
    $arrayDatos[]=['cuotas'=>$cuota7,'id'=>7];
    $arrayDatos[]=['cuotas'=>$cuota8,'id'=>8];
    $arrayDatos[]=['cuotas'=>$cuota10,'id'=>10];
    $arrayDatos[]=['cuotas'=>$cuota11,'id'=>11];
    $fechaInicial = Carbon::parse($this->f_ult_pago)->startOfMonth();
    
    foreach ($arrayDatos as $key => $dato) {
      if($dato['cuotas']!= 0){
        $detalle = new \stdClass();
        $mesInicial = $fechaInicial->addMonth()->format('m');
        $añoInicial = $fechaInicial->format('Y');
        $mesFinal = $fechaInicial->subMonth()->addMonth($dato['cuotas'])->format('m');
        $añoFinal = $fechaInicial->format('Y');
  
  
        if($dato['id'] == 1){
          $fechaPago = ' ('.$mesInicial.' del '.$añoInicial.')';
        }else{
            $fechaPago = ' ('.$mesInicial.' del '.$añoInicial.')'.' al'.' ('.$mesFinal.' del '.$añoFinal.')';
        }
  
        $tipoCuota = \App\TipoDePago::where('id',$dato['id'])->first();
        $detalle->fechaPago = $fechaPago;
        $detalle->tipoPago = $tipoCuota->tipo_de_pago;
        $detalle->precio = $tipoCuota->precio_colegiado;
        $detalle->codigo = $tipoCuota->codigo;
        $detalle->cantidad = $dato['cuotas'];
        $detalle->total = $detalle->cantidad * $detalle->precio;
        $arrayColegiatura[]=$detalle;
      }

    }
    return array('arrayColegiatura'=>$arrayColegiatura,'arrayColegiaturaDetalle'=>$arrayColegiaturaDetalle);
  }

    ///funciones para reactivacion
    public function getMontoReactivacionMensual()
    {
      $interesColegio = 0;
      $interesTimbre = 0;
      $moraTimbre = 0;
      $fecha_actual = Carbon::now()->endOfMonth();
      $diffTimbre = Carbon::parse($this->f_ult_timbre)->endOfMonth()->diffInMonths($fecha_actual, false);
      $cuotas = TipoDePago::where('tipo_colegiatura',1)->orderBy('id','desc')->get();

      $diffColegio = Carbon::parse($this->f_ult_pago)->endOfMonth()->diffInMonths($fecha_actual,false);

      if ($diffColegio > 3) {
        if($this->paga_axulio = 1){
          $control = $diffColegio;
    
          $interesMensual = 8.5/1000;
          foreach ($cuotas as $key => $cuota) {
             $diffCuota = Carbon::parse($cuota->fecha_desde)->endOfMonth()->subMonth()->diffInMonths($fecha_actual,false);
             if($control  > $diffCuota){
                  //  $calculo = ($cuota->monto_auxilio * (pow(1+$interesMensual, $diffCuota-3)))-$cuota->monto_auxilio;dd($calculo);
                  //  $interesColegio = $interesColegio + $calculo;
                   $control -= $diffCuota;
             }else{
              $calculo = ($cuota->monto_auxilio * (pow(1+$interesMensual, $diffColegio-3)))-$cuota->monto_auxilio;
              $interesColegio = $interesColegio + $calculo;
             break;
             }
          }
        }
      }
      $array = array();


      $mesAnterior = $diffTimbre-1;
      if($mesAnterior <= 3){
        $interesAnterior = 0;
        $moraAnterior = 0;
      }else{
        $interesAnterior = round($this->monto_timbre*0.128/12*$mesAnterior*($mesAnterior-1)/2) ;
        $moraAnterior = round($this->monto_timbre*0.18/12*$mesAnterior*($mesAnterior-1)/2) ;
      }
      if($diffTimbre > 3){
        $interesTimbre = round($this->monto_timbre*0.128/12*$diffTimbre*($diffTimbre-1)/2) ;
        $moraTimbre = round($this->monto_timbre*0.18/12*$diffTimbre*($diffTimbre-1)/2) ;
        $interesTimbre = $interesTimbre - $interesAnterior;
        $moraTimbre = $moraTimbre - $moraAnterior;
      }
      if ($interesTimbre > 0) {
         $interesT = \App\TipoDePago::where('id',47)->first();
         $interesT->precio_colegiado = $interesTimbre;
         $interesT->tipo_de_pago = 'INTERES POR CUOTA TIMBRE ATRASADA';
         $array[] = $interesT; 
      }
      if ($moraTimbre > 0) {
         $interesT = \App\TipoDePago::where('id',48)->first();
         $interesT->precio_colegiado = $moraTimbre;
         $interesT->tipo_de_pago = 'MORA POR CUOTA TIMBRE ATRASADA';
         $array[] = $interesT; 
      }
      if ($interesColegio > 0) {
         $interesT = \App\TipoDePago::where('id',47)->first();
         $interesT->precio_colegiado = $interesColegio;
         $interesT->tipo_de_pago = 'INTERES POR CUOTA DE COLEGIATURA ATRASADA';
         $array[] = $interesT; 
      }

  


      // $array = ['interesTimbre'=>$interesTimbre,'interesColegiado'=>$interesColegio,'moraTimbre'=>$moraTimbre];

 
      return $array;
    }
  
}

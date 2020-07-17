<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\EstadoDeCuentaMaestro;
use App\EstadoDeCuentaDetalle;

class InsertColegiadosEstadoDeCuentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Llenado de datos de recibo Maestro
        $query = "select c_cliente from cc00 where c_cliente >= 11000 and c_cliente <= 11100";
        $result = DB::connection('sqlsrv')->select($query);

        for ($i = 0; $i < sizeof($result); $i++) {
            $cuentaM = EstadoDeCuentaMaestro::create([
                'colegiado_id'         => $result[$i]->c_cliente,
                'estado_id'            => '1',
                'fecha_creacion'       => date('Y-m-d h:i:s'),
                'usuario_id'           => '1',
            ]);
        }


        // Llenado de datos de recibo Detalle
        $query2 = "select colegiado_id from sigecig_estado_de_cuenta_maestro";
        $result2 = DB::connection('mysql')->select($query2);

        for ($i = 0; $i < sizeof($result2); $i++) {
            $colegiado = $result2[$i]->colegiado_id;

            // ALMACENAMIENTO ACTIVOS
            $query = "SELECT n_cliente, estado, f_ult_timbre, f_ult_pago, monto_timbre, fallecido FROM cc00
                      WHERE c_cliente = $colegiado AND DATEDIFF(month, f_ult_pago, GETDATE()) <= 3 and DATEDIFF(month, f_ult_timbre, GETDATE()) <= 3";
            $result = DB::connection('sqlsrv')->select($query);

            if (!empty($result)) {
                                    //calculando datos de timbre
                $mes_origen = date("m", strtotime($result[0]->f_ult_timbre)); //calculo de mes de fecha de timbre
                $anio_origen = date("Y", strtotime($result[0]->f_ult_timbre)); //calculo de anio de fecha de timbre
                $fecha_hasta_donde_paga = date('Y-m-t', strtotime(date('Y') . '-' . date('m') . '-01')); //fecha de ultimo dia del mes actual
                $monto_timbre = $result[0]->monto_timbre; //monto del timbre

                    $mes_fin = date("m", strtotime($fecha_hasta_donde_paga));
                    $anio_fin = date("Y", strtotime($fecha_hasta_donde_paga));

                    $capitalTimbre = round($monto_timbre * ($anio_fin * 12 + $mes_fin - ($anio_origen * 12 + $mes_origen)));

                                    //calculando datos de colegiatura
                $mes_origen = date("m", strtotime($result[0]->f_ult_pago)); //calculo de mes de fecha de colegiatura
                $anio_origen = date("Y", strtotime($result[0]->f_ult_pago)); //calculo de anio de fecha de colegiatura
                $fecha_hasta_donde_paga = date('Y-m-t', strtotime(date('Y') . '-' . date('m') . '-01')); //fecha de ultimo dia del mes actual

                    $mes_fin = date("m", strtotime($fecha_hasta_donde_paga));
                    $anio_fin = date("Y", strtotime($fecha_hasta_donde_paga));

                    $capitalColegio = round(115.75 * ($anio_fin * 12 + $mes_fin - ($anio_origen * 12 + $mes_origen)),2);

                            //Almacenamiento
                    $TotalCapital = $capitalColegio + $capitalTimbre;
                $consulta = "SELECT id FROM sigecig_estado_de_cuenta_maestro WHERE colegiado_id = $colegiado";
                $resp = DB::connection('mysql')->select($consulta);
                $fechaHoy = date('Y-m-d h:i:s');

                $cuentaD = EstadoDeCuentaDetalle::create([
                    'estado_cuenta_maestro_id'      => $resp[0]->id,
                    'cantidad'                      => '1',
                    'tipo_pago_id'                  => '58',
                    'recibo_id'                     => '1',
                    'abono'                         => '0.00',
                    'cargo'                         => $TotalCapital,
                    'usuario_id'                    => '1',
                    'estado_id'                     => '1',
                ]);

            }else {
                // ALMACENAMIENTO PARA INACTIVOS
                $query = "SELECT c_cliente, n_cliente, estado, f_ult_timbre, f_ult_pago, monto_timbre, fallecido FROM cc00
                          WHERE c_cliente = $colegiado AND DATEDIFF(month, f_ult_pago, GETDATE()) > 3 OR  c_cliente = $colegiado AND DATEDIFF(month, f_ult_timbre, GETDATE()) > 3";
                $result = DB::connection('sqlsrv')->select($query);

                                    //calculando datos de timbre
                $mes_origen = date("m", strtotime($result[0]->f_ult_timbre)); //calculo de mes de fecha de timbre
                $anio_origen = date("Y", strtotime($result[0]->f_ult_timbre)); //calculo de anio de fecha de timbre
                $fecha_hasta_donde_paga = date('Y-m-t', strtotime(date('Y') . '-' . date('m') . '-01')); //fecha de ultimo dia del mes actual
                $monto_timbre = $result[0]->monto_timbre; //monto del timbre

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
                    $totalPagoTimbre = $capital + $mora + $intereses;


                                    //calculando datos de colegiatura
                $fecha_colegio = date('y-m-t',strtotime($result[0]->f_ult_pago)); //extraccion de fecha de colegiatura
                $fechaDesdeT = strtotime($fecha_colegio); //conversion de fecha colegiado a lectura unix
                $fecha_hasta_donde_paga = date('Y-m-t', strtotime(date('Y') . '-' . date('m') . '-01')); //fecha de ultimo dia del mes actual

                $fechaHasta = $fecha_hasta_donde_paga;
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
                $totalPagoColegiado = $capitalT + $inte;

                $SaldoTotal = $totalPagoColegiado + $totalPagoTimbre;

                                //Almacenamiento
                $consulta = "SELECT id FROM sigecig_estado_de_cuenta_maestro WHERE colegiado_id = $colegiado";
                $resp = DB::connection('mysql')->select($consulta);
                $fechaHoy = date('Y-m-d h:i:s');

                $cuentaD = EstadoDeCuentaDetalle::create([
                    'estado_cuenta_maestro_id'      => $resp[0]->id,
                    'cantidad'                      => '1',
                    'tipo_pago_id'                  => '58',
                    'recibo_id'                     => '1',
                    'abono'                         => '0.00',
                    'cargo'                         => $SaldoTotal,
                    'usuario_id'                    => '1',
                    'estado_id'                     => '1',
                ]);
            }
        }
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

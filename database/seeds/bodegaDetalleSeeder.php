<?php

use Illuminate\Database\Seeder;
use App\IngresoBodegaDetalle;

class bodegaDetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'tipo_de_pago_id'=>'30',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'0',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'tipo_de_pago_id'=>'31',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'0',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'tipo_de_pago_id'=>'32',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'0',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'tipo_de_pago_id'=>'33',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'0',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'tipo_de_pago_id'=>'34',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'0',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'tipo_de_pago_id'=>'35',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'0',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'tipo_de_pago_id'=>'36',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'0',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'tipo_de_pago_id'=>'37',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'0',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
    }
}

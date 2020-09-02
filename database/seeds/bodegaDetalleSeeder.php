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
            'timbre_id'=>'1',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'10000',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'timbre_id'=>'2',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'8000',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'timbre_id'=>'3',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'7000',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'timbre_id'=>'4',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'11500',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'timbre_id'=>'5',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'6000',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'timbre_id'=>'6',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'9500',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'timbre_id'=>'7',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'4500',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
        DB::table('sigecig_ingreso_bodega_detalle')->insert([
            'fecha_ingreso'=>'2020-07-21 00:00:00',
            'ingreso_maestro_id'=>'0',
            'timbre_id'=>'8',
            'planchas'=>'0',
            'unidad_por_plancha'=>'0',
            'numeracion_inicial'=>'0',
            'numeracion_final'=>'4000',
            'cantidad'=>'0',
            'total'=>'0',
            'usuario_id'=>'1'
        ]);
    }
}

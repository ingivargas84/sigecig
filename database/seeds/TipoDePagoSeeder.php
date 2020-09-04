<?php

use Illuminate\Database\Seeder;
use App\TipoDePago;

class TipoDePagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COL01',
            'tipo_de_pago'=>'CUOTA CIG Q.6.00 VIGENTE DESDE FEBRERO-1983',
            'precio_colegiado'=>'6',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COL02',
            'tipo_de_pago'=>'CUOTA CIG Q.12.00 VIGENTE DEL MARZO-83 AL DICIEMBRE-89',
            'precio_colegiado'=>'12',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,

        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COL03',
            'tipo_de_pago'=>'CUOTA CIG Q.23.25 DE ENERO-1990 A DIC-1990',
            'precio_colegiado'=>'23.25',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,

        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COL04',
            'tipo_de_pago'=>'CUOTA CIG Q.30.00 DE ENE 1991 A SEPTIEMBRE 1991',
            'precio_colegiado'=>'30',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,

        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COL05',
            'tipo_de_pago'=>'CUOTA CIG DE Q.39 OCTUBRE 1991 A SEPTIEMBRE 2001',
            'precio_colegiado'=>'39',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COL06',
            'tipo_de_pago'=>'CUOTA CIG  Q60.00 DE OCTUBRE A DICIEMBRE 2001',
            'precio_colegiado'=>'60',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,

        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COL07',
            'tipo_de_pago'=>'CUOTA CIG Q.65.00 DE ENERO 2002 A OCTUBRE 2010',
            'precio_colegiado'=>'65',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,

        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COL08',
            'tipo_de_pago'=>'Cuota CIG  Q78.50  DE Noviembre 2010 a Agosto 2011',
            'precio_colegiado'=>'78.50',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COL09',
            'tipo_de_pago'=>'Cuota Colegiatura sin Auxilio Postumo',
            'precio_colegiado'=>'75.75',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'1',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COL091',
            'tipo_de_pago'=>'Cuota CIG  Q98.50  Vigente DESDE Septiembre 2011 A Enero 2013',
            'precio_colegiado'=>'98.50',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COL092',
            'tipo_de_pago'=>'Cuota CIG Q 115.75 Vigente desde  Febrero 2013',
            'precio_colegiado'=>'115.75',
            'precio_particular'=>'115.75',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>true,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COLE01',
            'tipo_de_pago'=>'Inscripcion Nuevo Colegiado',
            'precio_colegiado'=>'0',
            'precio_particular'=>'1100',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COLE03',
            'tipo_de_pago'=>'Recargo Cheque Rechazado',
            'precio_colegiado'=>'100',
            'precio_particular'=>'100',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COLE05',
            'tipo_de_pago'=>'Multa de 6 meses',
            'precio_colegiado'=>'0',
            'precio_particular'=>'500',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COLE06',
            'tipo_de_pago'=>'Multa mayor a 12 meses',
            'precio_colegiado'=>'0',
            'precio_particular'=>'1000',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COLE08',
            'tipo_de_pago'=>'Certificacion de Registro  en el CIG',
            'precio_colegiado'=>'10',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COLE10',
            'tipo_de_pago'=>'Registro de Maestria',
            'precio_colegiado'=>'25',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COLE13',
            'tipo_de_pago'=>'Registro de Diplomado',
            'precio_colegiado'=>'25',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COLE14',
            'tipo_de_pago'=>'Multa de 6 a 9 meses.',
            'precio_colegiado'=>'0',
            'precio_particular'=>'750',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COLEGIT',
            'tipo_de_pago'=>'Inscripcion Colegiado Temporal',
            'precio_colegiado'=>'0',
            'precio_particular'=>'1',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COLEGIT2',
            'tipo_de_pago'=>'Colegiatura Temporal',
            'precio_colegiado'=>'0',
            'precio_particular'=>'315',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TIM1',
            'tipo_de_pago'=>'TIMBRE DE 1 QUETZAL',
            'precio_colegiado'=>'1',
            'precio_particular'=>'0',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>true,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TIM10',
            'tipo_de_pago'=>'TIMBRE DE INGENIERIA DE 10 QUETZALES',
            'precio_colegiado'=>'10',
            'precio_particular'=>'0',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>true,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TIM100',
            'tipo_de_pago'=>'TIMBRE DE INGENIERIA DE 100 QUETZALES',
            'precio_colegiado'=>'100',
            'precio_particular'=>'0',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>true,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TIM20',
            'tipo_de_pago'=>'TIMBRE DE INGENIERIA DE 20 QUETZALES',
            'precio_colegiado'=>'20',
            'precio_particular'=>'0',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>true,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TIM200',
            'tipo_de_pago'=>'TIMBRE DE INGENIERIA DE 200 QUETZALES',
            'precio_colegiado'=>'200',
            'precio_particular'=>'0',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>true,

        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TIM5',
            'tipo_de_pago'=>'TIMBRE DE INGENIERIA DE 5 QUETZAL',
            'precio_colegiado'=>'5',
            'precio_particular'=>'0',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>true,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TIM50',
            'tipo_de_pago'=>'TIMBRE DE INGENIERIA DE 50 QUETZALES',
            'precio_colegiado'=>'50',
            'precio_particular'=>'50',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>true,

        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TIM500',
            'tipo_de_pago'=>'TIMBRE DE INGENIERIA DE 500 QUETZALES',
            'precio_colegiado'=>'500',
            'precio_particular'=>'50',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>true,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TC01',
            'tipo_de_pago'=>'TIMBRE DE 1 QUETZAL POR CUOTA',
            'precio_colegiado'=>'1',
            'precio_particular'=>'1',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TC05',
            'tipo_de_pago'=>'TIMBRE DE 5 QUETZAL POR CUOTA',
            'precio_colegiado'=>'5',
            'precio_particular'=>'5',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TC10',
            'tipo_de_pago'=>'TIMBRE DE 10 QUETZALES POR CUOTA',
            'precio_colegiado'=>'10',
            'precio_particular'=>'10',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TC100',
            'tipo_de_pago'=>'TIMBRE DE 100 QUETZALES POR CUOTA',
            'precio_colegiado'=>'100',
            'precio_particular'=>'100',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TC20',
            'tipo_de_pago'=>'TIMBRE DE 20 QUETZALES POR CUOTA',
            'precio_colegiado'=>'20',
            'precio_particular'=>'20',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TC200',
            'tipo_de_pago'=>'TIMBRE DE 200 QUETZALES POR CUOTA',
            'precio_colegiado'=>'200',
            'precio_particular'=>'200',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TC50',
            'tipo_de_pago'=>'TIMBRE DE 50 QUETZALES POR CUOTA',
            'precio_colegiado'=>'50',
            'precio_particular'=>'50',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TC500',
            'tipo_de_pago'=>'TIMBRE DE 500 QUETZALES POR CUOTA',
            'precio_colegiado'=>'500',
            'precio_particular'=>'500',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TE01',
            'tipo_de_pago'=>'TIMBRE Q1 PARA EMPRESA',
            'precio_colegiado'=>'0',
            'precio_particular'=>'1',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TE05',
            'tipo_de_pago'=>'TIMBRE Q5 PARA EMPRESA',
            'precio_colegiado'=>'0',
            'precio_particular'=>'5',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TE10',
            'tipo_de_pago'=>'TIMBRE Q10 PARA EMPRESA',
            'precio_colegiado'=>'0',
            'precio_particular'=>'10',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TE20',
            'tipo_de_pago'=>'TIMBRE Q20 PARA EMPRESA',
            'precio_colegiado'=>'0',
            'precio_particular'=>'20',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TE50',
            'tipo_de_pago'=>'TIMBRE Q50 PARA EMPRESA',
            'precio_colegiado'=>'0',
            'precio_particular'=>'50',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TE100',
            'tipo_de_pago'=>'TIMBRE Q100 PARA EMPRESA',
            'precio_colegiado'=>'0',
            'precio_particular'=>'100',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TE200',
            'tipo_de_pago'=>'TIMBRE Q200 PARA EMPRESA',
            'precio_colegiado'=>'0',
            'precio_particular'=>'200',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TE500',
            'tipo_de_pago'=>'TIMBRE Q500 PARA EMPRESA',
            'precio_colegiado'=>'0',
            'precio_particular'=>'500',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'CARNET',
            'tipo_de_pago'=>'CARNET DE AGREMIADO',
            'precio_colegiado'=>'50',
            'precio_particular'=>'0',
            'categoria_id'=>'8',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'INTT',
            'tipo_de_pago'=>'INTERES POR REACTIVACION',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'6',
            'estado'=>'0',
            'display_plataforma'=>false,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'MORT',
            'tipo_de_pago'=>'MORA POR REACTIVACION',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'7',
            'estado'=>'0',
            'display_plataforma'=>false,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'ALQ01',
            'tipo_de_pago'=>'Alquiler salón 1',
            'precio_colegiado'=>'3500',
            'precio_particular'=>'5500',
            'categoria_id'=>'8',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'ALQ02',
            'tipo_de_pago'=>'Alquiler salón 2',
            'precio_colegiado'=>'2500',
            'precio_particular'=>'3500',
            'categoria_id'=>'8',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COLE12',
            'tipo_de_pago'=>'Multa autorizada por Gerencia.',
            'precio_colegiado'=>'0',
            'precio_particular'=>'750',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'CONVCOL',
            'tipo_de_pago'=>'Convenio',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'8',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'DONA',
            'tipo_de_pago'=>'DONACIONES',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'8',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'RECH2',
            'tipo_de_pago'=>'Reposicion Cheque Rechazado',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'8',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'COLE02E',
            'tipo_de_pago'=>'Constancia electrónica',
            'precio_colegiado'=>'15',
            'precio_particular'=>'0',
            'categoria_id'=>'4',
            'estado'=>'0',
            'display_plataforma'=>true,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'REACT-TIMBRE',
            'tipo_de_pago'=>'reactivacion de timbre',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'REACT-COLEGIADO',
            'tipo_de_pago'=>'reactivacion de colegiatura',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'3',
            'estado'=>'0',
            'display_plataforma'=>false,
            'tipo'=>'1',
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'TIM-CUOTA',
            'tipo_de_pago'=>'pago de cuotas de timbre para reactivación',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'1',
            'estado'=>'0',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'VAR1',
            'tipo_de_pago'=>'Envío en capital y mpios de Guatemala(Guatex)24hrs',
            'precio_colegiado'=>'20',
            'precio_particular'=>'20',
            'categoria_id'=>'0',
            'estado'=>'0',
            'display_plataforma'=>true,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'VAR2',
            'tipo_de_pago'=>'Envío a deptos del país(Guatex) 5 días hábiles',
            'precio_colegiado'=>'30',
            'precio_particular'=>'30',
            'categoria_id'=>'0',
            'estado'=>'0',
            'display_plataforma'=>true,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'SALDOINICIAL',
            'tipo_de_pago'=>'saldo inicial',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'9',
            'estado'=>'2',
            'display_plataforma'=>false,
        ]);
        DB::table('sigecig_tipo_de_pago')->insert([
            'codigo'=>'timbre-mensual',
            'tipo_de_pago'=>'pago de mensualidades de cuota de timbre',
            'precio_colegiado'=>'0',
            'precio_particular'=>'0',
            'categoria_id'=>'1',
            'estado'=>'2',
            'display_plataforma'=>false,
        ]);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'updated_at'
    ];

    public function codigosTimbrePago($cantidad = 1) {
        $montoTemp = $this->monto_timbre * $cantidad;
        $valores = [500, 200, 100, 50, 20, 10, 5, 1];
        //$valores = [500, 200, 100, 5, 1];
        $retorno = array();
        foreach($valores as $valor) {
          if($montoTemp >= $valor) {
            $divisionEntera = intdiv($montoTemp, $valor);
            $montoTemp -= $valor * $divisionEntera;
            $detalle = new \stdClass();
            $detalle->codigo = 'TC' . str_pad($valor, 2, '0', STR_PAD_LEFT);
            $timbre = \App\TipoDePago::where('codigo',$detalle->codigo)->get()->first();
            $total = $timbre->precio_colegiado * $divisionEntera;
            $detalle->id = $timbre->id;
            $detalle->descripcion = $timbre->tipo_de_pago;
            $detalle->precio_colegiado = $timbre->precio_colegiado;
            $detalle->cantidad = $divisionEntera;
            $detalle->total=$total;
            $retorno[] = $detalle;
          }
        }
        return $retorno;
      }
    
}

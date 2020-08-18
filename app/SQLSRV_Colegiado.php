<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\IngresoProducto;

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
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aspirante extends Model
{
  protected $connection = 'sqlsrv';
  protected $table = 'aspirante';
  protected $primaryKey = 'dpi';
  protected $keyType = 'string';
  public $timestamps = false;
    //

    protected $fillable = [
      'dpi',
      'creditos',
      'valMunicipioNacimiento',
      'valDepartamentoNacimiento',
  ];

    public function universidadGraduado() {
      return $this->belongsTo('\App\Universidad', 'universidadGraduado');
    }

    public function universidadIncorporado() {
      return $this->belongsTo('\App\Universidad', 'universidadIncorporado');
    }

    public function departamentoNacimiento() {
      return $this->belongsTo('\App\DepartamentoNac', 'iddepartamentonacimiento');
    }

     public function profesiones()
    {
        return $this->belongsToMany('\App\Profesion', 'profesionAspirante', 'dpi', 'c_profesion');
    }

    public function especialidades()
    {
        return $this->belongsToMany('\App\Especialidad', 'especialidadAspirante', 'dpi', 'c_especialidad');
    } 
}

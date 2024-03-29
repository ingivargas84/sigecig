<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use DB;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'sigecig_users';
    protected $fillable = [
        'id', 'name', 'email', 'password', 'username', 'contador_intentos', 'estado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeCajeros($query)
    {
        $consulta = "SELECT U.id, U.name, IF(U.estado = 1,'Activo', 'Inactivo') as estado, R.name as rol
        from users_sigecig U 
        LEFT JOIN model_has_roles M on M.model_id = U.id
        LEFT JOIN roles R on R.id = M.role_id WHERE R.name ='Cobrador' order by U.id desc ";   

        $query = DB::select($consulta);

            return $query;
    }
}

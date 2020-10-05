<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'e_civil';

    protected $fillable=[
        'c_civil',
        'n_civil'
    ];
}

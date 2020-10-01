<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SQLSRV_Users extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'USERS';

    protected $fillable = [
        'id'
    ];
}

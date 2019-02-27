<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';

    public function poblacion()
    {
        return $this->belongsTo('App\Poblacion', 'poblacion_id');
    }
}

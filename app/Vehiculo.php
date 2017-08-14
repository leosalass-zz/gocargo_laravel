<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiculo extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vechiculos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['placa', 'color', 'propietario'];

    public function propietario()
    {
        return $this->belongsTo('App\Propietario', 'propietario', 'id');
    }
}

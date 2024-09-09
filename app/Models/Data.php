<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use SoapClient;
use Carbon\Carbon;

/**
 * Class Establecimientos
 * @package App\Models
 * @version February 1, 2018, 7:57 am UTC
 */
class Data extends Model
{
    use SoftDeletes;

    public $table = 'data_beneficiarios';
    
    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'dni',
        'celular',
        'departamento_id',        
        'establecimiento_proviene',
        'establecimiento_actual',
        'id_pnp_categoria',
        'fecha_hospitalizacion',
        'fallecido',
        'hospitalizado',
        'evolucion',
        'ventilacion_mecanica',
        'uci',
        'obervacion'
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [        
        'dni'=> 'string',
        'celular'=> 'string',
        'departamento_id'=> 'integer',
        'establecimiento_proviene'=> 'integer',
        'establecimiento_actual'=> 'integer',
        'fecha_hospitalizacion'=> 'string',
        'fallecido'=> 'string',
        'hospitalizado'=> 'string',
        'evolucion'=> 'string',
        'ventilacion_mecanica'=> 'string',
        'uci'=> 'string',
        'obervacion'=> 'string',
        'id_pnp_categoria'=> 'integer'
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];
    
}

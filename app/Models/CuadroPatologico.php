<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * Class Departamento
 * @package App\Models
 * @version February 7, 2018, 1:13 am UTC
 *
 * @property string nombre_dpto
 */
class CuadroPatologico extends Model
{
    use SoftDeletes;

    public $table = 'cuadro_patologicos';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'descripcion'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'descripcion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function getCuadroPatologico(){
        
        $cad="select id, descripcion as nombre from cuadro_patologicos";
        $data = DB::select($cad);

        return $data;
    }

    
}

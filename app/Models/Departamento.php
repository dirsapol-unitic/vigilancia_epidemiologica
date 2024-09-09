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
class Departamento extends Model
{
    use SoftDeletes;

    public $table = 'departamentos';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'nombre_dpto'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre_dpto' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function getDepartamento(){
        
        $cad="select id, nombre_dpto as nombre from departamentos";
        $data = DB::select($cad);

        return $data;
    }

    public static function getDpto(){
        
        $cad="select id, nombre_dpto as nombre from departamentos";
        $data = DB::select($cad);

        return $data;
    }

    
}

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
class InformeRiesgo extends Model
{
    use SoftDeletes;

    public $table = 'informe_riesgos';
    

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

    public function getInformeRiesgo(){
        
        $cad="select id, descripcion as nombre from informe_riesgos";
        $data = DB::select($cad);

        return $data;
    }

    public function getInforme($id){
        
        $cad="select descripcion from informe_riesgos where id=".$id;
        $data = DB::select($cad);

        return $data[0];
    }

    
}

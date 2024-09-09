<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * Class Distrito
 * @package App\Models
 * @version February 7, 2018, 1:18 am UTC
 *
 * @property string nombre_dist
 * @property integer provincia_id
 */
class Distrito extends Model
{
    use SoftDeletes;

    public $table = 'distritos';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'nombre_dist',
        'provincia_id',
        'departamento_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nombre_dist' => 'string',
        'provincia_id' => 'integer',
        'departamento_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
    /*public function getDistrito($id_dep, $id_prov){
        
        $cad="select id, nombre_dist as nombre from distritos where departamento_id = ".$id_dep;
        $cad.=" And provincia_id = ".$id_prov;
        $data = DB::select($cad);

        return $data;
    }*/

    public function getDistrito($id_dep, $id_prov){
        
        $cad="select id, nombre_dist as nombre from distritos where provincia_id = ".$id_prov;
        $data = DB::select($cad);

        return $data;
    }

    public static function getDist($id_dep, $id_prov){
        
        $cad="select id, nombre_dist as nombre from distritos where provincia_id = ".$id_prov;
        $data = DB::select($cad);

        return $data;
    }
}

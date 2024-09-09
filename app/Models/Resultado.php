<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * @package App\Models
 * @version January 31, 2018, 11:01 am UTC
 *
 * @property string descripcion
 */
class Resultado extends Model
{
    use SoftDeletes;

    public $table = 'resultados';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'descripcion',
        'prueba_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'descripcion' => 'string',
        'prueba_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function prueba(){

        return $this->belongsTo('App\Models\Prueba','prueba_id');
    }
    
    public function getResultados($id_prueba){
        
        $cad="select id, descripcion as nombre from resultados where prueba_id=".$id_prueba;
        $data = DB::select($cad);

        return $data;
    }
    
}

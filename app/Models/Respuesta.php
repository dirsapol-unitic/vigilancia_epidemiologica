<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * Class Categoria
 * @package App\Models
 * @version January 31, 2018, 11:01 am UTC
 *
 * @property string descripcion
 */
class Respuesta extends Model
{
    use SoftDeletes;

    public $table = 'respuestas';
    
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

    public function getTodasRespuestas($id_pregunta){
        
        $cad="select * from respuestas where pregunta_id".$id_pregunta;
        $data = DB::select($cad);

        return $data;
    }
    
}

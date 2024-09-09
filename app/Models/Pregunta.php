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
class Pregunta extends Model
{
    use SoftDeletes;

    public $table = 'preguntas';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'pregunta'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'pregunta' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function getTodasPreguntas(){
        
        $cad="select * from preguntas";
        $data = DB::select($cad);

        return $data;
    }
    
}

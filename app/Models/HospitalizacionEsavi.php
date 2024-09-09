<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * Class Establecimientos
 * @package App\Models
 * @version February 1, 2018, 7:57 am UTC
 */
class HospitalizacionEsavi extends Model
{
    use SoftDeletes;

    public $table = 'hospitalizado_esavis';
    

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'id_paciente',
        'fecha_registro',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [        
        'id_paciente'=> 'integer',
        'estado'=> 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //devolver valores de 1 a muchos
      
    function getHospitalizacionEsavis($id_paciente,$dni){
        $cad = "select a.*
                from hospitalizado_esavis a
                where  a.paciente_id = ".$id_paciente."  and a.paciente_dni = '".$dni."' ";
        $data = DB::select($cad);
        
        return $data;
    }  
    
}

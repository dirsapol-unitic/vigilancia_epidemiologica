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
class Hospitalizacion extends Model
{
    use SoftDeletes;

    public $table = 'hospitalizados';
    

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'id_paciente',
        'fecha_registro',
        'dni_paciente',
        'fecha_hospitalizacion',
        'tipo_seguro',
        'id_establecimiento',
        'servicio_hospitalizacion',
        'id_ventilacion_mecanica',
        'id_intubado',
        'id_neumonia',
        'otro_signo',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [        
        'id_paciente'=> 'integer',
        'fecha_registro'=> 'string',
        'dni_paciente'=> 'string',
        'fecha_hospitalizacion'=> 'string',
        'tipo_seguro'=> 'string', 
        'id_establecimiento'=> 'integer',
        'servicio_hospitalizacion'=> 'integer',
        'id_ventilacion_mecanica'=> 'integer',
        'id_intubado'=> 'integer',
        'id_neumonia'=> 'integer',
        'otro_signo_ho'=> 'string',
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
    
    public function signohospitalizados(){
        return $this->belongsToMany('App\Models\Signo');
    }

    
    function getHospitalizacion($id_paciente,$dni){
        $cad = "select a.*, e.nombre_establecimiento_salud nombre_establecimiento, es.nombre_establecimiento_salud nombre_actual, u1.name as usuario_registro, u2.name as usuario_update, u3.name as usuario_alta
                from hospitalizados a
                inner join users u1 on a.id_user_registro = u1.id
                left join users u2 on a.id_user_actualizacion = u2.id
                left join users u3 on a.id_user_alta = u3.id
                left join establecimiento_saluds e on e.id=a.establecimiento_proviene
                left join establecimiento_saluds es on es.id=a.establecimiento_actual
                where  a.estado  = 1 and a.id_paciente = ".$id_paciente."  and a.dni_paciente = '".$dni."' ";
        $data = DB::select($cad);
        
        return $data;
    }  
    
}

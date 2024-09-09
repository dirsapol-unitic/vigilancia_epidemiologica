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
class Antecedente extends Model
{
    use SoftDeletes;

    public $table = 'antecedentes';
    

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'id_clasificacion',
        'id_establecimiento',
        'fecha_registro',
        'id_user',        
        'dni',
        'fecha_sintoma',
        'fecha_aislamiento',
        'id_departamento2',
        'id_provincia2',
        'id_distrito2',
        'otro_sintoma',
        'otro_signo',
        'otro_factor',
        'otra_ocupacion',
        'contacto_directo',
        'ficha_contacto',
        'caso_reinfeccion',
        'ubicacion_hospitalizacion',
        'indicacion',
        'motivo',
        'id_user_actualizacion',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [        
        'id_clasificacion'=> 'integer',
        'id_establecimiento'=> 'integer',
        'fecha_registro'=> 'string',
        'id_user'=> 'integer', 
        'dni'=> 'string',
        'fecha_sintoma'=> 'string',
        'fecha_aislamiento'=> 'string',
        'id_departamento2'=> 'integer',
        'id_provincia2'=> 'integer',
        'id_distrito2'=> 'integer',
        'otro_sintoma'=> 'string',
        'otro_signo'=> 'string',
        'otro_factor'=> 'string',
        'otra_ocupacion'=> 'string',
        'ficha_contacto'=> 'string',
        'caso_reinfeccion'=> 'string',
        'indicacion'=> 'string',
        'motivo'=> 'stringr',
        'id_user_actualizacion'=> 'integer',
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
    
    public function factorantecedentes(){
        return $this->belongsToMany('App\Models\FactorRiesgo');
    }

    public function sintomaantecedentes(){
        return $this->belongsToMany('App\Models\Sintoma');
    }

    public function signoantecedentes(){
        return $this->belongsToMany('App\Models\Signo');
    }

    public function ocupacioneantecedentes(){
        return $this->belongsToMany('App\Models\Ocupacione');
    }

    public function lugarantecedentes(){
        return $this->belongsToMany('App\Models\Lugare');
    }


    function getAntecedentes($id,$dni){
        $cad = "select a.*, e.nombre, u.name 
                from antecedentes a
                inner join establecimientos e on e.id=a.id_establecimiento
                inner join users u on u.id=a.id_user
                where  a.estado=1 and a.dni = '".$dni."' ";
        $data = DB::select($cad);
        
        return $data;
    }  

 
}

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
class Contacto extends Model
{
    use SoftDeletes;

    public $table = 'contactos';
    

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'fecha_registro',
        'dni',
        'cip',
        'nombres',        
        'apellido_paterno',
        'apellido_materno',
        'sexo',
        'fecha_nacimiento',
        'grado',
        'id_departamento',
        'id_provincia',
        'id_distrito',
        'email',
        'celular',
        'domicilio',
        'id_pnpcategoria',
        'id_factor',
        'dj',
        'riesgo',
        'atencion',
        'trabajo_remoto',
        'fecha_aislamiento',
        'consideracion',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [        
        'fecha_registro'=> 'string',
        'dni'=> 'string',
        'cip'=> 'string',
        'nombres'=> 'string', 
        'apellido_paterno'=> 'string',
        'apellido_materno'=> 'string',
        'sexo'=> 'string',
        'fecha_nacimiento'=> 'string',
        'grado'=> 'string',
        'id_departamento'=> 'integer',
        'id_provincia'=> 'integer',
        'id_distrito'=> 'integer',
        'email'=> 'string',
        'celular'=> 'string',
        'domicilio'=> 'string',
        'id_pnpcategoria'=> 'integer',
        'id_factor'=> 'integer',
        'dj'=> 'integer',
        'atencion'=> 'integer',
        'trabajo_remoto'=> 'integer',
        'fecha_aislamiento' => 'string',
        'riesgo'=> 'string',
        'consideracion'=> 'integer',
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
    public function factorcontactos(){
        return $this->belongsToMany('App\Models\FactorRiesgo');
    }

    public function getContactos($id_paciente, $dni, $idficha){
        $cad="select a.* 
        from contactos a
        where  a.id_aislado = ".$id_paciente."  and a.dni_aislado = '".$dni."' and a.idficha = ".$idficha." ";
        $data = DB::select($cad);
        return $data;
    }
 
}

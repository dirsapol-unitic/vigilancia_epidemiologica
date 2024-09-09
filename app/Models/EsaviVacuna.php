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
class EsaviVacuna extends Model
{
    use SoftDeletes;

    public $table = 'esavi_vacunas';
    

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

     function getEsaviVacunas($id_esavi,$dni,$id_paciente){
        $cad = "select a.*
                from esavi_vacunas a
                where  a.esavi_id = ".$id_esavi."  and a.dni_paciente = '".$dni."' and a.paciente_id = ".$id_paciente;
        $data = DB::select($cad);
        
        return $data;
    }  

    
}

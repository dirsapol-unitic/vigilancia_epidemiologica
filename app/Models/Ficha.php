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
class Ficha extends Model
{
    use SoftDeletes;

    public $table = 'fichas';
    

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'id_aislado',
        'dni',
        'id_user',
        'id_user_actualizacion',        
        'activo',
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [        
        'id_aislado'=> 'integer',
        'dni'=> 'string',
        'id_user'=> 'integer',
        'id_user_actualizacion'=> 'integer',
        'activo'=> 'integer',
        'estado'=> 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    function getFichas2($id,$dni){
        $year = date('Y');
        $cad = "select fichas.*
                from fichas
                inner join aislados on fichas.id_aislado = a.id
                where fichas.id_aislado = ".$id." and fichas.dni = '".$dni."' ";
        $data = DB::select($cad);
        
        return $data[0];
    }  

    function getFechaServidorRestaMeses($mes) {

        $cad = "SELECT (CAST(now() AS DATE) - CAST('" . $mes . " month' AS INTERVAL))::date fechaservidor";
        $data = DB::select($cad);
        return $data[0]->fechaservidor;
    }

    function getFichas($id,$dni){
        $cad = "select a.*, e.nombre, u.name, to_char(a.created_at,'dd-mm-yyyy') fecha_reg_ficha 
                from fichas a
                inner join establecimientos e on e.id=a.id_establecimiento
                inner join users u on u.id=a.id_user
                where  a.estado=1 and a.dni = '".$dni."' ";
        $data = DB::select($cad);
        
        return $data;
    }  
}

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
class Esavi extends Model
{
    use SoftDeletes;

    public $table = 'esavis';
    

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'estado'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [        
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
    
    public function clasificacionesavis(){
        return $this->belongsToMany('App\Models\Clasificacion');
    }

    public function seguimientoesavis(){
        return $this->belongsToMany('App\Models\Seguimiento');
    }

     public function comorbilidadesavis(){
        return $this->belongsToMany('App\Models\FactorRiesgo');
    }

    public function patologicoesavis(){
        return $this->belongsToMany('App\Models\CuadroPatologico');
    }

     public function enfermedadesavis(){
        return $this->belongsToMany('App\Models\EnfermedadRegione');
    }

    public function previoesavis(){
        return $this->belongsToMany('App\Models\Previo');
    }

    function getEsavis($id,$dni){
        $cad = "select a.*, u.name 
                from esavis a
                inner join users u on u.id=a.id_user_registro
                where  a.dni = '".$dni."' ";
        $data = DB::select($cad);
        
        return $data;
    }  

}
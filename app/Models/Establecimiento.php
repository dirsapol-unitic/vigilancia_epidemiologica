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
class Establecimiento extends Model
{
    use SoftDeletes;

    public $table = 'establecimientos';
    

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'codigo_eess',
        'cod_ipress',
        'region',
        'redregion',
        'nombre',
        'nivel',
        'categoria',        
        'departamento',
        'provincia',
        'distrito',
        'ubigeo',
        'coddisa',
        'disa',
        'norte',
        'este',
        'cota',
        'direccion'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'codigo_eess' => 'string',
        'cod_ipress' => 'string',
        'nombre' => 'string',
        'region' => 'integer',
        'redregion' => 'string',
        'nivel' => 'integer',
        'categoria' => 'integer',
        'departamento' => 'integer',
        'provincia' => 'integer',
        'distrito' => 'integer',
        'ubigeo' => 'string',
        'coddisa' => 'string',
        'disa' => 'string',
        'norte' => 'string',
        'este' => 'string',
        'cota' => 'string',
        'direccion' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //devolver valores de 1 a muchos
    
    public function est_usuario(){

        return $this->belongsTo('App\Models\User','establecimiento_id');
    }

    public function getTodosEstablecimientos(){
        
        $cad="select * from establecimientos";
        $data = DB::select($cad);

        return $data;
    }

    public function getListarEstablecimientos(){
        
        $cad="select establecimientos.*, regions.descripcion  from establecimientos left join regions on regions.id=establecimientos.region";
        $data = DB::select($cad);

        return $data;
    }

    public function getEstablecimientos($id){
        
        $datos=DB::table('establecimientos')
               //->where('establecimientos.estado','=',1)
               ->where('establecimientos.id','=',$id)
               ->select('establecimientos.*')
               ->first();
        return $datos;
    }    

    
    public function GetByDireccion($id){
        $datos=DB::table('establecimientos') 
                ->select('establecimientos.direccion')
                ->where('establecimientos.id','=',$id)
                ->get();
        return $datos;       
    }

    public function GetByCodigo($id){
        $datos=DB::table('establecimientos') 
                ->select('establecimientos.cod_ipress')
                ->where('establecimientos.id','=',$id)
                ->get();
        return $datos;       
    }

    
    public function user(){

        return $this->hasMany('App\Models\Users');

    }

}

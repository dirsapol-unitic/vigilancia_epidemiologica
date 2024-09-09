<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class EstablecimientoSalud extends Model
{
    use SoftDeletes;

    public $table = 'establecimiento_saluds';

    protected $dates = ['deleted_at'];
    
    public $fillable = [
        'nombre_establecimiento_salud'
    ];

    protected $casts = [
        'nombre_establecimiento_salud' => 'string'
    ];

    public static $rules = [
    ];

    public function getTodosEstablecimientoSalud(){
        
        $cad="select * from establecimiento_saluds where estado=1";
        $data = DB::select($cad);

        return $data;
    }

    public static function getAllEstablecimientoSalud(){
        
        $cad="select * from establecimiento_saluds where estado=1";
        $data = DB::select($cad);

        return $data;
    }

    public function getEstablecimientos($id){
        
        $datos=DB::table('establecimiento_saluds')
               ->where('establecimiento_saluds.estado','=',1)
               ->where('establecimiento_saluds.id','=',$id)
               ->select('establecimiento_saluds.*')
               ->first();
        return $datos;
    } 
    
}

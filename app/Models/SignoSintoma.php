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
class SignoSintoma extends Model
{
    use SoftDeletes;

    public $table = 'signo_sintomas';
    

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
        'estado' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];   

    public function getSignoSintomas($id, $dni){
        
        $cad="  select *, u.name 
                from signo_sintomas a 
                inner join users u on u.id=a.id_user_registro
                where  a.dni = '".$dni."' and  a.id_aislado = ".$id;
        $data = DB::select($cad);

        return $data;
    }

    function getAntecedentes($id,$dni){
        $cad = "select a.*, e.nombre, u.name 
                from antecedentes a
                inner join establecimientos e on e.id=a.id_establecimiento
                inner join users u on u.id=a.id_user
                where  a.dni = '".$dni."' ";
        $data = DB::select($cad);
        
        return $data;
    }   
    
}

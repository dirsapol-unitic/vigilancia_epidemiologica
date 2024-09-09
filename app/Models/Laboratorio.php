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
class Laboratorio extends Model
{
    use SoftDeletes;

    public $table = 'laboratorios';
    

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

    public function getLaboratorio(){
        
        $cad="select id, tipo_muestra as nombre from laboratorios";
        $data = DB::select($cad);

        return $data;
    }

    public function GetLaboratorioByIdPaciente($id, $dni, $idficha) {

        $cad = "select t1.*, m.descripcion muestra, p.descripcion prueba, r.descripcion resultado
            from laboratorios t1
            inner join muestras m on m.id=t1.tipo_muestra 
            inner join pruebas p on p.id = t1.tipo_prueba
            inner join resultados r on r.id = t1.resultado_muestra
            where t1.estado=1 and t1.idficha=".$idficha." and t1.id_paciente=".$id."
             and t1.dni_paciente='".$dni."'";
            
        
        $data = DB::select($cad);
        return $data;
    }

    
}

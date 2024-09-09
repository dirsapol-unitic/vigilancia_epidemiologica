<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

/**
 * Class Region
 * @package App\Models
 * @version February 24, 2018, 8:14 am UTC
 *
 * @property string descripcion
 */
class Region extends Model
{
    use SoftDeletes;

    public $table = 'regions';
    

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

    public function getTodosRegiones(){
        
        $cad="select * from regions";
        $data = DB::select($cad);

        return $data;
    }
    
}

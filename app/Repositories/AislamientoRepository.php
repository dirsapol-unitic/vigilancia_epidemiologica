<?php

namespace App\Repositories;

use App\Models\Aislamiento;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EstablecimientoRepository
 * @package App\Repositories
 * @version February 24, 2018, 8:10 am UTC
 *
 * @method Aislamientoe findWithoutFail($id, $columns = ['*'])
 * @method Aislamientoe find($id, $columns = ['*'])
 * @method Aislamientoe first($columns = ['*'])
*/
class AislamientoRepository extends BaseRepository
{
    /**
     * @var array
     */
    
    protected $fieldSearchable = [
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
        'atencion',
        'trabajo_remoto',
        'fecha_aislamiento',
        //'id_riesgo',
        'consideracion',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Aislamiento::class;
    }
}

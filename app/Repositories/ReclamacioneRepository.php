<?php

namespace App\Repositories;

use App\Models\Reclamacione;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EstablecimientoRepository
 * @package App\Repositories
 * @version February 24, 2018, 8:10 am UTC
 *
 * @method Reclamacione findWithoutFail($id, $columns = ['*'])
 * @method Reclamacione find($id, $columns = ['*'])
 * @method Reclamacione first($columns = ['*'])
*/
class ReclamacioneRepository extends BaseRepository
{
    /**
     * @var array
     */
    
    protected $fieldSearchable = [
        'fecha_reclamacion',
        'fecha_registro',
        'nro_reclamacion',
        'id_establecimiento',
        'tipo_doc',
        'nro_doc',
        'nombres',        
        'departamento',
        'provincia',
        'distrito',
        'apellido_paterno',
        'apellido_materno',
        'domicilio',
        'telefono',
        'email',
        'celular',
        'reclamo',
        'autorizar_envio',
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Reclamacione::class;
    }
}

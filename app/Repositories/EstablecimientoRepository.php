<?php

namespace App\Repositories;

use App\Models\Establecimiento;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EstablecimientoRepository
 * @package App\Repositories
 * @version February 24, 2018, 8:10 am UTC
 *
 * @method Establecimiento findWithoutFail($id, $columns = ['*'])
 * @method Establecimiento find($id, $columns = ['*'])
 * @method Establecimiento first($columns = ['*'])
*/
class EstablecimientoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'codigo_eess',
        'cod_ipress',
        'redregion',
        'region',
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
     * Configure the Model
     **/
    public function model()
    {
        return Establecimiento::class;
    }
}

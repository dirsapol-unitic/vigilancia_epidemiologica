<?php

namespace App\Repositories;

use App\Models\Resultado;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DepartamentoRepository
 * @package App\Repositories
 * @version February 24, 2018, 8:19 am UTC
 *
 * @method FactorRiesgo findWithoutFail($id, $columns = ['*'])
 * @method FactorRiesgo find($id, $columns = ['*'])
 * @method FactorRiesgo first($columns = ['*'])
*/
class ResultadoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descripcion',
        'prueba_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Resultado::class;
    }
}

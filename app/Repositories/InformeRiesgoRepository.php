<?php

namespace App\Repositories;

use App\Models\InformeRiesgo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DepartamentoRepository
 * @package App\Repositories
 * @version February 24, 2018, 8:19 am UTC
 *
 * @method InformeRiesgo findWithoutFail($id, $columns = ['*'])
 * @method InformeRiesgo find($id, $columns = ['*'])
 * @method InformeRiesgo first($columns = ['*'])
*/
class InformeRiesgoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descripcion'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return InformeRiesgo::class;
    }
}

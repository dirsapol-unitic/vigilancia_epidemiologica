<?php

namespace App\Repositories;

use App\Models\PnpCategoria;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DepartamentoRepository
 * @package App\Repositories
 * @version February 24, 2018, 8:19 am UTC
 *
 * @method PnpCategoria findWithoutFail($id, $columns = ['*'])
 * @method PnpCategoria find($id, $columns = ['*'])
 * @method PnpCategoria first($columns = ['*'])
*/
class PnpCategoriaRepository extends BaseRepository
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
        return PnpCategoria::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\Lugare;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DepartamentoRepository
 * @package App\Repositories
 * @version February 24, 2018, 8:19 am UTC
 *
 * @method Ocupacione findWithoutFail($id, $columns = ['*'])
 * @method Ocupacione find($id, $columns = ['*'])
 * @method Ocupacione first($columns = ['*'])
*/
class LugareRepository extends BaseRepository
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
        return Lugare::class;
    }
}

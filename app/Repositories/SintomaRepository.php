<?php

namespace App\Repositories;

use App\Models\Sintoma;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DepartamentoRepository
 * @package App\Repositories
 * @version February 24, 2018, 8:19 am UTC
 *
 * @method Sintoma findWithoutFail($id, $columns = ['*'])
 * @method Sintoma find($id, $columns = ['*'])
 * @method Sintoma first($columns = ['*'])
*/
class SintomaRepository extends BaseRepository
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
        return Sintoma::class;
    }
}

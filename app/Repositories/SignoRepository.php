<?php

namespace App\Repositories;

use App\Models\Signo;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class DepartamentoRepository
 * @package App\Repositories
 * @version February 24, 2018, 8:19 am UTC
 *
 * @method Signo findWithoutFail($id, $columns = ['*'])
 * @method Signo find($id, $columns = ['*'])
 * @method Signo first($columns = ['*'])
*/
class SignoRepository extends BaseRepository
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
        return Signo::class;
    }
}

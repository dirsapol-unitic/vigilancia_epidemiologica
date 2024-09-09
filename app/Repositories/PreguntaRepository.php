<?php

namespace App\Repositories;

use App\Models\Pregunta;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CategoriaRepository
 * @package App\Repositories
 * @version February 24, 2018, 8:16 am UTC
 *
 * @method Categoria findWithoutFail($id, $columns = ['*'])
 * @method Categoria find($id, $columns = ['*'])
 * @method Categoria first($columns = ['*'])
*/
class PreguntaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pregunta'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Pregunta::class;
    }
}

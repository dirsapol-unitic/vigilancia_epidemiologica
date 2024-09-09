<?php

namespace App\Repositories;

use App\Models\CuadroPatologico;
use InfyOm\Generator\Common\BaseRepository;

class CuadroPatologicoRepository extends BaseRepository
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
        return CuadroPatologico::class;
    }
}

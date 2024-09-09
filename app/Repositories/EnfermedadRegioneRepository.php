<?php

namespace App\Repositories;

use App\Models\EnfermedadRegione;
use InfyOm\Generator\Common\BaseRepository;

class EnfermedadRegioneRepository extends BaseRepository
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
        return EnfermedadRegione::class;
    }
}

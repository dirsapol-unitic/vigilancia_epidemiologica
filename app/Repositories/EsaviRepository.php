<?php

namespace App\Repositories;

use App\Models\Esavi;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class EstablecimientoRepository
 * @package App\Repositories
 * @version February 24, 2018, 8:10 am UTC
 *
 * @method Aislamientoe findWithoutFail($id, $columns = ['*'])
 * @method Aislamientoe find($id, $columns = ['*'])
 * @method Aislamientoe first($columns = ['*'])
*/
class EsaviRepository extends BaseRepository
{
    /**
     * @var array
     */
    
    protected $fieldSearchable = [
        'estado'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Esavi::class;
    }
}

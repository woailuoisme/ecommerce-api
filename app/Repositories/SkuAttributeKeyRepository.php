<?php

namespace App\Repositories;

use App\Models\SkuKey;
use App\Repositories\BaseRepository;

/**
 * Class SkuAttributeKeyRepository
 * @package App\Repositories
 * @version April 15, 2020, 9:18 pm CST
*/

class SkuAttributeKeyRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SkuKey::class;
    }
}

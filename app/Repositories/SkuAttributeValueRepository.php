<?php

namespace App\Repositories;

use App\Models\SkuAttributeValue;
use App\Repositories\BaseRepository;

/**
 * Class SkuAttributeValueRepository
 * @package App\Repositories
 * @version April 15, 2020, 9:19 pm CST
*/

class SkuAttributeValueRepository extends BaseRepository
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
        return SkuAttributeValue::class;
    }
}

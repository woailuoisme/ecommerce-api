<?php

namespace App\Repositories;

use App\Models\ProductSku;
use App\Repositories\BaseRepository;

/**
 * Class ProductSkuRepository
 * @package App\Repositories
 * @version April 15, 2020, 9:15 pm CST
*/

class ProductSkuRepository extends BaseRepository
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
        return ProductSku::class;
    }
}

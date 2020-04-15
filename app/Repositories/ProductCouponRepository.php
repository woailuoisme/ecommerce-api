<?php

namespace App\Repositories;

use App\Models\ProductCoupon;
use App\Repositories\BaseRepository;

/**
 * Class ProductCouponRepository
 * @package App\Repositories
 * @version April 15, 2020, 9:17 pm CST
*/

class ProductCouponRepository extends BaseRepository
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
        return ProductCoupon::class;
    }
}

<?php

namespace App\Repositories;

use App\Models\ProductReview;
use App\Repositories\BaseRepository;

/**
 * Class ProductReviewRepository
 * @package App\Repositories
 * @version April 15, 2020, 9:16 pm CST
*/

class ProductReviewRepository extends BaseRepository
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
        return ProductReview::class;
    }
}

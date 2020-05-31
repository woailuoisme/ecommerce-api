<?php

namespace App\Repositories;

use App\Models\Product;

/**
 * Class ProductRepository
 * @package App\Repositories
 * @version April 15, 2020, 9:14 pm CST
*/

class ProductRepository extends BaseRepository
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
        return Product::class;
    }


    public function productList($perPage = 10, $type = Product::QUERY_ALL): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        $items = $this->model->newQuery()
            ->with(['reviews', 'skus', 'category'])
            ->where('is_sale', Product::SALE_TRUE)
            ->orderBy($this->model::UPDATED_AT, 'desc')
            ->get();
        $onTopItem = collect([]);
        foreach ($items as $key => $value) {
            if ($value->is_top === 1) {
                $onTopItem[] = $items->pull($key);
            }
        }
        $items = $onTopItem->combine($items);
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator($items, $items->count(), 10);

        switch ($type) {
            case Product::QUERY_HOT:
            case Product::QUERY_NEWEST:
            case Product::QUERY_RECOMMEND:
            case Product::QUERY_ALL:
                return $this->model->newQuery()
//                    ->with(['reviews','skus','category'])
                    ->where('is_sale', Product::SALE_TRUE)
                    ->orderBy($this->model::UPDATED_AT, 'desc')
                    ->paginate($perPage);
                break;
        }
    }

    public function products($page=null,$perPage = 10, $type = Product::QUERY_ALL): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        switch ($type) {
            case Product::QUERY_HOT:
            case Product::QUERY_NEWEST:
            case Product::QUERY_RECOMMEND:
            case Product::QUERY_ALL:
                return $this->model->newQuery()
//                    ->with(['reviews','skus','category'])
                    ->where('is_sale', Product::SALE_TRUE)
                    ->orderBy($this->model::UPDATED_AT, 'desc')
                    ->paginate($perPage,['*'],'page',$page);
                break;
        }
      return $this->model->newQuery()
            ->where('is_sale', Product::SALE_TRUE)
            ->orderBy($this->model::UPDATED_AT, 'desc')
          ->paginate($perPage);
    }


    public function productDetail($id)
    {
        return $this->model->newQuery()
            ->where('id', $id)
            ->where('is_sale', Product::SALE_TRUE)
            ->with(['reviews', 'category', 'skus'])
            ->withCount('reviews')
            ->orderBy($this->model::UPDATED_AT, 'desc')
            ->first();
    }
}

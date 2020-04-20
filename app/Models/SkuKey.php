<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class SkuAttributeKey
 * @package App\Models
 * @version April 15, 2020, 9:18 pm CST
 *
 */
class SkuKey extends Model
{

    public $table = 'product_sku_attributes_key';


    public $fillable = [
        'name',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


    public function skuValues(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SkuValue::class, 'sku_attributes_id', 'id');
    }

    public function hasSkuValues()
    {
        return $this->skuValues && $this->skuValues->count() > 0;
    }

    public function syncSkuValues($sku_values): array
    {
        $changes = [
            'created' => [],
            'deleted' => [],
        ];
        /** @var Collection $children */
        $children = $this->skuValues;
        /** @var Collection $sku_values */
        $sku_values = collect($sku_values)->unique();
//        dd($sku_values);
        /** @var Collection $children_names */
        $children_names = $children->pluck('name');
//        dd($sku_values,$children_names);
        $changes['created'] = $sku_values->diff($children_names);
        $changes['deleted'] = $children_names->diff($sku_values);
//        dd( $changes['created'],$changes['deleted'] );
        $changes['deleted']->each(function ($name) {
            $this->skuValues()->where('name', $name)->delete();
        });
        $this->skuValues()->saveMany($changes['created']->map(function ($name) {
            $skuValue = new SkuValue();
            $skuValue->name = $name;

            return $skuValue;
        }));

        return $changes;
    }


}

<?php

use App\Helpers\Util;
use App\Models\ProductSku;
use Illuminate\Database\Seeder;

class ProductSkuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $count = max((int)$this->command->ask('How many product would you like?', 100), 1);

        $products = \App\Models\Product::all();
        $products->each(function (\App\Models\Product $product) {
            /**
             * @link  https://stackoverflow.com/questions/29725880/how-to-use-break-or-continue-with-laravel-eloquent-collections-each-method
             */
            if (!$product->attribute_list) {
                return true;
            }
            $sku_array = \App\Helpers\Util::json_decode($product->attribute_list);
            $result = collect($sku_array)->mapWithKeys(function ($op) {
                return [$op['key'] => $op['values']];
            });

            $re = Util::cartesian($result->toArray());
//            dd($re);
            $product_sku_list = collect($re)->map(function ($r) use ($product) {
                /** @var ProductSku $product_sku */
                $product_sku = factory(ProductSku::class)->make();
                $product_sku->sku_json = Util::json_encode($r);
                $product_sku->sku_str = $product->id.'-'.implode('-', array_values($r));

                return $product_sku;
            });
//            dd($product_sku_list);
            DB::transaction(function () use ($product_sku_list, $product) {
                $product->skus()->saveMany($product_sku_list);
            });
        });
//        factory(\App\Models\ProductSku::class, $count)->make()->each(function ($product_sku) use($products){
//            $product_sku->product_id = $products->random()->id;
//            $product_sku->save();
//        });
    }
}

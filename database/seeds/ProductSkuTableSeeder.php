<?php

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
        $count = max((int)$this->command->ask('How many product would you like?', 100), 1);
        $products = \App\Models\Product::all();
        factory(\App\Models\ProductSku::class, $count)->make()->each(function ($product_sku) use($products){
            $product_sku->product_id = $products->random()->id;
            $product_sku->save();
        });
    }
}

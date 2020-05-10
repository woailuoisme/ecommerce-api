<?php

use Illuminate\Database\Seeder;

class ProductsTablesTableSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $productsCount = max((int)$this->command->ask('How many product would you like?', 20), 1);
        $categories = \App\Models\ProductCategory::all();


        factory(\App\Models\Product::class, $productsCount)->make()->each(function ($product) use($categories){
            $product->category_id = $categories->random()->id;
            $product->save();
        });


    }
}

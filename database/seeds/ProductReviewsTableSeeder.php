<?php

use App\User;
use Illuminate\Database\Seeder;

class ProductReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = max((int)$this->command->ask('How many reviews would you like?', 100), 1);
        $products = \App\Models\Product::all();
        $users = User::all();
        factory(\App\Models\ProductReview::class, $count)->make()->each(function ($review) use($products,$users){
            $review->product_id = $products->random()->id;
            $review->user_id = $users->random()->id;
            $review->save();
        });
    }
}

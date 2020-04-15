<?php

use App\Models\ProductReview;
use Illuminate\Database\Seeder;

class UserLikeCommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productCount = ProductReview::all()->count();
        if (0 === $productCount) {
            $this->command->info('No product found, skipping assigning tags to  posts');
            return;
        }
        \App\User::all()->each(function (\App\User $user) use($productCount) {
            $take = random_int(0, $productCount);
            $reviews = ProductReview::inRandomOrder()->take($take)->get()->pluck('id');
//            $user->favoriteProducts()->sync($orders);
            foreach ($reviews as  $key => $id){
                $user->likeReviews()->attach($id,['like'=>collect([-1,1])->random()]);
            }
//                $order->products()->sync($order,['quantity'=>random_int(1,5)]);
        });
    }
}

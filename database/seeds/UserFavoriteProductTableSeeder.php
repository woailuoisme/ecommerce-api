<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class UserFavoriteProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productCount = Product::all()->count();
        if (0 === $productCount) {
            $this->command->info('No product found, skipping assigning tags to  posts');
            return;
        }
        \App\User::all()->each(function (\App\User $user) use($productCount) {
            $take = random_int(0, $productCount);
            $orders = Product::inRandomOrder()->take($take)->get()->pluck('id');
            $user->favoriteProducts()->sync($orders);
//                $order->products()->sync($order,['quantity'=>random_int(1,5)]);
        });
    }
}

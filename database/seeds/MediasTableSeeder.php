<?php

use App\User;
use Illuminate\Database\Seeder;

class MediasTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('zh_CN');
        $products = \App\Models\Product::all();
        $products->each(function (\App\Models\Product $product) use ($faker) {
            $items = collect([]);
            $count = $faker->numberBetween(3, 5);
            for ($i = 0; $i < $count; $i++) {
                $items->push(\App\Models\Media::create(
                    [
                        'mediable_id'    => $product->id,
                        'mediable_type'  => \App\Models\Product::class,
                        'original_path'  => 'avatars/avatar-female-test.jpg',
                        'thumbnail_path' => 'avatars/avatar-female-test.jpg',
                        'mime_type'      => 'image\jpeg',
                    ]
                ));
            };
            $product->albums()->saveMany($items);
        });
        $categories = \App\Models\ProductCategory::all();
        $categories->each(function (\App\Models\ProductCategory $cate) use ($faker) {
            $cate->coverImage()->create(
                [
                    'mediable_id'    => $cate->id,
                    'mediable_type'  => \App\Models\ProductCategory::class,
                    'original_path'  => 'avatars/avatar-female-test.jpg',
                    'thumbnail_path' => 'avatars/avatar-female-test.jpg',
                    'mime_type'      => 'image\jpeg',
                ]
            );
        });


        $users = User::all();
        $users->each(function (\App\User $user) use ($faker) {
            $user->avatar()->create(
                [
                    'mediable_id'    => $user->id,
                    'mediable_type'  => \App\User::class,
                    'original_path'  => 'avatars/avatar-female-test.jpg',
                    'thumbnail_path' => 'avatars/avatar-female-test.jpg',
                    'mime_type'      => 'image\jpeg',
                ]
            );
        });
    }
}

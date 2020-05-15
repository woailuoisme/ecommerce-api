<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ($this->command->confirm('Do you want to fresh the database?', true)) {
            $this->command->call('migrate:fresh');
            $this->command->info('Database was freshed');
        }
        $this->call([
            ProductSkuAttributesTableSeeder::class,
            UsersTableSeeder::class,
            ProfileTableSeeder::class,
            ProductCategoriesTableSeeder::class,
            ProductsTablesTableSeeder::class,

            MediasTableSeeder::class,

            ProductSkuTableSeeder::class,
            ProductReviewsTableSeeder::class,
            ProductCouponsTableSeeder::class,
            AddressesTableSeeder::class,
            OrdersTableSeeder::class,
            CartProductTableSeeder::class,
            OrderProductTableSeeder::class,
            UserFavoriteProductTableSeeder::class,
            UserLikeCommentsSeeder::class,
        ]);

    }
}

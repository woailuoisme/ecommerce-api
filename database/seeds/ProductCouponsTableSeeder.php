<?php

use Illuminate\Database\Seeder;

class ProductCouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = max((int)$this->command->ask('How many product coupons would you like?', 20), 1);
        factory(\App\Models\ProductCoupon::class, $count)->create();
    }
}

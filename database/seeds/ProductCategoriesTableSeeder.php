<?php

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create(config('app.faker_locale'));
        $names = collect(['Science', 'Sport', 'Politics', 'Entartainment', 'Economy']);
        $names->each(function ($name) use ($faker) {
            $category = factory(ProductCategory::class)->make();
            $category->name = $name;
            $category->save();
        });

        $this->command->info("ProductCategoriesTableSeeder seeding completed successfully");
    }
}

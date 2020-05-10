<?php

use Illuminate\Database\Seeder;

class ProductSkuAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = \App\Models\SkuKey::all()->count();
        if ($count > 0) {
            return;
        }
        $sku_options = collect([
            [
                'name'   => '屏幕尺寸',
                'key'    => 'size',
                'values' => ['5.0', '6.0', '5.8'],
            ],
            [
                'name'   => '颜色',
                'key'    => 'color',
                'values' => ['黑色', '白色'],
            ],
            [
                'name'   => '内存大小',
                'key'    => 'memory',
                'values' => ['2g', '4g', '6g'],
            ],
        ]);
//        echo json_encode($sku_options,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT );
//        echo \App\Helpers\Util::json_encode($sku_options);
//        dd(json_encode($sku_options,JSON_UNESCAPED_UNICODE));
        $sku_options->each(function ($skuKey) {
            \Illuminate\Support\Facades\DB::transaction(function () use ($skuKey) {
//                dd($skuKey,$skuKey['values']);
                $sku_attr = \App\Models\SkuKey::create([
                    'name' => $skuKey['name'],
                    'key'  => $skuKey['key'],
                ]);
                $sku_attr->skuValues()->delete();
                $sku_attr->skuValues()->saveMany(collect($skuKey['values'])->map(function ($value) {
                    return new \App\Models\SkuValue(['value' => $value]);
                }));
            });

        });

        $this->command->info("ProductSkuAttributesTableSeeder seeding completed successfully");


    }
}

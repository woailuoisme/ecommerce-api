<?php


namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProductSkuKeyResourece;
use App\Models\SkuKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductSkuKeyController extends AppBaseController
{

    public function index()
    {
        $sku_keys = SkuKey::with('skuValues')->all();
        if (!$sku_keys) {
            return $this->sendSuccess('No Data at server');
        }

        return $this->sendData(ProductSkuKeyResourece::collection($sku_keys));
    }

    public function store(Request $request)
    {
        $validate_data = $request->validate([
            'name'    => ['required', 'exists:product_sku_attributes_key'],
            'en_name' => ['required', 'exists:product_sku_attributes_key'],
            'values'  => ['required', 'array'],
        ]);
        $result = DB::transaction(function () use ($validate_data) {
            /** @var SkuKey $sku_key */
            $sku_key = SkuKey::where('name', $validate_data['name'])
                ->Where('en_name', $validate_data['en_name'])->first();
            if (!$sku_key) {
                $sku_key = SkuKey::create([
                    'name'    => $validate_data['name'],
                    'en_name' => $validate_data['en_name'],
                ]);
            }
            $sku_values_changes = $sku_key->skuValues()->sync($validate_data['values']);

            return [
//                'sku_key'          => new ProductSkuKeyResourece($sku_key->fresh('skuValues')),
                'sku_key'          => $sku_key,
                'sku_value_change' => $sku_values_changes,
            ];
        });

        return $this->sendData($result);
    }

    public function destory(SkuKey $skuKey)
    {
        $skuKey->delete();
        $skuKey->skuValues()->delete();

        return $this->sendSuccess('sku_attr delete successfully');
    }

}

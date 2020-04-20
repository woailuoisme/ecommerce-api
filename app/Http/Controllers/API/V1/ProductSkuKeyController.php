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

        return $this->sendResponseWithoutMsg(ProductSkuKeyResourece::collection($sku_keys));
    }

    public function store(Request $request)
    {
        $validate_data = $request->validate([
            'name'   => ['required'],
            'sort'   => ['integer'],
            'values' => ['required', 'array'],
        ]);
        $result = DB::transaction(function () use ($validate_data) {
            /** @var SkuKey $sku_key */
            $sku_key = SkuKey::where('name', $validate_data['name'])->first();
//            dd($sku_key->toJson());
            if (!$sku_key) {
                $sku_key = SkuKey::create([
                    'name' => $validate_data['key'],
                    'sort' => $validate_data['sort'] || 0,
                ]);
            }
            if (isset($validate_data['sort']) && $sku_key !== $validate_data['sort']) {
                $sku_key->sort = $validate_data['sort'];
                $sku_key->save();
            }
            $sku_values_changes = $sku_key->syncSkuValues($validate_data['values']);

            return [
                'sku_key'          => new ProductSkuKeyResourece($sku_key->fresh(['skuValues'])),
                'sku_value_change' => $sku_values_changes,
            ];
        });

        return $this->sendResponseWithoutMsg($result);
    }


}

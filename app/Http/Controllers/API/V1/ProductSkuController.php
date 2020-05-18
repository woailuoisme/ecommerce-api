<?php


namespace App\Http\Controllers\API\V1;


use App\Helpers\Util;
use App\Http\Controllers\AppBaseController;
use App\Models\Product;
use App\Models\ProductSku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductSkuController extends AppBaseController
{

    public function index(Product $product, Request $request)
    {
        $skus = $product->skus;

        return $this->sendData($skus);
    }

    public function generateSku(Product $product, Request $request)
    {
        $validateData = $request->validate([
            'stock' => ['required'],
            'price' => ['required'],
        ]);
        if ($product->attribute_list) {
            $product_sku_list = $this->generateSkuModel($product->attribute_list, $product, $validateData);
            DB::transaction(function () use ($product_sku_list, $product) {
                $product->skus()->delete();
                $product->skus()->saveMany($product_sku_list);
            });
        }

        return $this->sendData($product->skus);
    }

    public function udpate(Product $product, Request $request)
    {
        $validateData = $request->validate([
            'sku'   => ['required'],
            'stock' => ['required'],
            'price‘=>'['required'],
        ]);
        /** @var ProductSku $product_sku */
        $product_sku = $product->skus()->where('sku', $validateData['sku'])->first();
        $product_sku->stock = $validateData['stock'];
        $product_sku->price = $validateData['price'];
        $product_sku->save();

        return $this->sendResponse($product_sku->fresh(), 'data updated successfully');
    }

    public function destroy(Product $product, Request $request)
    {
        $validateData = $request->validate([
            'sku' => ['required'],
        ]);
        $product_sku = $product->skus()->where('sku', $validateData['sku'])->first();
        if (!$product_sku) {
            return $this->sendError('Sku Attribute Key not exists');
        }
        $product_sku->delete();

        return $this->sendSuccess('Sku Attribute Key deleted successfully');
    }


    private function generateSkuModel(string $sku_all_json, Product $product, array $append_data)
    {

        $sku_array = Util::json_decode($sku_all_json);
        $result = collect($sku_array)->mapWithKeys(function ($op) {
            return [$op['key'] => $op['values']];
        });
        $re = Util::cartesian($result->toArray());

        return collect($re)->map(function ($r) use ($product, $append_data) {
            return $product->skus()->make([
                'sku_json' => Util::json_encode($r),
                'sku_str'  => $product->id.'-'.implode('-', array_values($r)),
                'stock'    => $append_data['stock'],
                'price'    => $append_data['price'],
            ]);
        });
    }

}

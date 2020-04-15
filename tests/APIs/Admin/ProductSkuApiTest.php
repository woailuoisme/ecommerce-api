<?php namespace Tests\APIs\Admin;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ProductSku;

class ProductSkuApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_product_sku()
    {
        $productSku = factory(ProductSku::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/product_skus', $productSku
        );

        $this->assertApiResponse($productSku);
    }

    /**
     * @test
     */
    public function test_read_product_sku()
    {
        $productSku = factory(ProductSku::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/product_skus/'.$productSku->id
        );

        $this->assertApiResponse($productSku->toArray());
    }

    /**
     * @test
     */
    public function test_update_product_sku()
    {
        $productSku = factory(ProductSku::class)->create();
        $editedProductSku = factory(ProductSku::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/product_skus/'.$productSku->id,
            $editedProductSku
        );

        $this->assertApiResponse($editedProductSku);
    }

    /**
     * @test
     */
    public function test_delete_product_sku()
    {
        $productSku = factory(ProductSku::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/product_skus/'.$productSku->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/product_skus/'.$productSku->id
        );

        $this->response->assertStatus(404);
    }
}

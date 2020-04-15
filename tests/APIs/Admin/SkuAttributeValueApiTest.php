<?php namespace Tests\APIs\Admin;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SkuAttributeValue;

class SkuAttributeValueApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_sku_attribute_value()
    {
        $skuAttributeValue = factory(SkuAttributeValue::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/sku_attribute_values', $skuAttributeValue
        );

        $this->assertApiResponse($skuAttributeValue);
    }

    /**
     * @test
     */
    public function test_read_sku_attribute_value()
    {
        $skuAttributeValue = factory(SkuAttributeValue::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/sku_attribute_values/'.$skuAttributeValue->id
        );

        $this->assertApiResponse($skuAttributeValue->toArray());
    }

    /**
     * @test
     */
    public function test_update_sku_attribute_value()
    {
        $skuAttributeValue = factory(SkuAttributeValue::class)->create();
        $editedSkuAttributeValue = factory(SkuAttributeValue::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/sku_attribute_values/'.$skuAttributeValue->id,
            $editedSkuAttributeValue
        );

        $this->assertApiResponse($editedSkuAttributeValue);
    }

    /**
     * @test
     */
    public function test_delete_sku_attribute_value()
    {
        $skuAttributeValue = factory(SkuAttributeValue::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/sku_attribute_values/'.$skuAttributeValue->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/sku_attribute_values/'.$skuAttributeValue->id
        );

        $this->response->assertStatus(404);
    }
}

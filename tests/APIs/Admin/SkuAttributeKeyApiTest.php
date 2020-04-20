<?php namespace Tests\APIs\Admin;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SkuKey;

class SkuAttributeKeyApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_sku_attribute_key()
    {
        $skuAttributeKey = factory(SkuKey::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/sku_attribute_keys', $skuAttributeKey
        );

        $this->assertApiResponse($skuAttributeKey);
    }

    /**
     * @test
     */
    public function test_read_sku_attribute_key()
    {
        $skuAttributeKey = factory(SkuKey::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/sku_attribute_keys/'.$skuAttributeKey->id
        );

        $this->assertApiResponse($skuAttributeKey->toArray());
    }

    /**
     * @test
     */
    public function test_update_sku_attribute_key()
    {
        $skuAttributeKey = factory(SkuKey::class)->create();
        $editedSkuAttributeKey = factory(SkuKey::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/sku_attribute_keys/'.$skuAttributeKey->id,
            $editedSkuAttributeKey
        );

        $this->assertApiResponse($editedSkuAttributeKey);
    }

    /**
     * @test
     */
    public function test_delete_sku_attribute_key()
    {
        $skuAttributeKey = factory(SkuKey::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/sku_attribute_keys/'.$skuAttributeKey->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/sku_attribute_keys/'.$skuAttributeKey->id
        );

        $this->response->assertStatus(404);
    }
}

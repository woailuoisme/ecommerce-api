<?php namespace Tests\APIs\Admin;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ProductCoupon;

class ProductCouponApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_product_coupon()
    {
        $productCoupon = factory(ProductCoupon::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/product_coupons', $productCoupon
        );

        $this->assertApiResponse($productCoupon);
    }

    /**
     * @test
     */
    public function test_read_product_coupon()
    {
        $productCoupon = factory(ProductCoupon::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/product_coupons/'.$productCoupon->id
        );

        $this->assertApiResponse($productCoupon->toArray());
    }

    /**
     * @test
     */
    public function test_update_product_coupon()
    {
        $productCoupon = factory(ProductCoupon::class)->create();
        $editedProductCoupon = factory(ProductCoupon::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/product_coupons/'.$productCoupon->id,
            $editedProductCoupon
        );

        $this->assertApiResponse($editedProductCoupon);
    }

    /**
     * @test
     */
    public function test_delete_product_coupon()
    {
        $productCoupon = factory(ProductCoupon::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/product_coupons/'.$productCoupon->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/product_coupons/'.$productCoupon->id
        );

        $this->response->assertStatus(404);
    }
}

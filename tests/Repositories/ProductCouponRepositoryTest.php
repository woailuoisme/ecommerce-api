<?php namespace Tests\Repositories;

use App\Models\ProductCoupon;
use App\Repositories\ProductCouponRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ProductCouponRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProductCouponRepository
     */
    protected $productCouponRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->productCouponRepo = \App::make(ProductCouponRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_product_coupon()
    {
        $productCoupon = factory(ProductCoupon::class)->make()->toArray();

        $createdProductCoupon = $this->productCouponRepo->create($productCoupon);

        $createdProductCoupon = $createdProductCoupon->toArray();
        $this->assertArrayHasKey('id', $createdProductCoupon);
        $this->assertNotNull($createdProductCoupon['id'], 'Created ProductCoupon must have id specified');
        $this->assertNotNull(ProductCoupon::find($createdProductCoupon['id']), 'ProductCoupon with given id must be in DB');
        $this->assertModelData($productCoupon, $createdProductCoupon);
    }

    /**
     * @test read
     */
    public function test_read_product_coupon()
    {
        $productCoupon = factory(ProductCoupon::class)->create();

        $dbProductCoupon = $this->productCouponRepo->find($productCoupon->id);

        $dbProductCoupon = $dbProductCoupon->toArray();
        $this->assertModelData($productCoupon->toArray(), $dbProductCoupon);
    }

    /**
     * @test update
     */
    public function test_update_product_coupon()
    {
        $productCoupon = factory(ProductCoupon::class)->create();
        $fakeProductCoupon = factory(ProductCoupon::class)->make()->toArray();

        $updatedProductCoupon = $this->productCouponRepo->update($fakeProductCoupon, $productCoupon->id);

        $this->assertModelData($fakeProductCoupon, $updatedProductCoupon->toArray());
        $dbProductCoupon = $this->productCouponRepo->find($productCoupon->id);
        $this->assertModelData($fakeProductCoupon, $dbProductCoupon->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_product_coupon()
    {
        $productCoupon = factory(ProductCoupon::class)->create();

        $resp = $this->productCouponRepo->delete($productCoupon->id);

        $this->assertTrue($resp);
        $this->assertNull(ProductCoupon::find($productCoupon->id), 'ProductCoupon should not exist in DB');
    }
}

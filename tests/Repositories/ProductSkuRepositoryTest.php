<?php namespace Tests\Repositories;

use App\Models\ProductSku;
use App\Repositories\ProductSkuRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ProductSkuRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProductSkuRepository
     */
    protected $productSkuRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->productSkuRepo = \App::make(ProductSkuRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_product_sku()
    {
        $productSku = factory(ProductSku::class)->make()->toArray();

        $createdProductSku = $this->productSkuRepo->create($productSku);

        $createdProductSku = $createdProductSku->toArray();
        $this->assertArrayHasKey('id', $createdProductSku);
        $this->assertNotNull($createdProductSku['id'], 'Created ProductSku must have id specified');
        $this->assertNotNull(ProductSku::find($createdProductSku['id']), 'ProductSku with given id must be in DB');
        $this->assertModelData($productSku, $createdProductSku);
    }

    /**
     * @test read
     */
    public function test_read_product_sku()
    {
        $productSku = factory(ProductSku::class)->create();

        $dbProductSku = $this->productSkuRepo->find($productSku->id);

        $dbProductSku = $dbProductSku->toArray();
        $this->assertModelData($productSku->toArray(), $dbProductSku);
    }

    /**
     * @test update
     */
    public function test_update_product_sku()
    {
        $productSku = factory(ProductSku::class)->create();
        $fakeProductSku = factory(ProductSku::class)->make()->toArray();

        $updatedProductSku = $this->productSkuRepo->update($fakeProductSku, $productSku->id);

        $this->assertModelData($fakeProductSku, $updatedProductSku->toArray());
        $dbProductSku = $this->productSkuRepo->find($productSku->id);
        $this->assertModelData($fakeProductSku, $dbProductSku->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_product_sku()
    {
        $productSku = factory(ProductSku::class)->create();

        $resp = $this->productSkuRepo->delete($productSku->id);

        $this->assertTrue($resp);
        $this->assertNull(ProductSku::find($productSku->id), 'ProductSku should not exist in DB');
    }
}

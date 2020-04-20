<?php namespace Tests\Repositories;

use App\Models\SkuValue;
use App\Repositories\SkuAttributeValueRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SkuAttributeValueRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SkuAttributeValueRepository
     */
    protected $skuAttributeValueRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->skuAttributeValueRepo = \App::make(SkuAttributeValueRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_sku_attribute_value()
    {
        $skuAttributeValue = factory(SkuValue::class)->make()->toArray();

        $createdSkuAttributeValue = $this->skuAttributeValueRepo->create($skuAttributeValue);

        $createdSkuAttributeValue = $createdSkuAttributeValue->toArray();
        $this->assertArrayHasKey('id', $createdSkuAttributeValue);
        $this->assertNotNull($createdSkuAttributeValue['id'], 'Created SkuAttributeValue must have id specified');
        $this->assertNotNull(SkuValue::find($createdSkuAttributeValue['id']),
            'SkuAttributeValue with given id must be in DB');
        $this->assertModelData($skuAttributeValue, $createdSkuAttributeValue);
    }

    /**
     * @test read
     */
    public function test_read_sku_attribute_value()
    {
        $skuAttributeValue = factory(SkuValue::class)->create();

        $dbSkuAttributeValue = $this->skuAttributeValueRepo->find($skuAttributeValue->id);

        $dbSkuAttributeValue = $dbSkuAttributeValue->toArray();
        $this->assertModelData($skuAttributeValue->toArray(), $dbSkuAttributeValue);
    }

    /**
     * @test update
     */
    public function test_update_sku_attribute_value()
    {
        $skuAttributeValue = factory(SkuValue::class)->create();
        $fakeSkuAttributeValue = factory(SkuValue::class)->make()->toArray();

        $updatedSkuAttributeValue = $this->skuAttributeValueRepo->update($fakeSkuAttributeValue, $skuAttributeValue->id);

        $this->assertModelData($fakeSkuAttributeValue, $updatedSkuAttributeValue->toArray());
        $dbSkuAttributeValue = $this->skuAttributeValueRepo->find($skuAttributeValue->id);
        $this->assertModelData($fakeSkuAttributeValue, $dbSkuAttributeValue->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_sku_attribute_value()
    {
        $skuAttributeValue = factory(SkuValue::class)->create();

        $resp = $this->skuAttributeValueRepo->delete($skuAttributeValue->id);

        $this->assertTrue($resp);
        $this->assertNull(SkuValue::find($skuAttributeValue->id), 'SkuAttributeValue should not exist in DB');
    }
}

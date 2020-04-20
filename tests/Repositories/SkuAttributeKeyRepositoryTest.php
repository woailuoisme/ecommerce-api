<?php namespace Tests\Repositories;

use App\Models\SkuKey;
use App\Repositories\SkuAttributeKeyRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SkuAttributeKeyRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SkuAttributeKeyRepository
     */
    protected $skuAttributeKeyRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->skuAttributeKeyRepo = \App::make(SkuAttributeKeyRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_sku_attribute_key()
    {
        $skuAttributeKey = factory(SkuKey::class)->make()->toArray();

        $createdSkuAttributeKey = $this->skuAttributeKeyRepo->create($skuAttributeKey);

        $createdSkuAttributeKey = $createdSkuAttributeKey->toArray();
        $this->assertArrayHasKey('id', $createdSkuAttributeKey);
        $this->assertNotNull($createdSkuAttributeKey['id'], 'Created SkuAttributeKey must have id specified');
        $this->assertNotNull(SkuKey::find($createdSkuAttributeKey['id']),
            'SkuAttributeKey with given id must be in DB');
        $this->assertModelData($skuAttributeKey, $createdSkuAttributeKey);
    }

    /**
     * @test read
     */
    public function test_read_sku_attribute_key()
    {
        $skuAttributeKey = factory(SkuKey::class)->create();

        $dbSkuAttributeKey = $this->skuAttributeKeyRepo->find($skuAttributeKey->id);

        $dbSkuAttributeKey = $dbSkuAttributeKey->toArray();
        $this->assertModelData($skuAttributeKey->toArray(), $dbSkuAttributeKey);
    }

    /**
     * @test update
     */
    public function test_update_sku_attribute_key()
    {
        $skuAttributeKey = factory(SkuKey::class)->create();
        $fakeSkuAttributeKey = factory(SkuKey::class)->make()->toArray();

        $updatedSkuAttributeKey = $this->skuAttributeKeyRepo->update($fakeSkuAttributeKey, $skuAttributeKey->id);

        $this->assertModelData($fakeSkuAttributeKey, $updatedSkuAttributeKey->toArray());
        $dbSkuAttributeKey = $this->skuAttributeKeyRepo->find($skuAttributeKey->id);
        $this->assertModelData($fakeSkuAttributeKey, $dbSkuAttributeKey->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_sku_attribute_key()
    {
        $skuAttributeKey = factory(SkuKey::class)->create();

        $resp = $this->skuAttributeKeyRepo->delete($skuAttributeKey->id);

        $this->assertTrue($resp);
        $this->assertNull(SkuKey::find($skuAttributeKey->id), 'SkuAttributeKey should not exist in DB');
    }
}

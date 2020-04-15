<?php namespace Tests\Repositories;

use App\Models\ProductReview;
use App\Repositories\ProductReviewRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ProductReviewRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ProductReviewRepository
     */
    protected $productReviewRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->productReviewRepo = \App::make(ProductReviewRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_product_review()
    {
        $productReview = factory(ProductReview::class)->make()->toArray();

        $createdProductReview = $this->productReviewRepo->create($productReview);

        $createdProductReview = $createdProductReview->toArray();
        $this->assertArrayHasKey('id', $createdProductReview);
        $this->assertNotNull($createdProductReview['id'], 'Created ProductReview must have id specified');
        $this->assertNotNull(ProductReview::find($createdProductReview['id']), 'ProductReview with given id must be in DB');
        $this->assertModelData($productReview, $createdProductReview);
    }

    /**
     * @test read
     */
    public function test_read_product_review()
    {
        $productReview = factory(ProductReview::class)->create();

        $dbProductReview = $this->productReviewRepo->find($productReview->id);

        $dbProductReview = $dbProductReview->toArray();
        $this->assertModelData($productReview->toArray(), $dbProductReview);
    }

    /**
     * @test update
     */
    public function test_update_product_review()
    {
        $productReview = factory(ProductReview::class)->create();
        $fakeProductReview = factory(ProductReview::class)->make()->toArray();

        $updatedProductReview = $this->productReviewRepo->update($fakeProductReview, $productReview->id);

        $this->assertModelData($fakeProductReview, $updatedProductReview->toArray());
        $dbProductReview = $this->productReviewRepo->find($productReview->id);
        $this->assertModelData($fakeProductReview, $dbProductReview->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_product_review()
    {
        $productReview = factory(ProductReview::class)->create();

        $resp = $this->productReviewRepo->delete($productReview->id);

        $this->assertTrue($resp);
        $this->assertNull(ProductReview::find($productReview->id), 'ProductReview should not exist in DB');
    }
}

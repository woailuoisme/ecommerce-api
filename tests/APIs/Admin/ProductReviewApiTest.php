<?php namespace Tests\APIs\Admin;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ProductReview;

class ProductReviewApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_product_review()
    {
        $productReview = factory(ProductReview::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/product_reviews', $productReview
        );

        $this->assertApiResponse($productReview);
    }

    /**
     * @test
     */
    public function test_read_product_review()
    {
        $productReview = factory(ProductReview::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/product_reviews/'.$productReview->id
        );

        $this->assertApiResponse($productReview->toArray());
    }

    /**
     * @test
     */
    public function test_update_product_review()
    {
        $productReview = factory(ProductReview::class)->create();
        $editedProductReview = factory(ProductReview::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/product_reviews/'.$productReview->id,
            $editedProductReview
        );

        $this->assertApiResponse($editedProductReview);
    }

    /**
     * @test
     */
    public function test_delete_product_review()
    {
        $productReview = factory(ProductReview::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/product_reviews/'.$productReview->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/product_reviews/'.$productReview->id
        );

        $this->response->assertStatus(404);
    }
}

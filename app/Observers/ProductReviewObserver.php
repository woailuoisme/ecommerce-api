<?php

namespace App\Observers;

use App\ProductReview;

class ProductReviewObserver
{
    /**
     * Handle the product review "created" event.
     *
     * @param  \App\ProductReview  $productReview
     * @return void
     */
    public function created(ProductReview $productReview)
    {
        //
    }

    /**
     * Handle the product review "updated" event.
     *
     * @param  \App\ProductReview  $productReview
     * @return void
     */
    public function updated(ProductReview $productReview)
    {
        //
    }

    /**
     * Handle the product review "deleted" event.
     *
     * @param  \App\ProductReview  $productReview
     * @return void
     */
    public function deleted(ProductReview $productReview)
    {
        //
    }

    /**
     * Handle the product review "restored" event.
     *
     * @param  \App\ProductReview  $productReview
     * @return void
     */
    public function restored(ProductReview $productReview)
    {
        //
    }

    /**
     * Handle the product review "force deleted" event.
     *
     * @param  \App\ProductReview  $productReview
     * @return void
     */
    public function forceDeleted(ProductReview $productReview)
    {
        //
    }
}

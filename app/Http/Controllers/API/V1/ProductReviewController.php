<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\AppBaseController;
use App\Models\Product;
use App\User;
use Illuminate\Http\Request;

class ProductReviewController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Product $product, Request $request)
    {
        $validateData = $request->validate([
            'content' => ['required'],
            'rating'  => ['rating', 'integer', 'min:0', 'max:5'],
        ]);
        /** @var User $user */
        $user = auth('auth:api')->user();
        $validateData['user_id'] = $user->id;
        $review = $product->reviews()->create($validateData);

        return $this->sendData($review, 201);
    }

}
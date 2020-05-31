<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\AppBaseController;
use App\Models\Product;
use App\Models\ProductReview;
use App\Notifications\ReivewCreatedNotify;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductReviewController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    private function index(Product $product, Request $request){
        return $this->sendResponse($product->reviews);
    }

    public function show(ProductReview $review, Request $request){
        return $this->sendResponse($review);
    }

    public function store( Request $request)
    {
        $validateData = $request->validate([
            'product_id'=>['required'],
            'content' => ['required'],
            'rating'  => ['required', 'integer', Rule::in([0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5])],
        ]);
        /** @var User $user */
        $user = auth('api')->user();
        $validateData['user_id'] = $user->id;

        $review = ProductReview::create($validateData);
        $user->notify(new ReivewCreatedNotify($review));
//        Notification::send($users, new InvoicePaid($invoice));
        return $this->sendData($review, 201);
    }


    public function update(ProductReview $review, Request $request){
        $validateData = $request->validate([
            'content' => ['required'],
            'rating'  => ['required', 'integer', Rule::in([0,0.5,1,1.5,2,2.5,3,3.5,4,4.5,5])],
        ]);
        $re=$review->update($validateData);
        return $this->sendResponse($re);
    }

    public function destory(ProductReview $review){
        $review->delete();
        return $this->sendSuccess('deleted successfully');
    }

}
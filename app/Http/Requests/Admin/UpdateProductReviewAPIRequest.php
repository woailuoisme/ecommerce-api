<?php

namespace App\Http\Requests\Admin;

use App\Models\ProductReview;
use InfyOm\Generator\Request\APIRequest;

class UpdateProductReviewAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = ProductReview::$rules;
        
        return $rules;
    }
}

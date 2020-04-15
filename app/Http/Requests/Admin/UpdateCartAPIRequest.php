<?php

namespace App\Http\Requests\Admin;

use App\Models\Cart;
use InfyOm\Generator\Request\APIRequest;

class UpdateCartAPIRequest extends APIRequest
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
        $rules = Cart::$rules;
        
        return $rules;
    }
}

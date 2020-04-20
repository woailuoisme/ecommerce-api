<?php

namespace App\Http\Requests\Admin;

use App\Models\SkuKey;
use InfyOm\Generator\Request\APIRequest;

class UpdateSkuAttributeKeyAPIRequest extends APIRequest
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
        $rules = SkuKey::$rules;

        return $rules;
    }
}

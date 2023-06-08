<?php

namespace App\project\Product\Requests;

use App\Http\Requests\ApiRequest;

class ProdUpdate extends ApiRequest
{
    //take subsubcategory_id   prod_name  prod_image --- color as string , units as string
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'prod_name' =>  'nullable|string|max:255' ,
            'prod_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'state'=>'nullable|numeric'
         ];
    }

}

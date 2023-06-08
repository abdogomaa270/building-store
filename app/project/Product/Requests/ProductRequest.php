<?php

namespace App\project\Product\Requests;

use App\Http\Requests\ApiRequest;

class ProductRequest extends ApiRequest
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
            'subsubcategory_id'=>'numeric|exists:subsubcategories,id',
            'name_en' =>  'required|string|max:255' ,
            'name_ch' =>  'required|string|max:255' ,
            'name_ru' =>  'required|string|max:255' ,
            'Desc_en'=>    'required|string|max:255',
            'Desc_ch'=>    'required|string|max:255',
            'Desc_ru'=>    'required|string|max:255',
            'image1' => 'required|image|mimes:jpeg,png,jpg,gif',
            'image2' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'image3' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'image4' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'colors_en' => 'required|string|max:255',
            'colors_ch' => 'required|string|max:255',
            'colors_ru' => 'required|string|max:255',
            'units' => 'required|string|max:255'
        ];
    }


}

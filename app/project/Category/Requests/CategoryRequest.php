<?php

namespace App\project\Category\Requests;

use App\Http\Requests\ApiRequest;

class CategoryRequest extends ApiRequest
{
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
            'name_en' => 'required|string|min:3|max:30',
            'name_ch' => 'required|string|min:3|max:30',
            'name_ru' => 'required|string|min:3|max:30',
            'image' => 'required|image',
        ];
    }


}







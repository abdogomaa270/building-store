<?php

namespace App\project\SubSubCateg\Requests;

use App\Http\Requests\ApiRequest;

class SubSubRequest extends ApiRequest
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
            'subcategory_id' => 'required|numeric|exists:subcategories,id',
            'name_en' => 'required|string',
            'name_ch' => 'required|string',
            'name_ru' => 'required|string',
        ];
    }
}

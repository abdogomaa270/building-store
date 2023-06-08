<?php

namespace App\project\Category\Requests;

use App\Http\Requests\ApiRequest;

class CategUpdateRequest extends ApiRequest
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
            'name_en' => 'nullable|string|min:3|max:30',
            'name_ch' => 'nullable|string|min:3|max:30',
            'name_ru' => 'nullable|string|min:3|max:30',
            'image' => 'nullable|image',
        ];
    }
}

<?php

namespace App\project\SubCateg\Requests;

use App\Http\Requests\ApiRequest;

class SubUpdate extends ApiRequest
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
            'name_en' => 'nullable|string',
            'name_ch' => 'nullable|string',
            'name_ru' => 'nullable|string',
        ];
    }
}

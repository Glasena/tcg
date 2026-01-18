<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListCardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tcg_type_id' => ['nullable', 'integer', 'exists:tcg_types,id'],
            'name' => ['nullable', 'string'],
            'tcg_custom_id' => ['nullable', 'string'],
            'id' => ['nullable', 'integer'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'tcg_set_type_id' => 'nullable|exists:tcg_set_types,id',
            'code' => 'nullable|string',
        ];
    }
}

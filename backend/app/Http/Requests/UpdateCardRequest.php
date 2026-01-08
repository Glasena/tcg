<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tcg_type_id' => ['nullable', 'integer', 'exists:tcg_types,id'],
            'name' => ['nullable', 'string'],
            'tcg_custom_id' => ['nullable', 'string'],
            'id' => ['nullable', 'integer'],
        ];
    }
}

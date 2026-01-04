<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tcg_type_id' => ['required', 'integer', 'exists:tcg_types,id'],
            'tcg_custom_id' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}

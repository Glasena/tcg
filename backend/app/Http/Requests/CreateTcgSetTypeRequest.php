<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTcgSetTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tcg_type_id' => ['required', 'integer', 'exists:tcg_types,id'],
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255'],
        ];
    }
}

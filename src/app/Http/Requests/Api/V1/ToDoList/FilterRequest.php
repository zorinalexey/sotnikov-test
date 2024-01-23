<?php

namespace App\Http\Requests\Api\V1\ToDoList;

use Illuminate\Foundation\Http\FormRequest;

final class FilterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|nullable',
            'desc' => 'string|nullable',
            'sort' => 'array|nullable',
            'sort.id' => 'string|nullable',
            'sort.name' => 'string|nullable',
            'sort.desc' => 'string|nullable',
            'sort.updated_at' => 'string|nullable',
            'sort.created_at' => 'string|nullable',
        ];
    }
}

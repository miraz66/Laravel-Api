<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ReplaceTicketRequest extends FormRequest
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
        $roles = [
            'data.attributes.title' => ['required', 'string', 'max:255'],
            'data.attributes.description' => ['required', 'string'],
            'data.attributes.status' => ['required', 'string', 'in:active,closed'],
            'data.relationships.author.data.id' => ['required', 'integer', 'exists:users,id'],
        ];

        return $roles;
    }

    public function messages(): array
    {
        return [
            'data.attributes.title.required' => 'Title is required',
            'data.attributes.description.required' => 'Description is required',
            'data.attributes.status.required' => 'Status is required',
            'data.relationships.author.data.id.required' => 'Author is required',
            'data.relationships.author.data.id.exists' => 'Author does not exist',
        ];
    }
}

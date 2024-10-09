<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends BaseTicketRequest
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
            'data.attributes.title' => ['sometimes', 'string', 'max:255'],
            'data.attributes.description' => ['sometimes', 'string'],
            'data.attributes.status' => ['sometimes', 'string', 'in:active,closed'],
            'data.relationships.author.data.id' => ['sometimes', 'integer', 'exists:users,id'],
        ];

        return $roles;
    }
}

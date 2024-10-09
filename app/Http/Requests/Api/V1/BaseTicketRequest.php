<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BaseTicketRequest extends FormRequest
{
    public function mappedAttributes()
    {
        $attributesMap = [
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
            'data.attributes.status' => 'status',
            'data.attributes.createdAt' => 'created_at',
            'data.attributes.updatedAt' => 'updated_at',
            'data.relationships.author.data.id' => 'author_id',
        ];

        $attributesToUpdate = [];
        foreach ($attributesMap as $key => $value) {
            // if (array_key_exists($key, $this->all())) {
            //     $attributesToUpdate[$value] = $this->get($key);
            // }

            if ($this->has($key)) {
                $attributesToUpdate[$value] = $this->input($key);
            }
        }

        return $attributesToUpdate;
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

<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAuthor();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }
}

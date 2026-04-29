<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return Auth::check(); закомменчено т.к. эта проверка у нас уже в посрднике auth в роутах
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'string', 'min:2', 'max:2000'],
            'parent_id' => ['nullable', 'integer', 'exists:comments,id'],
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Напишите хотя бы пару слов в комментарии.',
            'content.max' => 'Комментарий слишком длинный (макс. 2000 симв.).',
            'parent_id.exists' => 'Вы пытаетесь ответить на несуществующий комментарий.',
        ];
    }
}

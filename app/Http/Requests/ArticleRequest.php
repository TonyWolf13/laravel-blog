<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'sometimes|required',
            'content' => 'sometimes|required',
            'thumbnail' => 'sometimes|nullable',
            'banner' => 'sometimes|nullable',
            'publish_at' => 'sometimes|nullable|date',
        ];
    }
}

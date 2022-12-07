<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    // public function attributes()
    // {
    //     return [
    //         'slug' => 'url address',
    //     ];
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'content' => 'string|nullable',
            'image' => 'image|nullable',
            'slug' => 'required|string|min:3|max:255|unique:posts,slug,' . $this->post->id
        ];
    }
}

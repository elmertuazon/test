<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
             'title' => ['required', 'min:5', 'max:255'],
             'slug' => ['required', Rule::unique('posts', 'slug')],
             'introduction' => ['required', 'min:5', 'max:255'],
             'body' => ['required', 'min:5'],
             'category_id' => ['required', 'exists:categories,id'],
             'image' => ['image', 'bail', 'mimes:jpeg,png,jpg,gif,svg,webp', 'dimensions:min_width=100,max_width=1000,min_height=100,max_height=1000']
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}

<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class StoreRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => str($this->title)->slug()
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->expectsJson()) {
            $response = new Response($validator->errors(), 422);
            throw new ValidationException($validator, $response);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "title" => "required|min:5|max:500",
            "slug" => "required|min:5|max:500|unique:posts,slug",
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGalleryRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
            'title' => 'sometimes|required|string|min:2|max:255',
            'description' => 'sometimes|max:1000',
            'images_url' => 'sometimes|array',
            'images_url.*' => 'sometimes|string|distinct|ends_with:jpg,jpeg,png',
        ];
    }
}

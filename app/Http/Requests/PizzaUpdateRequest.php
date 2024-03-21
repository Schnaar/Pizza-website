<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PizzaUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //1. set the authorization to true
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
            'pizza_name' => 'required|string|min:3|max:40',
            'pizza_desc'=> 'required|min:3|max:500',
            'pizza_large_price'=> 'required|numeric',
            'pizza_medium_price'=> 'required|numeric',
            'pizza_small_price'=> 'required|numeric',
            'pizza_category'=> 'required',
            //its ok to leave the image empty since its an update only
            //but if user uploaded image it has to be this type
            'pizza_image' => '|mimes:png,jpeg,jpg'
        ];
    }
}

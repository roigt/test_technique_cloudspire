<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
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
            'name' => ['required','string','max:255'],
            'address1'=>['required'],
            'address2'=>['required','nullable'],
            'zipcode'=>['string'],
            'city'=>['string'],
            'country'=>['string'],
            'lng'=>['numeric'],
            'lat'=>['numeric'],
            'description'=>['string','max:5000'],
            'max_capacity'=>['integer','max:200'],
            'price_per_night'=>['numeric'],
        ];
    }
}

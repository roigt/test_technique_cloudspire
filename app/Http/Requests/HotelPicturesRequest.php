<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelPicturesRequest extends FormRequest
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
//             'hotel_id' => ['required', 'exists:hotels,id'],
//             'filepath' => ['required', 'string', 'max:2048'],
//             'filesize' => ['required', 'integer', 'max:4096'],
             'position' => ['required', 'integer'],
        ];
    }
}

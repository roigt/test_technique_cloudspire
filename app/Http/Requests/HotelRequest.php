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

    /**
     * Messages de validation personnalisés
     */
    public function messages(): array
    {
        return [
            //name
            'name.required' => "Le nom de l'hôtel est obligatoire.",
            'name.string' => "Le nom doit être une chaîne de caractères.",
            'name.max' => "Le nom ne peut pas dépasser :max caractères.",

            //address1
            'address1.required' => "L'adresse de l'hôtel est obligatoire.",
            'address1.string' => "L'adresse doit être une chaîne de caractères.",

            //address2
            'address2.string' => "L'adresse complémentaire doit être une chaîne de caractères.",

            //zipcode
            'zipcode.required' => "Le code postal est obligatoire.",
            'zipcode.string' => "Le code postal doit être une chaîne de caractères.",
            'zipcode.max' => "Le code postal ne peut pas dépasser :max caractères.",

            //city
            'city.required' => "La ville est obligatoire.",
            'city.string' => "La ville doit être une chaîne de caractères.",
            'city.max' => "Le nom de la ville ne peut pas dépasser :max caractères.",

            //country
            'country.required' => "Le pays est obligatoire.",
            'country.string' => "Le pays doit être une chaîne de caractères.",
            'country.max' => "Le nom du pays ne peut pas dépasser :max caractères.",

            //longitude
            'lng.required' => "La longitude est obligatoire.",
            'lng.numeric' => "La longitude doit être un nombre.",
            'lng.between' => "La longitude doit être comprise entre -180 et 180.",

            //latitude
            'lat.required' => "La latitude est obligatoire.",
            'lat.numeric' => "La latitude doit être un nombre.",
            'lat.between' => "La latitude doit être comprise entre -90 et 90.",

            //description
            'description.required' => "La description est obligatoire.",
            'description.string' => "La description doit être une chaîne de caractères.",
            'description.min' => "La description doit contenir au moins :min caractères.",
            'description.max' => "La description ne peut pas dépasser :max caractères.",

            //max_capacity
            'max_capacity.required' => "La capacité maximale est obligatoire.",
            'max_capacity.integer' => "La capacité maximale doit être un nombre entier.",
            'max_capacity.min' => "La capacité minimale est de :min personne.",
            'max_capacity.max' => "La capacité maximale ne peut pas dépasser :max personnes.",

            //price_per_night
            'price_per_night.required' => "Le prix par nuit est obligatoire.",
            'price_per_night.numeric' => "Le prix par nuit doit être un nombre.",
            'price_per_night.min' => "Le prix par nuit doit être supérieur ou égal à :min.",

        ];
    }

}

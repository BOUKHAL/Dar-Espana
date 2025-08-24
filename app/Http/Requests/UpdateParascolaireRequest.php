<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParascolaireRequest extends FormRequest
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
            'nom_evenement' => 'required|string|max:255|min:3',
            'jour_evenement' => 'required|date',
            'lieu' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:1000'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nom_evenement.required' => 'Le nom de l\'événement est obligatoire.',
            'nom_evenement.min' => 'Le nom de l\'événement doit contenir au moins 3 caractères.',
            'nom_evenement.max' => 'Le nom de l\'événement ne peut pas dépasser 255 caractères.',
            'jour_evenement.required' => 'La date de l\'événement est obligatoire.',
            'jour_evenement.date' => 'La date de l\'événement doit être une date valide.',
            'lieu.required' => 'Le lieu est obligatoire.',
            'lieu.min' => 'Le lieu doit contenir au moins 3 caractères.',
            'lieu.max' => 'Le lieu ne peut pas dépasser 255 caractères.',
            'description.max' => 'La description ne peut pas dépasser 1000 caractères.'
        ];
    }
}

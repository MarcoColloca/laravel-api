<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            
            'name'=> 'required|max:200',
            'link'=> 'required|max:2000|url',
            'date_of_creation'=> 'required|date',
            'type'=> 'required|integer|numeric',
            'contributors'=> 'required|integer|numeric',
            'contributors_name'=> 'nullable|max:2000',
            'description'=> 'nullable|max:2000',
            'type_id' => 'nullable|numeric|integer|exists:types,id', // l'ultimo pipe controlla nella tabella types se esiste il valore passato come value nella colonna id
            'technologies' => 'exists:technologies,id',
            'cover_image' => 'nullable|image|max:10240'

        ];
    }
}

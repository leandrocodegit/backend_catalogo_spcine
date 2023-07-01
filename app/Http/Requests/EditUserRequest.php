<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nome' => 'bail|required',
            'email' => 'bail|required',
            'cpf' => 'bail|required',
            'empresa' => 'bail|required'
        ];
    
    }

    public function messages(): array
{
    return [
        'nome.required' => 'Nome é obrigatório!',
              'email.required' => 'Email é obrigatório!',
              'cpf.required' => 'Documento é obrigatório!',
              'empresa.required' => 'Empresa é obrigatório!', 
    ];
}
}

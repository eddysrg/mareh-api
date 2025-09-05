<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SimulatorRequest extends FormRequest
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
            'housing_value' => [
                'required',
                'numeric'
            ],
            'credit_amount' => [
                'required',
                'numeric'
            ],
            'credit_term' => [
                'required',
                'string'
            ],
            'full_name' => [
                'required',
                'string'
            ],
            'phone_number' => [
                'required',
                'numeric',
                'min_digits:10',
                'max_digits:10'
            ],
            'email' => [
                'required',
                'email'
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'housing_value' => 'Valor de la vivienda',
            'credit_amount' => 'Monto del crédito',
            'credit_term' => 'Plazo solicitado',
            'full_name' => 'Nombre completo',
            'phone_number' => 'Número de contacto',
            'email' => 'Email',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'full_name' => $this->sanitizeString($this->full_name)
        ]);
    }

    private function sanitizeString($value)
    {
        if (is_null($value)) return null;

        $value = strip_tags($value);

        $value = trim($value);

        $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

        return $value;
    }

    /**
     * Handle a failed validation attempt. 
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Datos invalidos.',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}

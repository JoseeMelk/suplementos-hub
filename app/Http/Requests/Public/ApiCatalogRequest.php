<?php

namespace App\Http\Requests\Public;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ApiCatalogRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'page'        => 'nullable|integer|min:1',
            'per_page'    => 'nullable|integer|min:1|max:15',
            'search'      => 'nullable|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'page.min' => 'La página debe ser un número entero positivo.',
            'per_page.max' => 'El máximo de registros por página es 15.',
            'per_page.min' => 'El mínimo de registros por página es 1.',
            'search.max' => 'La búsqueda no puede exceder los 255 caracteres.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
        ];
    }

    public function attributes(): array
    {
        return [
            'page' => 'página',
            'per_page' => 'registros por página',
            'search' => 'búsqueda',
            'category_id' => 'categoría',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'page' => $this->page ?? 1,
            'per_page' => $this->per_page ?? 15,
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'ok' => false,
            'message' => 'Error de validación.',
            'errors' => $validator->errors()
        ], 422));
    }
}

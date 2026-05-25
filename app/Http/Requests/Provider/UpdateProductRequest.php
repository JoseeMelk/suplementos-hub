<?php

namespace App\Http\Requests\Provider;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateProductRequest extends FormRequest
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
            'name' => 'nullable|max:150',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|max:700',
            'is_visible' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            'name.max'           => 'El nombre no puede superar 150 caracteres.',
            'category_id.nullable' => 'Selecciona una categoría.',
            'category_id.exists'   => 'La categoría seleccionada no existe.',
            'price.numeric'      => 'El precio debe ser un número.',
            'price.min'          => 'El precio no puede ser negativo.',
            'description.max'    => 'La descripción es muy larga, no puede superar 700 caracteres.',
            'image.image'        => 'El archivo debe ser una imagen.',
            'image.mimes'        => 'El archivo debe ser una imagen válida.',
            'image.max'          => 'La imagen no puede superar 1MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'description' => 'descripción',
            'category_id' => 'categoría',
            'price' => 'precio',
            'is_visible' => 'es visible',
            'image' => 'imagen',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_visible' => $this->boolean('is_visible', true),
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

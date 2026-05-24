<?php

namespace App\Http\Requests\Provider;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:1000'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand'       => ['nullable', 'string', 'max:100'],
            'price'       => ['nullable', 'numeric', 'min:0'],
            'weight_grams' => ['nullable', 'integer', 'min:1'],
            'flavor'      => ['nullable', 'string', 'max:100'],
            'serving_size' => ['nullable', 'string', 'max:50'],
            'is_visible'  => ['boolean'],

            // Imagen — una de las dos opciones es requerida
            //'image_url'   => ['nullable', 'url'],
            'image'       => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'El nombre del producto es obligatorio.',
            'name.max'           => 'El nombre no puede superar 150 caracteres.',
            'category_id.required' => 'Selecciona una categoría.',
            'category_id.exists'   => 'La categoría seleccionada no existe.',
            'price.numeric'      => 'El precio debe ser un número.',
            'price.min'          => 'El precio no puede ser negativo.',
            'weight_grams.integer'=> 'El peso debe ser un número entero.',
            'image.image'        => 'El archivo debe ser una imagen.',
            'image.max'          => 'La imagen no puede superar 1MB.',
            //'image_url.url'      => 'La URL de imagen no es válida.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'description' => 'descripción',
            'category_id' => 'categoría',
            'brand' => 'marca',
            'price' => 'precio',
            'weight_grams' => 'peso (gramos)',
            'flavor' => 'sabor',
            'serving_size' => 'tamaño de la ración',
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

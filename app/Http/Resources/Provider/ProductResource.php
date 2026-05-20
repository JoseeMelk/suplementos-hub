<?php

namespace App\Http\Resources\Provider;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            // Muestra el ID solo si la relación 'category' NO está cargada
            'category_id' => $this->when(!$this->relationLoaded('category'), $this->category_id),
            //Muestra el nombre de la categoria cuando se carga la relacion
            'category' => $this->when($this->relationLoaded('category'), $this->category->name),
            'is_visible' => $this->is_visible,
            'image_url' => $this->url_main_image,
        ];
    }
}

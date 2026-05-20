<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProviderSlugController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        try {
            $user = Auth::user();
            $baseSlug = null;
            
            // Generar slug desde el display_name con parámetros aleatorios
            if ($user->display_name) {
                $baseSlug = Str::slug($user->display_name);
                $randomPart = Str::random(8);
                $slug = $baseSlug . '-' . $randomPart;
            } else {
                // Si no existe display_name, generar solo parámetros aleatorios
                $slug = Str::random(12);
            }

            // Asegurar que el slug sea único
            while (User::where('slug', $slug)->where('id', '!=', $user->id)->exists()) {
                $randomPart = Str::random(8);
                if ($baseSlug) {
                    $slug = $baseSlug . '-' . $randomPart;
                } else {
                    $slug = Str::random(12);
                }
            }

            // Actualizar el slug del usuario
            User::where('id', $user->id)->update(['slug' => $slug]);

            return response()->json([
                'ok' => true,
                'message' => 'Catálogo generado exitosamente',
                'data' => [
                    'slug' => $slug,
                    'catalog_url' => url('/catalog/' . $slug)
                ]
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error al generar slug: ' . $e->getMessage());
            
            return response()->json([
                'ok' => false,
                'message' => 'Error al generar el catálogo.'
            ], 422);
        }
    }
}

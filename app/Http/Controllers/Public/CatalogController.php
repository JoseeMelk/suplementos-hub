<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\ApiCatalogRequest;
use App\Models\User;
use App\Models\Product;
use App\Http\Resources\Provider\ProductResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class CatalogController extends Controller
{
    /**
     * Mostrar la página del catálogo público de un proveedor
     */
    public function index(string $slug)
    {
        // Validar que el proveedor existe
        $user = User::where('slug', $slug)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'provider');
            })
            ->first();

        if (!$user) {
            abort(404, 'Catálogo no encontrado');
        }

        return view('public.catalog', [
            'slug' => $slug,
            'provider' => $user,
        ]);
    }

    /**
     * Obtener detalles de un producto del catálogo público
     */
    public function show(string $slug, Product $product): JsonResponse
    {
        try {
            // Validar que el proveedor existe y tiene este producto visible
            $user = User::where('slug', $slug)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'provider');
                })
                ->first();

            if (!$user) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Catálogo no encontrado.'
                ], 404);
            }

            // Validar que el producto pertenece al usuario y es visible
            if ($product->user_id !== $user->id || !$product->is_visible) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Producto no encontrado.'
                ], 404);
            }

            return response()->json([
                'ok' => true,
                'data' => new ProductResource($product->load('category')),
                'message' => 'Producto encontrado.'
            ]);
        } catch (\Throwable $e) {
            Log::error('Error en CatalogController@show', [
                'message' => $e->getMessage(),
                'slug' => $slug,
                'product_id' => $product->id,
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Error en la solicitud'
            ], 500);
        }
    }

    /**
     * Obtener productos públicos del catálogo de un proveedor
     */
    public function api(string $slug, ApiCatalogRequest $request): JsonResponse
    {
        try {
            // Buscar usuario por slug y validar que es proveedor con catálogo activo
            $user = User::where('slug', $slug)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'provider');
                })
                ->first();

            if (!$user) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Catálogo no encontrado.'
                ], 404);
            }

            // Construir query para obtener productos visibles del proveedor
            $query = Product::query()
                ->where('user_id', $user->id)
                ->where('is_visible', true)
                ->with('category');

            // 🔍 Buscador
            $query->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });

            // 📂 Categoría
            $query->when($request->category_id, function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });

            $products = $query
                ->latest()
                ->paginate($request->per_page);

            if (!$products->count()) {
                return response()->json([
                    'ok' => true,
                    'message' => 'No se encontraron productos.',
                    'meta' => [
                        'current_page' => $products->currentPage(),
                        'last_page'    => $products->lastPage(),
                        'per_page'     => $products->perPage(),
                        'total'        => $products->total(),
                    ],
                ]);
            }

            return response()->json([
                'ok' => true,
                'data' => ProductResource::collection($products),
                'message' => 'Productos encontrados.',
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'last_page'    => $products->lastPage(),
                    'per_page'     => $products->perPage(),
                    'total'        => $products->total(),
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Error en CatalogController@api', [
                'message' => $e->getMessage(),
                'slug' => $slug,
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Error en la solicitud'
            ], 500);
        }
    }
}

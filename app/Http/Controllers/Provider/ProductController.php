<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Http\Requests\Provider\ProductApiRequest;
use App\Http\Requests\Provider\StoreProductRequest;
use App\Http\Requests\Provider\UpdateProductRequest;
use App\Http\Resources\Provider\ProductResource;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function api(ProductApiRequest $request)
    {
        try {
            $products = Product::query()
                ->where('user_id', Auth::id())
                ->with('category') // evita N+1
                ->latest()
                //->paginate($request->per_page);
                ->get();

            return response()->json([
                'ok' => true,
                'data' => ProductResource::collection($products),
                // 'meta' => [
                //     'current_page' => $products->currentPage(),
                //     'last_page'    => $products->lastPage(),
                //     'per_page'     => $products->perPage(),
                //     'total'        => $products->total(),
                // ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Error en ProductController@api', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Error en la solicitud'
            ], 500);
        }
    }

    public function __construct(protected ImageService $imageService) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('provider.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $response   = ['ok' => false, 'message' => 'Error al crear el producto.'];
        $statusCode = 422;
        try {
            DB::beginTransaction();
            $product = Product::create([
                ...$request->safe()->except(['image', 'image_url']),
                'user_id'    => Auth::id(),
                'is_visible' => $request->boolean('is_visible', true),
            ]);

            if ($request->hasFile('image')) {
                $path = $this->imageService->processFromUpload($request->file('image'));
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'is_primary' => true,
                    'source' => 'upload',
                    'sort_order' => 0,

                ]);
            }
            DB::commit();
            $response = ['ok' => true, 'message' => 'Producto creado exitosamente.'];
            $statusCode = 201;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear el producto en Provider/ProductController: ' . $e->getMessage());
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'ok' => true,
            'data' => new ProductResource($product)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $response = ['ok' => false, 'message' => 'Error al actualizar el producto.'];
        $statusCode = 500;

        try {
            $data = collect($request->validated())->forget('image')
                ->filter(fn($value) => !is_null($value)) // Elimina los nulos
                ->toArray();
            DB::beginTransaction();
            $product->update($data);

            if ($request->hasFile('image')) {
                // 1. Buscamos la imagen primaria actual de este producto usando tu scope
                $existingImage = $product->images()->primary()->first();

                // 2. Procesamos la nueva imagen con tu servicio
                $path = $this->imageService->processFromUpload($request->file('image'));

                if ($path) {
                    // 3. Si ya tenía una, borramos el archivo físico del disco
                    if ($existingImage) {
                        $this->imageService->delete($existingImage->path);
                    }

                    // 4. Actualizamos el registro existente o creamos uno nuevo
                    // Usamos product_id e is_primary como clave de búsqueda
                    $product->images()->updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'is_primary' => true
                        ],
                        [
                            'path'       => $path,
                            'source'     => 'upload',
                            'sort_order' => 0
                        ]
                    );
                }
            }

            DB::commit();
            $response = ['ok' => true, 'message' => 'Producto actualizado exitosamente.'];
            $statusCode = 200;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar el producto en Provider/ProductController: ' . $e->getMessage());
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            foreach ($product->images as $img) {
                $this->imageService->delete($img->path);
            }
            $product->delete();
            return response()->json(['ok' => true, 'message' => 'Producto eliminado exitosamente.']);
        } catch (\Exception $e) {
            Log::error('Error al eliminar el producto en Provider/ProductController: ' . $e->getMessage());
            return response()->json(['ok' => false, 'message' => 'Error al eliminar el producto.'], 500);
        }
    }
}

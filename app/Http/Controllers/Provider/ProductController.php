<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;
use App\Http\Requests\Provider\ProductApiRequest;
use App\Http\Requests\Provider\StoreProductRequest;
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
                    'path' => $path
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
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

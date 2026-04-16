<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    
    public function api()
    {
        $response = ['ok' => false, 'message' => 'Error'];
        $statusCode = 500;

        try {
            $categories = Category::all();
            $response = ['ok' => true, 'message' => 'Categories fetched successfully', 'data' => CategoryResource::collection($categories)];
            $statusCode = 200;
        } catch (\Exception $e) {
            Log::error('Error fetching categories: ' . $e->getMessage());
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
